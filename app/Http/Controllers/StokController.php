<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Stok;
use Carbon\Carbon;

class StokController extends Controller
{
    public function index()
    {
        $stok = Stok::with('produk')
            ->whereDate('tanggal', Carbon::today())
            ->get();

        $statistikMingguan = $this->getStatistikMingguan();
        $statistikBulanan = $this->getStatistikBulanan();
        $rekomendasi = $this->generateRekomendasi();

        return view('stock.index', compact(
            'stok',
            'statistikMingguan',
            'statistikBulanan',
            'rekomendasi'
        ));
    }

    private function getStatistikMingguan()
    {
        $awalMinggu = Carbon::now()->startOfWeek();
        $akhirMinggu = Carbon::now()->endOfWeek();

        return Stok::whereBetween('tanggal', [$awalMinggu, $akhirMinggu])
            ->selectRaw('
                product_id,
                SUM(jumlah) as total_jumlah,
                SUM(jumlah_beli) as total_beli,
                SUM(jumlah_terjual) as total_terjual
            ')
            ->groupBy('product_id')
            ->with('produk')
            ->get();
    }

    private function getStatistikBulanan()
    {
        $awalBulan = Carbon::now()->startOfMonth();
        $akhirBulan = Carbon::now()->endOfMonth();

        return Stok::whereBetween('tanggal', [$awalBulan, $akhirBulan])
            ->selectRaw('
                product_id,
                SUM(jumlah) as total_jumlah,
                SUM(jumlah_beli) as total_beli,
                SUM(jumlah_terjual) as total_terjual
            ')
            ->groupBy('product_id')
            ->with('produk')
            ->get();
    }

    private function generateRekomendasi()
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

        return $rekomendasi;
    }

    public function getRekomendasi()
    {
        return response()->json($this->generateRekomendasi());
    }
}
