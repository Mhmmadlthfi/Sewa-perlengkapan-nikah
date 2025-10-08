<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

class ProductsExport implements FromCollection, WithMapping, WithHeadings, WithColumnFormatting
{
    use Exportable;

    protected $categoryId;

    public function __construct($categoryId = null)
    {
        $this->categoryId = $categoryId;
    }

    public function collection()
    {
        $query = Product::with('category');

        if ($this->categoryId) {
            $query->where('category_id', $this->categoryId);
        }

        return $query->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Produk',
            'Harga',
            'Unit',
            'Stok',
            'Kategori',
            'Deskripsi',
        ];
    }

    public function map($product): array
    {
        static $no = 0;
        $no++;

        return [
            $no,
            $product->name,
            (int) $product->price,
            $product->unit,
            $product->stock,
            $product->category->name ?? '-',
            $product->description ?? 'Tidak ada deskripsi',
        ];
    }

    public function columnFormats(): array
    {
        return [
            'C' => NumberFormat::FORMAT_NUMBER,
        ];
    }
}
