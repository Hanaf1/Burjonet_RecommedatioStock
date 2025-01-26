<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Stok;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'nama' => 'Beras',
                'deskripsi' => 'Beras premium',
                'stok_minimum' => 50
            ],
            [
                'nama' => 'Gula',
                'deskripsi' => 'Gula pasir',
                'stok_minimum' => 30
            ],
            [
                'nama' => 'Minyak Goreng',
                'deskripsi' => 'Minyak goreng kemasan 1L',
                'stok_minimum' => 40
            ],
            [
                'nama' => 'Telur',
                'deskripsi' => 'Telur ayam per kg',
                'stok_minimum' => 20
            ],
            [
                'nama' => 'Tepung Terigu',
                'deskripsi' => 'Tepung terigu premium 1kg',
                'stok_minimum' => 25
            ]
        ];

        foreach ($products as $product) {
            $p = Product::create($product);

            // Buat data stok untuk 30 hari terakhir
            for ($i = 29; $i >= 0; $i--) {
                $date = Carbon::now()->subDays($i);

                // Generate random numbers for stock movement
                $jumlah = rand(20, 100);
                $jumlah_beli = rand(5, 20);
                $jumlah_terjual = rand(5, 15);

                Stok::create([
                    'product_id' => $p->id,
                    'jumlah' => $jumlah,
                    'jumlah_beli' => $jumlah_beli,
                    'jumlah_terjual' => $jumlah_terjual,
                    'tanggal' => $date
                ]);
            }
        }
    }
}
