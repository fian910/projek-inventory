<x-app-layout>
    <div class="container mx-auto p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-semibold text-white">Riwayat Transaksi</h1>
            <a href="{{ route('transactions.export') }}" 
               class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg">
                Export CSV
            </a>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-gray-800 p-4 rounded-lg shadow">
                <h3 class="text-gray-400 text-sm">Total Transaksi</h3>
                <p class="text-white text-xl font-bold">{{ number_format($summary['total_transactions']) }}</p>
            </div>
            <div class="bg-gray-800 p-4 rounded-lg shadow">
                <h3 class="text-gray-400 text-sm">Total Pendapatan</h3>
                <p class="text-white text-xl font-bold">Rp{{ number_format($summary['total_amount'], 0, ',', '.') }}</p>
            </div>
            <div class="bg-gray-800 p-4 rounded-lg shadow">
                <h3 class="text-gray-400 text-sm">Total Item Terjual</h3>
                <p class="text-white text-xl font-bold">{{ number_format($summary['total_items']) }}</p>
            </div>
            <div class="bg-gray-800 p-4 rounded-lg shadow">
                <h3 class="text-gray-400 text-sm">Rata-rata Transaksi</h3>
                <p class="text-white text-xl font-bold">Rp{{ number_format($summary['average_amount'], 0, ',', '.') }}</p>
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-gray-800 p-4 rounded-lg shadow-lg mb-6">
            <form action="{{ route('transactions.index') }}" method="GET" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <!-- Pencarian Nama Barang -->
                    <div>
                        <label for="search_name" class="block text-sm font-medium text-gray-400 mb-1">Nama Barang</label>
                        <input type="text" 
                               id="search_name" 
                               name="search_name" 
                               placeholder="Cari nama barang..." 
                               class="w-full px-4 py-2 bg-gray-700 text-white rounded-lg focus:ring-2 focus:ring-blue-500"
                               value="{{ request('search_name') }}">
                    </div>

                    <!-- Pencarian Kode Barang -->
                    <div>
                        <label for="search_code" class="block text-sm font-medium text-gray-400 mb-1">Kode Barang</label>
                        <input type="text" 
                               id="search_code" 
                               name="search_code" 
                               placeholder="Cari kode barang..." 
                               class="w-full px-4 py-2 bg-gray-700 text-white rounded-lg focus:ring-2 focus:ring-blue-500"
                               value="{{ request('search_code') }}">
                    </div>

                    <!-- Kategori Period -->
                    <div>
                        <label for="period" class="block text-sm font-medium text-gray-400 mb-1">Periode</label>
                        <select id="period" 
                                name="period" 
                                class="w-full px-4 py-2 bg-gray-700 text-white rounded-lg focus:ring-2 focus:ring-blue-500">
                            <option value="">Pilih Periode</option>
                            <option value="today" {{ request('period') == 'today' ? 'selected' : '' }}>Hari Ini</option>
                            <option value="yesterday" {{ request('period') == 'yesterday' ? 'selected' : '' }}>Kemarin</option>
                            <option value="this_week" {{ request('period') == 'this_week' ? 'selected' : '' }}>Minggu Ini</option>
                            <option value="last_week" {{ request('period') == 'last_week' ? 'selected' : '' }}>Minggu Lalu</option>
                            <option value="this_month" {{ request('period') == 'this_month' ? 'selected' : '' }}>Bulan Ini</option>
                            <option value="last_month" {{ request('period') == 'last_month' ? 'selected' : '' }}>Bulan Lalu</option>
                            <option value="this_year" {{ request('period') == 'this_year' ? 'selected' : '' }}>Tahun Ini</option>
                        </select>
                    </div>

                    <!-- Tanggal Akhir -->
                    <div>
                        <label for="date_end" class="block text-sm font-medium text-gray-400 mb-1">Tanggal</label>
                        <input type="date" 
                               id="date_end" 
                               name="date_end" 
                               class="w-full px-4 py-2 bg-gray-700 text-white rounded-lg focus:ring-2 focus:ring-blue-500"
                               value="{{ request('date_end') }}">
                    </div>
                </div>

                <!-- Tombol Filter dan Reset -->
                <div class="flex justify-end gap-4 mt-4">
                    <a href="{{ route('transactions.index') }}" 
                       class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-2 rounded-lg transition duration-150">
                        Reset Filter
                    </a>
                    <button type="submit" 
                            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition duration-150">
                        Filter
                    </button>
                </div>
            </form>
        </div>

        <!-- Transactions Table -->
        <div class="overflow-x-auto bg-gray-800 p-4 rounded-lg shadow-lg">
            <table class="min-w-full text-left border border-gray-700 bg-gray-700">
                <thead>
                    <tr class="bg-gray-600">
                        <th class="px-6 py-3 text-gray-300 font-medium uppercase tracking-wider">
                            <a href="{{ route('transactions.index', ['sort' => 'inventory_id', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}"
                               class="flex items-center">
                                Nama Barang
                                @if(request('sort') === 'inventory_id')
                                    <span class="ml-1">{{ request('direction') === 'asc' ? '↑' : '↓' }}</span>
                                @endif
                            </a>
                        </th>
                        <th class="px-6 py-3 text-gray-300 font-medium uppercase tracking-wider">
                            <a href="{{ route('transactions.index', ['sort' => 'jumlah', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}"
                               class="flex items-center">
                                Jumlah
                                @if(request('sort') === 'jumlah')
                                    <span class="ml-1">{{ request('direction') === 'asc' ? '↑' : '↓' }}</span>
                                @endif
                            </a>
                        </th>
                        <th class="px-6 py-3 text-gray-300 font-medium uppercase tracking-wider">
                            <a href="{{ route('transactions.index', ['sort' => 'total_harga', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}"
                               class="flex items-center">
                                Total Harga
                                @if(request('sort') === 'total_harga')
                                    <span class="ml-1">{{ request('direction') === 'asc' ? '↑' : '↓' }}</span>
                                @endif
                            </a>
                        </th>
                        <th class="px-6 py-3 text-gray-300 font-medium uppercase tracking-wider">
                            <a href="{{ route('transactions.index', ['sort' => 'created_at', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}"
                               class="flex items-center">
                                Tanggal
                                @if(request('sort') === 'created_at' || !request('sort'))
                                    <span class="ml-1">{{ request('direction') === 'asc' ? '↑' : '↓' }}</span>
                                @endif
                            </a>
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-600">
                    @forelse ($transactions as $transaction)
                    <tr class="hover:bg-gray-600 transition duration-150">
                        <td class="px-6 py-4 text-white">{{ $transaction->inventory->nama_barang }}</td>
                        <td class="px-6 py-4 text-white">{{ $transaction->jumlah }}</td>
                        <td class="px-6 py-4 text-white">Rp{{ number_format($transaction->total_harga, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 text-white">{{ $transaction->created_at->setTimezone('Asia/Jakarta')->format('d M Y, H:i:s') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-gray-400">Tidak ada transaksi yang ditemukan</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="mt-4">
                {{ $transactions->withQueryString()->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
