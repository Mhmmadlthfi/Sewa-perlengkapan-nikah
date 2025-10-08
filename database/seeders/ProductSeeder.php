<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pertama kita perlu mendapatkan ID kategori
        $categories = DB::table('categories')->pluck('id', 'name');

        $products = [
            // Dekorasi & Panggung
            [
                'category_id' => $categories['Dekorasi & Panggung'],
                'name' => 'Dekorasi Klasik',
                'price' => 8000000,
                'unit' => 'paket',
                'stock' => 1,
            ],
            [
                'category_id' => $categories['Dekorasi & Panggung'],
                'name' => 'Dekorasi Modern',
                'price' => 6000000,
                'unit' => 'paket',
                'stock' => 1,
            ],
            [
                'category_id' => $categories['Dekorasi & Panggung'],
                'name' => 'Panggung electone',
                'price' => 300000,
                'unit' => 'set',
                'stock' => 5,
            ],
            [
                'category_id' => $categories['Dekorasi & Panggung'],
                'name' => 'Tenda plafon putih polos',
                'price' => 400000,
                'unit' => 'set',
                'stock' => 8,
            ],
            [
                'category_id' => $categories['Dekorasi & Panggung'],
                'name' => 'Tenda Lengkung',
                'price' => 500000,
                'unit' => 'set',
                'stock' => 6,
            ],
            [
                'category_id' => $categories['Dekorasi & Panggung'],
                'name' => 'Tenda standart tanpa plafon',
                'price' => 300000,
                'unit' => 'meter',
                'stock' => 15,
            ],
            [
                'category_id' => $categories['Dekorasi & Panggung'],
                'name' => 'Plafon variasi broklat',
                'price' => 25000,
                'unit' => 'meter',
                'stock' => 20,
            ],
            [
                'category_id' => $categories['Dekorasi & Panggung'],
                'name' => 'Kain Dinding wiru',
                'price' => 25000,
                'unit' => 'biji',
                'stock' => 30,
            ],
            [
                'category_id' => $categories['Dekorasi & Panggung'],
                'name' => 'Stand foto',
                'price' => 35000,
                'unit' => 'biji',
                'stock' => 15,
            ],

            // Sound System & Elektronik
            [
                'category_id' => $categories['Sound System & Elektronik'],
                'name' => 'Sound + Disel utk Electone',
                'price' => 5000000,
                'unit' => 'paket',
                'stock' => 1,
            ],
            [
                'category_id' => $categories['Sound System & Elektronik'],
                'name' => 'Kipas angin besi biasa',
                'price' => 75000,
                'unit' => 'biji',
                'stock' => 10,
            ],
            [
                'category_id' => $categories['Sound System & Elektronik'],
                'name' => 'Kipas Blower air',
                'price' => 250000,
                'unit' => 'biji',
                'stock' => 5,
            ],
            [
                'category_id' => $categories['Sound System & Elektronik'],
                'name' => 'Alat Komunikasi HT',
                'price' => 25000,
                'unit' => 'biji',
                'stock' => 8,
            ],

            // Furniture
            [
                'category_id' => $categories['Furniture'],
                'name' => 'Kursi Hotel',
                'price' => 5000,
                'unit' => 'biji',
                'stock' => 50,
            ],
            [
                'category_id' => $categories['Furniture'],
                'name' => 'Kursi Lipat',
                'price' => 4000,
                'unit' => 'biji',
                'stock' => 100,
            ],
            [
                'category_id' => $categories['Furniture'],
                'name' => 'Kursi seng',
                'price' => 2000,
                'unit' => 'biji',
                'stock' => 80,
            ],
            [
                'category_id' => $categories['Furniture'],
                'name' => 'Meja + Taplak',
                'price' => 7500,
                'unit' => 'set',
                'stock' => 30,
            ],
            [
                'category_id' => $categories['Furniture'],
                'name' => 'Meja prasmanan snack & buku tamu',
                'price' => 240000,
                'unit' => 'biji',
                'stock' => 5,
            ],
            [
                'category_id' => $categories['Furniture'],
                'name' => 'Gubuk saji + 2 meja(per set)',
                'price' => 120000,
                'unit' => 'biji',
                'stock' => 8,
            ],

            // Peralatan Makan
            [
                'category_id' => $categories['Peralatan Makan'],
                'name' => 'Piring makan ceper + sendok',
                'price' => 1200,
                'unit' => 'biji',
                'stock' => 200,
            ],
            [
                'category_id' => $categories['Peralatan Makan'],
                'name' => 'Piring makan biasa + sendok',
                'price' => 800,
                'unit' => 'biji',
                'stock' => 200,
            ],
            [
                'category_id' => $categories['Peralatan Makan'],
                'name' => 'Piring sate sendok',
                'price' => 700,
                'unit' => 'biji',
                'stock' => 150,
            ],
            [
                'category_id' => $categories['Peralatan Makan'],
                'name' => 'Mangkok bakso+sendok',
                'price' => 700,
                'unit' => 'biji',
                'stock' => 150,
            ],
            [
                'category_id' => $categories['Peralatan Makan'],
                'name' => 'Mangkok soto sendok',
                'price' => 700,
                'unit' => 'biji',
                'stock' => 150,
            ],
            [
                'category_id' => $categories['Peralatan Makan'],
                'name' => 'Mangkok es/dawet + sdk',
                'price' => 600,
                'unit' => 'biji',
                'stock' => 100,
            ],
            [
                'category_id' => $categories['Peralatan Makan'],
                'name' => 'Gelas teh tutup',
                'price' => 500,
                'unit' => 'biji',
                'stock' => 200,
            ],
            [
                'category_id' => $categories['Peralatan Makan'],
                'name' => 'Gelas essendok',
                'price' => 600,
                'unit' => 'biji',
                'stock' => 150,
            ],
            [
                'category_id' => $categories['Peralatan Makan'],
                'name' => 'Gelas softdrink',
                'price' => 300,
                'unit' => 'set',
                'stock' => 100,
            ],
            [
                'category_id' => $categories['Peralatan Makan'],
                'name' => 'Nampan snack + buah',
                'price' => 5000,
                'unit' => 'biji',
                'stock' => 30,
            ],
            [
                'category_id' => $categories['Peralatan Makan'],
                'name' => 'Lepek snack',
                'price' => 300,
                'unit' => 'biji',
                'stock' => 50,
            ],

            // Peralatan Dapur & Catering
            [
                'category_id' => $categories['Peralatan Dapur & Catering'],
                'name' => 'Alat Prasmanan Roll top',
                'price' => 400000,
                'unit' => 'set',
                'stock' => 5,
            ],
            [
                'category_id' => $categories['Peralatan Dapur & Catering'],
                'name' => 'Alat Prasmanan Taggung',
                'price' => 200000,
                'unit' => 'set',
                'stock' => 5,
            ],
            [
                'category_id' => $categories['Peralatan Dapur & Catering'],
                'name' => 'Alat Prasmanan Kecil',
                'price' => 125000,
                'unit' => 'biji',
                'stock' => 8,
            ],
            [
                'category_id' => $categories['Peralatan Dapur & Catering'],
                'name' => 'Krat tempat piring kotor',
                'price' => 10000,
                'unit' => 'set',
                'stock' => 15,
            ],
            [
                'category_id' => $categories['Peralatan Dapur & Catering'],
                'name' => 'Patehan (Jeding, teko, baki)',
                'price' => 100000,
                'unit' => 'biji',
                'stock' => 10,
            ],
            [
                'category_id' => $categories['Peralatan Dapur & Catering'],
                'name' => 'Soblok adang',
                'price' => 50000,
                'unit' => 'biji',
                'stock' => 10,
            ],
            [
                'category_id' => $categories['Peralatan Dapur & Catering'],
                'name' => 'Soblok bakso',
                'price' => 40000,
                'unit' => 'biji',
                'stock' => 10,
            ],
            [
                'category_id' => $categories['Peralatan Dapur & Catering'],
                'name' => 'Panci kuping besar',
                'price' => 35000,
                'unit' => 'biji',
                'stock' => 15,
            ],
            [
                'category_id' => $categories['Peralatan Dapur & Catering'],
                'name' => 'Wajan + sothil',
                'price' => 30000,
                'unit' => 'biji',
                'stock' => 15,
            ],
            [
                'category_id' => $categories['Peralatan Dapur & Catering'],
                'name' => 'Waskom',
                'price' => 7500,
                'unit' => 'biji',
                'stock' => 20,
            ],
            [
                'category_id' => $categories['Peralatan Dapur & Catering'],
                'name' => 'Cething centong',
                'price' => 5000,
                'unit' => 'biji',
                'stock' => 20,
            ],
            [
                'category_id' => $categories['Peralatan Dapur & Catering'],
                'name' => 'Rantang sayur + sendok sy',
                'price' => 5000,
                'unit' => 'biji',
                'stock' => 15,
            ],
            [
                'category_id' => $categories['Peralatan Dapur & Catering'],
                'name' => 'Bak asahan',
                'price' => 5000,
                'unit' => 'biji',
                'stock' => 10,
            ],

            // Peralatan Minuman
            [
                'category_id' => $categories['Peralatan Minuman'],
                'name' => 'Dispenser soft drink',
                'price' => 75000,
                'unit' => 'biji',
                'stock' => 5,
            ],
            [
                'category_id' => $categories['Peralatan Minuman'],
                'name' => 'Dispenser Teh',
                'price' => 50000,
                'unit' => 'set',
                'stock' => 5,
            ],

            // Peralatan Tambahan
            [
                'category_id' => $categories['Peralatan Tambahan'],
                'name' => 'Drum air',
                'price' => 20000,
                'unit' => 'biji',
                'stock' => 10,
            ],
            [
                'category_id' => $categories['Peralatan Tambahan'],
                'name' => 'Kotak amplop',
                'price' => 50000,
                'unit' => 'biji',
                'stock' => 5,
            ],

            // Produk Demo
            [
                'category_id' => $categories['Kategori Demo'],
                'name' => 'Produk Demo 1',
                'price' => 10000,
                'unit' => 'biji',
                'stock' => 10,
            ],
            [
                'category_id' => $categories['Kategori Demo'],
                'name' => 'Produk Demo 2',
                'price' => 20000,
                'unit' => 'set',
                'stock' => 5,
            ],
        ];

        foreach ($products as &$product) {
            if ($product['stock'] < 100) {
                $product['stock'] += 500;
            }
        }

        unset($product);
        
        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
