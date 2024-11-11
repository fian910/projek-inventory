<x-app-layout>
    <div class="container mx-auto p-6">
        <div class="bg-gray-800 rounded-lg shadow-lg overflow-hidden">
            <!-- Card Header -->
            <div class="border-b border-gray-700 p-6">
                <h1 class="text-2xl font-bold text-white">Tambah Barang Baru</h1>
                <p class="mt-1 text-sm text-gray-400">Silakan isi informasi barang dengan lengkap</p>
            </div>

            <!-- Form Content -->
            <form action="{{ route('inventories.store') }}" method="POST" class="p-6">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Nama Barang -->
                    <div>
                        <label for="nama_barang" class="block text-sm font-medium text-gray-300">Nama Barang</label>
                        <input type="text" 
                            class="mt-1 block w-full px-4 py-2 border border-gray-600 bg-gray-700 text-white rounded-md 
                                focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            id="nama_barang" 
                            name="nama_barang" 
                            placeholder="Masukkan nama barang"
                            required>
                    </div>

                    <!-- Kode Barang -->
                    <div>
                        <label for="kode_barang" class="block text-sm font-medium text-gray-300">Kode Barang</label>
                        <input type="text" 
                            class="mt-1 block w-full px-4 py-2 border border-gray-600 bg-gray-700 text-white rounded-md 
                                focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            id="kode_barang" 
                            name="kode_barang" 
                            placeholder="Masukkan kode barang"
                            required>
                    </div>

                    <!-- Kategori -->
                    <div>
                        <label for="kategori" class="block text-sm font-medium text-gray-300">Kategori</label>
                        <select id="kategori" 
                            name="kategori" 
                            class="mt-1 block w-full px-4 py-2 border border-gray-600 bg-gray-700 text-white rounded-md 
                                focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            required>
                            <option value="" disabled selected>Pilih Kategori</option>
                            <option value="elektronik">Elektronik</option>
                            <option value="makanan">Makanan</option>
                            <option value="material">Material</option>
                        </select>
                    </div>

                    <!-- Stok -->
                    <div>
                        <label for="stok" class="block text-sm font-medium text-gray-300">Stok</label>
                        <input type="number" 
                            class="mt-1 block w-full px-4 py-2 border border-gray-600 bg-gray-700 text-white rounded-md 
                                focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            id="stok" 
                            name="stok" 
                            placeholder="0"
                            min="0"
                            required>
                    </div>

                    <!-- Harga -->
                    <div class="md:col-span-2">
                        <label for="harga" class="block text-sm font-medium text-gray-300">Harga</label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-400 sm:text-sm">Rp</span>
                            </div>
                            <input type="text" 
                                class="block w-full pl-10 px-4 py-2 border border-gray-600 bg-gray-700 text-white rounded-md 
                                    focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                id="harga" 
                                name="harga" 
                                placeholder="0"
                                required>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="mt-6 flex items-center justify-end">
                    <button type="button" 
                        class="mr-4 px-4 py-2 text-sm font-medium text-gray-300 hover:text-white focus:outline-none">
                        Batal
                    </button>
                    <button type="submit" 
                        class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 
                            focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:ring-offset-gray-800">
                        Simpan Barang
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

