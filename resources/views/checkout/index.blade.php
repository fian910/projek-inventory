<x-app-layout>
    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-semibold text-white mb-6">Halaman Checkout</h1>

        {{-- Display success or error message --}}
        @if(session('success'))
            <div class="bg-green-500 text-white p-4 rounded-lg mb-4 shadow-md">
                {{ session('success') }}
            </div>
        @elseif(session('error'))
            <div class="bg-red-500 text-white p-4 rounded-lg mb-4 shadow-md">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('checkout.store') }}" method="POST" class="bg-gray-800 p-6 rounded-lg shadow-lg">
            @csrf
            <div class="mb-4">
                <label for="inventory_id" class="block text-sm font-medium text-gray-300">Nama Barang</label>
                <select name="inventory_id" id="inventory_id" class="mt-1 block w-full px-4 py-2 border border-gray-600 bg-gray-700 text-white rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    <option value="">Pilih Barang</option>
                    @foreach ($inventories as $inventory)
                        <option value="{{ $inventory->id }}">
                            {{ $inventory->nama_barang }} - Stok: {{ $inventory->stok }} - Harga: {{ number_format($inventory->harga, 0, ',', '.') }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label for="jumlah" class="block text-sm font-medium text-gray-300">Jumlah</label>
                <input type="number" class="mt-1 block w-full px-4 py-2 border border-gray-600 bg-gray-700 text-white rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" id="jumlah" name="jumlah" required min="1">
            </div>

            <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">Checkout</button>
        </form>
    </div>
</x-app-layout>
