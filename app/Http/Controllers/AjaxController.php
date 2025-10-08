<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\ProductRental;

class AjaxController extends Controller
{
    public function productsTable(Request $request)
    {
        $query = Product::select(
            'id',
            'category_id',
            'name',
            'price',
            'unit',
            'stock'
        )->with(['category:id,name']);

        // Pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('unit', 'like', "%{$search}%")
                    ->orWhere('stock', 'like', "%{$search}%");
            });
        }

        // Filter Kategori
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $products = $query->paginate(10);

        foreach ($products as $product) {
            $product->can_delete = $product->orderItems()->count() == 0;
        }

        return view('product.partials.table', compact('products'));
    }

    public function ordersTable(Request $request)
    {
        $query = Order::select('id', 'user_id', 'total_price', 'order_date', 'status', 'payment_status')
            ->with(['user:id,name'])
            ->orderBy('id', 'desc');

        // Filter Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter Payment Status
        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        // Pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('id', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($q2) use ($search) {
                        $q2->where('name', 'like', "%{$search}%");
                    });
            });
        }

        $orders = $query->paginate(10);

        foreach ($orders as $order) {
            $order->can_delete = $order->items()->count() == 0;
        }

        $status = Order::getStatusOptions();
        $payment_status = Order::getPaymentStatusOptions();

        return view('order.partials.table', compact('orders', 'status', 'payment_status'));
    }

    public function usersTable(Request $request)
    {
        $query = User::select('id', 'name', 'email', 'phone', 'role', 'is_active');

        // Pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // Filter Role
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        // Filter Status
        if ($request->filled('is_active') && $request->is_active !== '') {
            $query->where('is_active', $request->is_active);
        }

        $users = $query->paginate(10);
        $roles = User::getRoleOptions();

        foreach ($users as $user) {
            $user->can_delete = $user->orders()->count() == 0;
        }

        return view('user.partials.table', compact('users', 'roles'));
    }

    // Product Select2
    public function productSelect(Request $request)
    {
        $data = Product::select('id', 'name', 'price', 'unit', 'stock')
            ->where('name', 'LIKE', '%' . $request->input('q') . '%')
            ->where('stock', '>', 0)
            ->paginate(5);

        return response()->json($data);
    }

    // User Select2
    public function userSelect(Request $request)
    {
        $data = User::select('id', 'name', 'email', 'phone')
            ->where(function ($query) use ($request) {
                $q = $request->input('q');
                $query->where('name', 'LIKE', '%' . $q . '%')
                    ->orWhere('email', 'LIKE', '%' . $q . '%')
                    ->orWhere('phone', 'LIKE', '%' . $q . '%');
            })
            ->where('role', '!=', 'admin')
            ->paginate(5);

        return response()->json($data);
    }

    public function checkAvailability(Request $request)
    {
        // Validasi input
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

            // Hitung total quantity yang sedang disewa
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
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => "Semua produk tersedia untuk tanggal sewa yang diminta.",
        ]);
    }
}
