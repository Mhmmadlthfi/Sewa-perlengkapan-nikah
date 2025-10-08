<?php

namespace App\Http\Controllers\Api;

use Midtrans\Snap;
use App\Models\User;
use Midtrans\Config;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use App\Models\OrderItem;
use Midtrans\Transaction;
use Illuminate\Http\Request;
use App\Models\ProductRental;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class MobileController extends Controller
{
    public function __construct()
    {
        // Konfigurasi Midtrans
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    public function categories()
    {
        return response()->json([
            'status' => true,
            'categories' => Category::all()
        ], 200);
    }

    public function products(Request $request)
    {
        $productsQuery = Product::with(['category:id,name']);

        if ($request->has('category_id') && $request->category_id != 'all') {
            $productsQuery->where('category_id', $request->category_id);
        }

        if ($request->has('search') && !empty($request->search)) {
            $productsQuery->where('name', 'like', '%' . $request->search . '%');
        }

        // Pagination
        $products = $productsQuery->paginate(10);

        return response()->json([
            'status' => true,
            'products' => $products
        ], 200);
    }

    public function checkAvailability(Request $request)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'required|integer|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'rental_start' => 'required|date',
            'rental_end' => 'required|date|after_or_equal:rental_start',
        ]);

        $errors = [];
        $rentalStart = $request->input('rental_start');
        $rentalEnd = $request->input('rental_end');

        foreach ($request->input('items') as $item) {
            $productId = $item['id'];
            $qtyRequested = $item['quantity'];

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
                $errors[] = "Stok produk '{$product->name}' hanya tersedia {$availableQty} unit untuk tanggal tersebut.";
            }
        }

        if (!empty($errors)) {
            return response()->json([
                'success' => false,
                'message' => implode("\n", $errors),
            ], 400);
        }

        return response()->json([
            'success' => true,
            'message' => "Semua produk tersedia untuk tanggal sewa yang diminta.",
        ]);
    }

    public function orderStore(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'rental_start' => 'required|date|after_or_equal:today',
            'rental_end' => 'required|date|after_or_equal:rental_start',
            'address' => 'required|string|max:255',
            'notes' => 'nullable|string|max:1000',
            'items' => 'required|array|min:1',
            'items.*.id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            $rentalStart = $validated['rental_start'];
            $rentalEnd = $validated['rental_end'];

            // Validasi ketersediaan stok
            foreach ($validated['items'] as $item) {
                $productId = $item['id'];
                $qtyRequested = $item['quantity'];

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

            // Hitung total harga
            $total = array_reduce($validated['items'], function ($carry, $item) {
                return $carry + ($item['price'] * $item['quantity']);
            }, 0);

            // Buat order
            $order = Order::create([
                'user_id' => $validated['user_id'],
                'total_price' => $total,
                'order_date' => now(),
                'rental_start' => $rentalStart,
                'rental_end' => $rentalEnd,
                'address' => $validated['address'],
                'notes' => $validated['notes'] ?? null,
            ]);

            foreach ($validated['items'] as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);

                ProductRental::create([
                    'product_id' => $item['id'],
                    'order_id' => $order->id,
                    'rental_start' => $rentalStart,
                    'rental_end' => $rentalEnd,
                    'quantity' => $item['quantity'],
                ]);
            }

            // Generate order_code
            $orderCode = 'ORD-' . date('Ymd') . '-' . str_pad($order->id, 4, '0', STR_PAD_LEFT);
            $order->order_code = $orderCode;
            $order->save();

            // Prepare item details for Midtrans
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

            // Prepare Midtrans parameters
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

            // Create transaction with Midtrans
            $midtransResponse = Snap::createTransaction($params);
            $snapToken = $midtransResponse->token ?? null;
            $order->snap_token = $snapToken;
            $order->payment_response = json_encode($midtransResponse);
            $order->save();

            DB::commit();

            return response()->json([
                'success' => true,
                'order_id' => $order->id,
                'order_code' => $order->order_code,
                'snap_token' => $snapToken,
                'total_price' => $order->total_price,
                'message' => 'Order rental berhasil dibuat',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    public function getUserOrders(Request $request)
    {
        try {
            $user = $request->user();
            $orders = Order::where('user_id', $user->id)
                ->orderBy('order_date', 'desc')
                ->get([
                    'id',
                    'order_code',
                    'user_id',
                    'total_price',
                    'order_date',
                    'rental_start',
                    'rental_end',
                    'status',
                    'payment_status',
                    'snap_token',
                    'address',
                    // 'delivery_fee',
                    'notes'
                ]);

            return response()->json([
                'success' => true,
                'data' => $orders,
                'message' => 'Data order berhasil diambil'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data order: ' . $e->getMessage()
            ], 500);
        }
    }

    public function showOrderDetail(Request $request, $orderId)
    {
        try {
            $user = $request->user();

            $order = Order::where('id', $orderId)
                ->where('user_id', $user->id)
                ->with('items.product')
                ->first([
                    'id',
                    'order_code',
                    'user_id',
                    'total_price',
                    'order_date',
                    'rental_start',
                    'rental_end',
                    'status',
                    'payment_status',
                    'snap_token',
                    'address',
                    // 'delivery_fee',
                    'notes',
                    'created_at',
                    'updated_at'
                ]);

            if (!$order) {
                return response()->json([
                    'success' => false,
                    'message' => 'Order tidak ditemukan'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $order,
                'message' => 'Detail order berhasil diambil'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil detail order: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getSnapToken(Request $request, $orderId)
    {
        try {
            $user = $request->user();

            $order = Order::where('id', $orderId)
                ->where('user_id', $user->id)
                ->first(['id', 'order_code', 'snap_token', 'payment_status']);

            if (!$order) {
                return response()->json([
                    'success' => false,
                    'message' => 'Order tidak ditemukan'
                ], 404);
            }

            if ($order->payment_status === 'paid') {
                return response()->json([
                    'success' => false,
                    'message' => 'Order sudah dibayar'
                ], 400);
            }

            return response()->json([
                'success' => true,
                'snap_token' => $order->snap_token,
                'order_code' => $order->order_code,
                'message' => 'Snap token berhasil diambil'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil snap token: ' . $e->getMessage()
            ], 500);
        }
    }

    public function checkPaymentStatus($orderId)
    {
        $order = Order::findOrFail($orderId);

        // Jika tidak ada token, langsung return
        if (!$order->snap_token) {
            return response()->json(['status' => 'no_token']);
        }

        try {
            $status = Transaction::status($order->id);

            // Jika status Midtrans sudah expired
            if ($status->transaction_status === 'expire') {
                // Tandai juga di database kamu
                $order->payment_status = 'expired';
                $order->save();

                return response()->json(['status' => 'expired']);
            }

            // Jika masih pending
            if ($status->transaction_status === 'pending') {
                return response()->json(['status' => 'pending']);
            }

            // Jika sudah dibayar
            if ($status->transaction_status === 'settlement') {
                $order->payment_status = 'paid';
                $order->save();
                return response()->json(['status' => 'paid']);
            }

            return response()->json(['status' => $status->transaction_status]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function regenerateSnap($orderId)
    {
        $order = Order::findOrFail($orderId);

        // Pastikan order belum dibayar
        if ($order->payment_status === 'paid') {
            return response()->json(['success' => false, 'message' => 'Order sudah dibayar.']);
        }

        $orderCode = 'ORD-' . date('Ymd') . '-' . str_pad($order->id, 4, '0', STR_PAD_LEFT);
        $order->order_code = $orderCode;
        $order->save();

        // Generate token baru dari Midtrans
        $params = [
            'transaction_details' => [
                'order_id' => $order->order_code,
                'gross_amount' => $order->total_price,
            ],
            'customer_details' => [
                'first_name' => $order->user->name,
                'email' => $order->user->email,
            ],
        ];

        $snapToken = Snap::getSnapToken($params);

        // Simpan token baru ke database
        $order->snap_token = $snapToken;
        $order->save();

        return response()->json([
            'success' => true,
            'snap_token' => $snapToken,
            'message' => 'Token pembayaran baru berhasil dibuat.',
        ]);
    }
}
