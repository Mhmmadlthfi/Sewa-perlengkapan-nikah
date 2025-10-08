<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            'categories' => Category::count(),
            'products' => Product::count(),
            'users' => User::where('role', 'customer')->count(),
            'order_status' => [
                'pending' => Order::where('status', 'pending')->count(),
                'confirmed' => Order::where('status', 'confirmed')->count(),
                'ongoing' => Order::where('status', 'ongoing')->count(),
                'completed' => Order::where('status', 'completed')->count(),
                'cancelled' => Order::where('status', 'cancelled')->count(),
            ],
            'payment_status' => [
                'paid' => Order::where('payment_status', 'paid')->count(),
                'unpaid' => Order::where('payment_status', 'unpaid')->count(),
            ]
        ];

        return view('dashboard.index', $data);
    }
}
