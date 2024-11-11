<x-app-layout>
    <div class="container mx-auto p-6">
        <!-- Success Message -->
        @if (session('success'))
            <div class="bg-green-500 text-white p-4 rounded-lg mb-4 flex items-center justify-between">
                {{ session('success') }}
                <button onclick="this.parentElement.style.display='none'" class="text-white">&times;</button>
            </div>
        @endif

        <!-- Header Section -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-semibold text-white">Daftar Inventory</h1>
            <div class="flex space-x-4">
                <div class="relative">
                    <input type="text" id="searchInput" placeholder="Cari barang..." 
                           class="px-4 py-2 rounded-lg border focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <i class="fas fa-search absolute right-3 top-3 text-gray-400"></i>
                </div>
                <a href="{{ route('inventories.create') }}" 
                   class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition duration-300 flex items-center">
                    <i class="fas fa-plus mr-2"></i> Tambah Barang
                </a>
            </div>
        </div>

        <!-- Inventory Table -->
        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full border-collapse table-auto">
                    <thead class="bg-gray-800 text-white">
                        <tr>
                            <th class="px-6 py-4 text-left">Nama Barang</th>
                            <th class="px-6 py-4 text-left">Kode Barang</th>
                            <th class="px-6 py-4 text-left">Kategori</th>
                            <th class="px-6 py-4 text-left">Stok</th>
                            <th class="px-6 py-4 text-left">Harga</th>
                            <th class="px-6 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($inventories as $inventory)
                        <tr class="border-b hover:bg-gray-50 transition duration-150">
                            <td class="px-6 py-4">{{ $inventory->nama_barang }}</td>
                            <td class="px-6 py-4">{{ $inventory->kode_barang }}</td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 rounded-full text-sm 
                                    {{ $inventory->kategori == 'Elektronik' ? 'bg-blue-100 text-blue-800' : 
                                       ($inventory->kategori == 'Furniture' ? 'bg-green-100 text-green-800' : 
                                       'bg-yellow-100 text-yellow-800') }}">
                                    {{ $inventory->kategori }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="{{ $inventory->stok <= 10 ? 'text-red-600 font-bold' : 'text-gray-700' }}">
                                    {{ $inventory->stok }}
                                </span>
                            </td>
                            <td class="px-6 py-4">Rp {{ number_format($inventory->harga, 0, ',', '.') }}</td>
                            <td class="px-6 py-4">
                                <div class="flex justify-center space-x-2">
                                    <a href="{{ route('inventories.edit', $inventory->id) }}" 
                                       class="bg-yellow-500 text-white px-4 py-2 rounded-md hover:bg-yellow-600 transition duration-300">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('inventories.destroy', $inventory->id) }}" 
                                          method="POST" class="inline" onsubmit="return confirmDelete()">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600 transition duration-300">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                Tidak ada data inventory yang tersedia
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            @if(method_exists($inventories, 'links'))
                <div class="px-6 py-4 bg-gray-50">
                    {{ $inventories->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Scripts -->
    <script>
        function confirmDelete() {
            return Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                return result.isConfirmed;
            });
        }

        // Search functionality
        document.getElementById('searchInput').addEventListener('keyup', function() {
            let input = this.value.toLowerCase();
            let rows = document.querySelectorAll('tbody tr');
            
            rows.forEach(row => {
                let text = row.textContent.toLowerCase();
                row.style.display = text.includes(input) ? '' : 'none';
            });
        });
    </script>

    <!-- Include SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Include Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</x-app-layout>
