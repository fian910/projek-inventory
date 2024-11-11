<x-app-layout>
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="max-w-3xl mx-auto">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-white">Edit Barang</h1>
                <p class="mt-2 text-gray-400">Perbarui informasi barang dalam inventaris</p>
            </div>

            <!-- Form Card -->
            <div class="bg-gray-800 rounded-xl shadow-lg overflow-hidden">
                <form action="{{ route('admin.inventories.update', $inventory->id) }}" method="POST" class="p-6 space-y-6">
                    @csrf
                    @method('PUT')
                    
                    <!-- Form Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nama Barang -->
                        <div>
                            <label for="nama_barang" class="block text-sm font-medium text-gray-300">Nama Barang</label>
                            <input type="text" id="nama_barang" name="nama_barang" 
                                value="{{ $inventory->nama_barang }}"
                                class="mt-1 block w-full rounded-md border-gray-600 bg-gray-700 text-white 
                                shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50"
                                required>
                        </div>

                        <!-- Kode Barang -->
                        <div>
                            <label for="kode_barang" class="block text-sm font-medium text-gray-300">Kode Barang</label>
                            <input type="text" id="kode_barang" name="kode_barang" 
                                value="{{ $inventory->kode_barang }}"
                                class="mt-1 block w-full rounded-md border-gray-600 bg-gray-700 text-white 
                                shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50"
                                required>
                        </div>

                        <!-- Kategori -->
                        <div>
                            <label for="kategori" class="block text-sm font-medium text-gray-300">Kategori</label>
                            <select id="kategori" name="kategori" 
                                class="mt-1 block w-full rounded-md border-gray-600 bg-gray-700 text-white 
                                shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50"
                                required>
                                <option value="elektronik" {{ $inventory->kategori == 'elektronik' ? 'selected' : '' }}>Elektronik</option>
                                <option value="makanan" {{ $inventory->kategori == 'makanan' ? 'selected' : '' }}>Makanan</option>
                                <option value="material" {{ $inventory->kategori == 'material' ? 'selected' : '' }}>Material</option>
                            </select>
                        </div>

                        <!-- Stok -->
                        <div>
                            <label for="stok" class="block text-sm font-medium text-gray-300">Stok</label>
                            <input type="number" id="stok" name="stok" 
                                value="{{ $inventory->stok }}"
                                class="mt-1 block w-full rounded-md border-gray-600 bg-gray-700 text-white 
                                shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50"
                                required>
                        </div>

                        <!-- Harga -->
                        <div class="md:col-span-2">
                            <label for="harga" class="block text-sm font-medium text-gray-300">Harga</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-400 sm:text-sm">Rp</span>
                                </div>
                                <input type="text" id="harga" name="harga" 
                                    value="{{ $inventory->harga }}"
                                    class="pl-12 block w-full rounded-md border-gray-600 bg-gray-700 text-white 
                                    shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50"
                                    required>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-4">
                        <button type="submit" 
                            class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white 
                            bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 
                            transition duration-150 ease-in-out">
                            Perbarui Barang
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
