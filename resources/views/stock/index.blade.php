<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 gap-6">
                <!-- Summary Cards -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Total Stock -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">Total Stok Hari Ini</h3>
                        <p class="text-3xl font-bold text-blue-600">
                            {{ number_format($stok->sum(function($item) {
                                return $item->jumlah + $item->jumlah_beli - $item->jumlah_terjual;
                            })) }}
                        </p>
                    </div>

                    <!-- Total Sales -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">Penjualan Hari Ini</h3>
                        <p class="text-3xl font-bold text-green-600">
                            {{ number_format($stok->sum('jumlah_terjual')) }}
                        </p>
                    </div>

                    <!-- Total Purchases -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">Pembelian Hari Ini</h3>
                        <p class="text-3xl font-bold text-indigo-600">
                            {{ number_format($stok->sum('jumlah_beli')) }}
                        </p>
                    </div>
                </div>

                <!-- Daily Stock Overview -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h2 class="text-2xl font-bold mb-4 text-gray-800">Ikhtisar Stok</h2>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead>
                                    <tr class="bg-gray-50">
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produk</th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Stok Awal</th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Dibeli</th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Terjual</th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Stok Saat Ini</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($stok as $item)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $item->produk->nama }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-right text-gray-500">{{ number_format($item->jumlah) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-right text-gray-500">{{ number_format($item->jumlah_beli) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-right text-gray-500">{{ number_format($item->jumlah_terjual) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-medium text-gray-900">
                                            {{ number_format($item->jumlah + $item->jumlah_beli - $item->jumlah_terjual) }}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Statistics Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Weekly Summary -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold mb-4 text-gray-800">Ringkasan Mingguan</h3>
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead>
                                        <tr class="bg-gray-50">
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produk</th>
                                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Total Pembelian</th>
                                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Total Penjualan</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($statistikMingguan as $stat)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $stat->produk->nama }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-right text-gray-500">{{ number_format($stat->total_beli) }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-right text-gray-500">{{ number_format($stat->total_terjual) }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Monthly Summary -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold mb-4 text-gray-800">Ringkasan Bulanan</h3>
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead>
                                        <tr class="bg-gray-50">
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produk</th>
                                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Total Pembelian</th>
                                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Total Penjualan</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($statistikBulanan as $stat)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $stat->produk->nama }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-right text-gray-500">{{ number_format($stat->total_beli) }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-right text-gray-500">{{ number_format($stat->total_terjual) }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Stock Recommendations -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Rekomendasi Stok</h3>
                        @if(count($rekomendasi) > 0)
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead>
                                        <tr class="bg-gray-50">
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produk</th>
                                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Stok Saat Ini</th>
                                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Rata-rata Penjualan Harian</th>
                                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Rekomendasi Pembelian</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($rekomendasi as $item)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $item['produk'] }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-right text-gray-500">{{ number_format($item['stok_sekarang']) }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-right text-gray-500">{{ number_format($item['rata_jual_harian'], 2) }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-medium {{ $item['rekomendasi_beli'] > 0 ? 'text-red-600' : 'text-gray-900' }}">
                                                {{ number_format($item['rekomendasi_beli']) }}
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-gray-500 text-sm">Tidak ada rekomendasi pembelian saat ini.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
