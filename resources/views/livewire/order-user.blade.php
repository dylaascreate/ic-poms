<div class="max-w-2xl mx-auto p-6 bg-white rounded-xl shadow space-y-6">
    <h2 class="text-2xl font-bold">Order {{ $productName ?? 'Unknown Product' }}</h2>

    @if (session()->has('message'))
        <div class="text-green-600 font-semibold">{{ session('message') }}</div>
    @endif

    <form wire:submit.prevent="submit" enctype="multipart/form-data" class="space-y-4">

        <div>
            <label class="block font-semibold text-black">Quantity</label>
            <input type="number" wire:model="quantity" min="1" class="w-full border px-3 py-2 rounded text-black" required>
            @error('quantity') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block font-semibold text-black">Customer Name</label>
            <input type="text" wire:model="customer_name" class="w-full border px-3 py-2 rounded text-black" required>
            @error('customer_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block font-semibold text-black">Size</label>
            <input type="text" wire:model="size" class="w-full border px-3 py-2 rounded text-black">
            @error('size') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block font-semibold text-black">Upload File</label>
            <input type="file" wire:model="file" class="w-full border px-3 py-2 rounded text-black">
            @error('file') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block font-semibold text-black">Material</label>
            <select wire:model="material" class="w-full border px-3 py-2 rounded text-black">
                <option value="">Select Material</option>
                @foreach($materialOptions as $option)
                    <option value="{{ $option }}">{{ $option }}</option>
                @endforeach
            </select>
            @error('material') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block font-semibold text-black">Lamination</label>
            <select wire:model="lamination" class="w-full border px-3 py-2 rounded text-black">
                @foreach($laminationOptions as $option)
                    <option value="{{ $option }}">{{ $option }}</option>
                @endforeach
            </select>
            @error('lamination') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block font-semibold text-black">Colour</label>
            <select wire:model="colour" class="w-full border px-3 py-2 rounded text-black">
                @foreach($colourOptions as $option)
                    <option value="{{ $option }}">{{ $option }}</option>
                @endforeach
            </select>
            @error('colour') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block font-semibold text-black">Additional Details</label>
            <textarea wire:model="details" class="w-full border px-3 py-2 rounded text-black" rows="3"></textarea>
            @error('details') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

       <button class="bg-blue-600 text-black font-semibold px-4 py-2 rounded-md shadow hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-300 transition">
         Submit Order
        </button>

    </form>
</div>
