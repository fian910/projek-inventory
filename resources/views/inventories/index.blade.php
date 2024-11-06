<x-app-layout>
    <div class="container mx-auto p-6">
        <!-- Success Message -->
        @if (session('success'))
            <div class="bg-green-500 text-white p-4 rounded-lg mb-4">
                {{ session('success') }}
            </div>
        @endif

        <h1 class="text-3xl font-semibold text-white mb-6">Daftar Inventory</h1>
        <a href="{{ route('inventories.create') }}" class="bg-blue-500 text-white px-6 py-3 rounded-lg hover:bg-blue-700 mb-4 inline-block">Tambah Barang</a>

        <!-- Inventory Table -->
        <div class="overflow-x-auto bg-white shadow-md rounded-lg">
            <table class="min-w-full border-collapse table-auto">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 border-b text-left text-gray-600">Nama Barang</th>
                        <th class="px-6 py-3 border-b text-left text-gray-600">Kode Barang</th>
                        <th class="px-6 py-3 border-b text-left text-gray-600">Kategori</th>
                        <th class="px-6 py-3 border-b text-left text-gray-600">Stok</th>
                        <th class="px-6 py-3 border-b text-left text-gray-600">Harga</th>
                        <th class="px-6 py-3 border-b text-left text-gray-600">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($inventories as $inventory)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-6 py-4">{{ $inventory->nama_barang }}</td>
                        <td class="px-6 py-4">{{ $inventory->kode_barang }}</td>
                        <td class="px-6 py-4">{{ $inventory->kategori }}</td>
                        <td class="px-6 py-4">{{ $inventory->stok }}</td>
                        <td class="px-6 py-4">{{ $inventory->harga }}</td>
                        <td class="px-6 py-4 flex items-center space-x-2">
                            <a href="{{ route('inventories.edit', $inventory->id) }}" class="bg-yellow-500 text-white px-4 py-2 rounded-md hover:bg-yellow-600">Edit</a>

                            <!-- Delete Form -->
                            <form action="{{ route('inventories.destroy', $inventory->id) }}" method="POST" class="inline" onsubmit="return confirmDelete()">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Confirmation Script -->
    <script>
        function confirmDelete() {
            return confirm("Apakah Anda yakin ingin menghapus barang ini?");
        }
    </script>
</x-app-layout>
