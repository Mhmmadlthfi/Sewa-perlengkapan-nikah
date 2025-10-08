<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\Exportable;

class OrdersExport implements WithMultipleSheets
{
    use Exportable;

    protected $filters;

    public function __construct($filters)
    {
        $this->filters = $filters;
    }

    public function sheets(): array
    {
        return [
            'Data Pesanan' => new OrdersMainSheet($this->filters),
            'Detail Produk' => new OrderItemsSheet($this->filters),
        ];
    }
}

class OrdersMainSheet implements FromCollection, WithHeadings, WithMapping
{
    protected $filters;

    public function __construct($filters)
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        $query = Order::with(['user', 'items.product'])
            ->orderBy('order_date', 'desc');

        if (!empty($this->filters['status'])) {
            $query->where('status', $this->filters['status']);
        }

        if (!empty($this->filters['payment_status'])) {
            $query->where('payment_status', $this->filters['payment_status']);
        }

        if (!empty($this->filters['month'])) {
            $query->whereMonth('order_date', $this->filters['month']);
        }

        if (!empty($this->filters['year'])) {
            $query->whereYear('order_date', $this->filters['year']);
        }

        return $query->get();
    }

    public function headings(): array
    {
        return [
            'ID Order',
            'Nama Pelanggan',
            'No. Telepon',
            'Tanggal Pesanan',
            'Mulai Sewa',
            'Akhir Sewa',
            'Status Order',
            'Status Pembayaran',
            'Alamat',
            'Total Harga',
            'Biaya Pengiriman',
            'Total Biaya Keseluruhan',
            'Catatan'
        ];
    }

    public function map($order): array
    {
        return [
            $order->id,
            $order->user->name,
            $order->user->phone,
            $order->order_date,
            $order->rental_start->format('Y-m-d'),
            $order->rental_end->format('Y-m-d'),
            $order->status,
            $order->payment_status,
            $order->address,
            $order->total_price,
            $order->delivery_fee,
            $order->total_price + $order->delivery_fee,
            $order->notes ? $order->notes : '-'
        ];
    }
}

class OrderItemsSheet implements FromCollection, WithHeadings, WithMapping
{
    protected $filters;

    public function __construct($filters)
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        $query = Order::with(['items.product'])
            ->orderBy('order_date', 'desc');

        if (!empty($this->filters['status'])) {
            $query->where('status', $this->filters['status']);
        }

        if (!empty($this->filters['payment_status'])) {
            $query->where('payment_status', $this->filters['payment_status']);
        }

        if (!empty($this->filters['month'])) {
            $query->whereMonth('order_date', $this->filters['month']);
        }

        if (!empty($this->filters['year'])) {
            $query->whereYear('order_date', $this->filters['year']);
        }

        $orders = $query->get();

        $items = collect();
        foreach ($orders as $order) {
            foreach ($order->items as $item) {
                $items->push([
                    'order_id' => $order->id,
                    'product_name' => $item->product->name,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                    'subtotal' => $item->quantity * $item->price
                ]);
            }
        }

        return $items;
    }

    public function headings(): array
    {
        return [
            'ID Order',
            'Nama Produk',
            'Jumlah',
            'Harga Satuan',
            'Subtotal'
        ];
    }

    public function map($item): array
    {
        return [
            $item['order_id'],
            $item['product_name'],
            $item['quantity'],
            $item['price'],
            $item['subtotal']
        ];
    }
}
