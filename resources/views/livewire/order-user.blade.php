<div class="max-w-2xl mx-auto p-6 bg-white rounded-xl shadow">
<h2 class="text-2xl font-bold mb-4">Order {{ $product->name ?? 'Unknown Product' }}</h2>


    @if (session()->has('message'))
        <div class="mb-4 text-green-600 font-semibold">{{ session('message') }}</div>
    @endif

    <form wire:submit.prevent="submit">
        <div class="mb-4">
            <label class="block font-semibold mb-1 text-black">Quantity</label>
            <input type="number" wire:model="quantity" min="1" class="w-full border px-3 py-2 rounded" required>
            @error('quantity') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label class="block font-semibold mb-1 text-black">Customer Name</label>
            <input type="text" wire:model="customer_name" class="w-full border px-3 py-2 rounded" required>
            @error('customer_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Submit Order
        </button>
    </form>
</div>
