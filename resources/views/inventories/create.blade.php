<x-app-layout>
    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-semibold text-white mb-6">Tambah Barang</h1>
        <form action="{{ route('inventories.store') }}" method="POST" class="bg-gray-800 p-6 rounded-lg shadow-md">
            @csrf
            <div class="mb-4">
                <label for="nama_barang" class="block text-sm font-medium text-gray-300">Nama Barang</label>
                <input type="text" class="mt-1 block w-full px-4 py-2 border border-gray-600 bg-gray-700 text-white rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" id="nama_barang" name="nama_barang" required>
            </div>
            <div class="mb-4">
                <label for="kode_barang" class="block text-sm font-medium text-gray-300">Kode Barang</label>
                <input type="text" class="mt-1 block w-full px-4 py-2 border border-gray-600 bg-gray-700 text-white rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" id="kode_barang" name="kode_barang" required>
            </div>
            <div class="mb-4">
                <label for="kategori" class="block text-sm font-medium text-gray-300">Kategori</label>
                <select id="kategori" name="kategori" class="mt-1 block w-full px-4 py-2 border border-gray-600 bg-gray-700 text-white rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    <option value="" disabled selected>Pilih Kategori</option>
                    <option value="elektronik">Elektronik</option>
                    <option value="makanan">Makanan</option>
                    <option value="material">Material</option>
                </select>

            </div>
            <div class="mb-4">
                <label for="stok" class="block text-sm font-medium text-gray-300">Stok</label>
                <input type="number" class="mt-1 block w-full px-4 py-2 border border-gray-600 bg-gray-700 text-white rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" id="stok" name="stok" required>
            </div>
            <div class="mb-4">
                <label for="harga" class="block text-sm font-medium text-gray-300">Harga</label>
                <input type="text" class="mt-1 block w-full px-4 py-2 border border-gray-600 bg-gray-700 text-white rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" id="harga" name="harga" required>
            </div>
            <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">Tambah Barang</button>
        </form>
    </div>
</x-app-layout>
