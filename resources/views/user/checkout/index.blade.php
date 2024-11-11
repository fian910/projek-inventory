<x-app-layout>
    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-semibold text-white mb-6">Halaman Checkout</h1>

        {{-- Display success or error message --}}
        @if(session('success'))
            <div class="bg-green-500 text-white p-4 rounded-lg mb-6 shadow-lg">
                {{ session('success') }}
            </div>
        @elseif(session('error'))
            <div class="bg-red-500 text-white p-4 rounded-lg mb-6 shadow-lg">
                {{ session('error') }}
            </div>
        @endif

        <!-- Display Cart Items -->
        @if(session('cartItems') && count(session('cartItems')) > 0)
            <div class="bg-gray-800 p-6 rounded-lg shadow-lg mb-6">
                <h2 class="text-xl text-white font-semibold mb-4">Barang yang Sudah Dipilih</h2>
                <table class="w-full table-auto text-white">
                    <thead>
                        <tr class="border-b">
                            <th class="px-4 py-2 text-left">Nama Barang</th>
                            <th class="px-4 py-2 text-left">Jumlah</th>
                            <th class="px-4 py-2 text-left">Harga Satuan</th>
                            <th class="px-4 py-2 text-left">Total Harga</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(session('cartItems') as $item)
                            <tr class="border-b">
                                <td class="px-4 py-2">{{ $item['nama_barang'] }}</td>
                                <td class="px-4 py-2">{{ $item['jumlah'] }}</td>
                                <td class="px-4 py-2">Rp {{ number_format($item['harga'], 0, ',', '.') }}</td>
                                <td class="px-4 py-2">Rp {{ number_format($item['harga'] * $item['jumlah'], 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Cart Summary -->
                <div class="mt-4 text-white">
                    <h3 class="font-semibold">Total Belanja:</h3>
                    @php
                        $total = 0;
                        foreach(session('cartItems') as $item) {
                            $total += $item['harga'] * $item['jumlah'];
                        }
                    @endphp
                    <p class="text-lg">Rp {{ number_format($total, 0, ',', '.') }}</p>
                </div>
            </div>
        @else
            <div class="bg-gray-800 p-6 rounded-lg shadow-lg mb-6">
                <p class="text-white">Keranjang Anda kosong. Silakan pilih barang untuk checkout.</p>
            </div>
        @endif

        <!-- Checkout Section -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Checkout Form -->
            <form action="{{ route('checkout.store') }}" method="POST" class="bg-gray-800 p-6 rounded-lg shadow-lg">
                @csrf
                <h2 class="text-xl text-white font-semibold mb-4">Form Checkout</h2>
                <div class="mb-4">
                    <label for="inventory_id" class="block text-sm font-medium text-gray-300">Nama Barang</label>
                    <select name="inventory_id" id="inventory_id" class="mt-1 block w-full px-4 py-2 border border-gray-600 bg-gray-700 text-white rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        <option value="">Pilih Barang</option>
                        @foreach ($inventories as $inventory)
                            <option value="{{ $inventory->id }}" data-harga="{{ $inventory->harga }}" data-stok="{{ $inventory->stok }}">
                                {{ $inventory->nama_barang }} - Stok: {{ $inventory->stok }} - Harga: Rp {{ number_format($inventory->harga, 0, ',', '.') }}
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

            <!-- Checkout Details -->
            <div class="bg-gray-800 p-6 rounded-lg shadow-lg">
                <h2 class="text-xl text-white font-semibold mb-4">Detail Checkout</h2>
                <div id="checkout-details" class="text-white">
                    <div class="mb-4">
                        <p class="text-gray-400">Barang yang dipilih:</p>
                        <p id="selected-item" class="font-medium">-</p>
                    </div>
                    <div class="mb-4">
                        <p class="text-gray-400">Stok tersedia:</p>
                        <p id="available-stock" class="font-medium">-</p>
                    </div>
                    <div class="mb-4">
                        <p class="text-gray-400">Harga per unit:</p>
                        <p id="unit-price" class="font-medium">-</p>
                    </div>
                    <div class="mb-4">
                        <p class="text-gray-400">Jumlah:</p>
                        <p id="selected-quantity" class="font-medium">-</p>
                    </div>
                    <div class="border-t border-gray-700 pt-4 mt-4">
                        <p class="text-gray-400">Total Harga:</p>
                        <p id="total-price" class="text-xl font-semibold">-</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add this script at the bottom of the file -->
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            const inventorySelect = document.getElementById('inventory_id');
            const jumlahInput = document.getElementById('jumlah');
            const selectedItem = document.getElementById('selected-item');
            const availableStock = document.getElementById('available-stock');
            const unitPrice = document.getElementById('unit-price');
            const selectedQuantity = document.getElementById('selected-quantity');
            const totalPrice = document.getElementById('total-price');

            function updateDetails() {
                const selectedOption = inventorySelect.options[inventorySelect.selectedIndex];
                const quantity = jumlahInput.value;

                if (selectedOption.value) {
                    const harga = parseFloat(selectedOption.dataset.harga);
                    const stok = parseInt(selectedOption.dataset.stok);

                    selectedItem.textContent = selectedOption.text.split(' - ')[0];
                    availableStock.textContent = stok;
                    unitPrice.textContent = `Rp ${new Intl.NumberFormat('id-ID').format(harga)}`;
                    selectedQuantity.textContent = quantity || '0';
                    totalPrice.textContent = quantity ? `Rp ${new Intl.NumberFormat('id-ID').format(harga * quantity)}` : '-';
                } else {
                    selectedItem.textContent = '-';
                    availableStock.textContent = '-';
                    unitPrice.textContent = '-';
                    selectedQuantity.textContent = '-';
                    totalPrice.textContent = '-';
                }
            }

            inventorySelect.addEventListener('change', updateDetails);
            jumlahInput.addEventListener('input', updateDetails);
        });
        </script>
    </div>
</x-app-layout>
