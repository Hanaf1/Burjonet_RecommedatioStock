<?php

namespace App\Http\Controllers;

use App\Models\Product;

// use Illuminate\Http\Request;

class RekomendasiController extends Controller
{public function index()
    {
        $produk = Product::with(['stok' => function ($query) {
            $query->latest('tanggal')->take(7);
        }])->get();

        $rekomendasi = [];

        foreach ($produk as $item) {
            $rataJualHarian = $item->stok->avg('jumlah_terjual');
            $stokSekarang = $item->stok->first()->jumlah ?? 0;

            if ($stokSekarang < ($rataJualHarian * 3) || $stokSekarang < $item->stok_minimum) {
                $rekomendasiBeli = max(
                    ($rataJualHarian * 7) - $stokSekarang,
                    $item->stok_minimum - $stokSekarang
                );

                $rekomendasi[] = [
                    'produk' => $item->nama,
                    'stok_sekarang' => $stokSekarang,
                    'rekomendasi_beli' => ceil($rekomendasiBeli),
                    'rata_jual_harian' => round($rataJualHarian, 2)
                ];
            }
        }

        return response()->json($rekomendasi);
    }
}
