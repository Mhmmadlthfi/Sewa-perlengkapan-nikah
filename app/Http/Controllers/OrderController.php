<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Exports\OrdersExport;
use App\Models\ProductRental;
use Illuminate\Support\Facades\DB;
use Midtrans\Config;
use Midtrans\Snap;

class OrderController extends Controller
{
    public function __construct()
    {
        // Konfigurasi Midtrans
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    public function export(Request $request)
    {
        $filters = $request->only(['status', 'payment_status', 'month', 'year']);

        $query = Order::with(['user', 'orderItems.product']);

        if ($request->filled('status')) {
            $query->where('status', $filters['status']);
        }

        if ($request->filled('payment_status')) {
            $query->where('payment_status', $filters['payment_status']);
        }

        if ($request->filled('month')) {
            $query->whereMonth('order_date', $filters['month']);
        }

        if ($request->filled('year')) {
            $query->whereYear('order_date', $filters['year']);
        }

        $dataExists = $query->exists();

        if ($dataExists) {
            return (new OrdersExport($filters))->download('DataPesanan.xlsx');
        } else {
            return redirect()->back()->with('error', 'Tidak ada data yang sesuai untuk diekspor.');
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::select(
            'id',
            'order_code',
            'user_id',
            'total_price',
            'order_date',
            'status',
            'payment_status'
        )->orderBy('id', 'desc')->paginate(10);

        foreach ($orders as $order) {
            $order->can_delete = $order->items()->count() == 0;
        }

        $status = Order::getStatusOptions();
        $paymentStatus = Order::getPaymentStatusOptions();

        return view('order.index', compact('orders', 'status', 'paymentStatus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::select('id', 'name', 'email', 'phone')->get();

        $products = Product::select(
            'id',
            'category_id',
            'name',
            'price',
            'unit',
            'stock'
        )->with(['category:id,name'])->paginate(10);

        return view('order.create', compact('users', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = json_decode($request->json_payload, true);

        $validated = validator($data, [
            'user.id' => 'required|exists:users,id',
            'rental_start' => 'required|date|after_or_equal:today',
            'rental_end' => 'required|date|after_or_equal:rental_start',
            'address' => 'required|string|max:255',
            // 'delivery_fee' => 'required|numeric|min:0',
            'notes' => 'nullable|string|max:1000',
            'items' => 'required|array|min:1',
            'items.*.id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
            'total' => 'required|numeric|min:0',
            // 'finalTotal' => 'required|numeric|min:0',
        ])->validate();

        DB::beginTransaction();
        try {
            $rentalStart = $validated['rental_start'];
            $rentalEnd = $validated['rental_end'];

            foreach ($validated['items'] as $item) {
                $productId = $item['id'];
                $qtyRequested = $item['quantity'];

                // Hitung total qty yang sedang disewa untuk produk ini di rentang waktu yang tumpang tindih
                $qtyRented = ProductRental::where('product_id', $productId)
                    ->where(function ($query) use ($rentalStart, $rentalEnd) {
                        $query->whereBetween('rental_start', [$rentalStart, $rentalEnd])
                            ->orWhereBetween('rental_end', [$rentalStart, $rentalEnd])
                            ->orWhere(function ($query) use ($rentalStart, $rentalEnd) {
                                $query->where('rental_start', '<=', $rentalStart)
                                    ->where('rental_end', '>=', $rentalEnd);
                            });
                    })
                    ->sum('quantity');

                $product = Product::findOrFail($productId);
                $availableQty = max(0, $product->stock - $qtyRented);

                if ($availableQty < $qtyRequested) {
                    throw new \Exception("Produk '{$product->name}' hanya tersedia {$availableQty} unit untuk tanggal tersebut.");
                }
            }

            // Buat order
            $order = Order::create([
                'user_id' => $validated['user']['id'],
                'total_price' => $validated['total'],
                'order_date' => now(),
                'rental_start' => $rentalStart,
                'rental_end' => $rentalEnd,
                'address' => $validated['address'],
                // 'delivery_fee' => $validated['delivery_fee'],
                'notes' => $validated['notes'],
            ]);

            foreach ($validated['items'] as $item) {
                // Simpan ke order_items
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);

                // Simpan ke product_rentals
                ProductRental::create([
                    'product_id' => $item['id'],
                    'order_id' => $order->id,
                    'rental_start' => $rentalStart,
                    'rental_end' => $rentalEnd,
                    'quantity' => $item['quantity'],
                ]);
            }

            $orderCode = 'ORD-' . date('Ymd') . '-' . str_pad($order->id, 4, '0', STR_PAD_LEFT);
            $order->order_code = $orderCode;
            $order->save();

            $itemDetails = [];
            foreach ($validated['items'] as $item) {
                $product = Product::find($item['id']);
                $itemDetails[] = [
                    'id' => $product->id,
                    'price' => $item['price'],
                    'quantity' => $item['quantity'],
                    'name' => $product->name,
                ];
            }

            $params = [
                'transaction_details' => [
                    'order_id' => $order->order_code,
                    'gross_amount' => $order->total_price,
                ],
                'customer_details' => [
                    'first_name' => $order->user->name,
                    'email' => $order->user->email,
                    'phone' => $order->user->phone,
                ],
                'item_details' => $itemDetails,
            ];

            $midtransResponse = Snap::createTransaction($params);
            $snapToken = $midtransResponse->token ?? null;
            $order->snap_token = $snapToken;
            $order->payment_response = json_encode($midtransResponse);
            $order->save();

            DB::commit();

            return response()->json([
                'success' => true,
                'snap_token' => $snapToken,
                'redirect' => route('payment.finish'),
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        return view('order.show', compact('order'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('order.index')->with('success', "Berhasil menghapus data order dengan Order ID $order->id");
    }

    public function statusUpdate(Request $request, Order $order)
    {
        $validated = $request->validate([
            "id" => "required|numeric",
            "status" => "required"
        ]);

        $order->update([
            'status' => $validated['status']
        ]);

        return redirect()->back()->with('success', "Berhasil update status order dari Order ID $order->id");
    }

    public function statusPaymentUpdate(Request $request, Order $order)
    {
        $validated = $request->validate([
            "id" => "required|numeric",
            "payment_status" => "required"
        ]);

        $order->update([
            'payment_status' => $validated['payment_status']
        ]);

        return redirect()->back()->with('success', "Berhasil update payment status order dari Order ID $order->id");
    }

    // public function deliveryFeeUpdate(Request $request, Order $order)
    // {
    //     $validated = $request->validate([
    //         "id" => "required|numeric",
    //         "delivery_fee" => "required"
    //     ]);

    //     $order->update([
    //         'delivery_fee' => $validated['delivery_fee']
    //     ]);

    //     return redirect()->back()->with('success', "Berhasil update biaya pengiriman dari Order ID $order->id");
    // }
}
