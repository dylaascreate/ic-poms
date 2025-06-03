<div>
    {{-- SweetAlert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- Success Message --}}
    @if (session('message'))
        <div class="text-center text-green-600 font-semibold mt-4">
            {{ session('message') }}
        </div>
    @endif

    {{-- Product Table --}}
    <div class="flex flex-col gap-6 mt-8">
        <flux:heading class="px-10 flex items-center gap-2 text-xl font-semibold">
            All Products 
            <flux:badge variant="primary">
                {{ $products->total() }}
            </flux:badge>
        </flux:heading>

        <div class="rounded-xl border shadow-sm bg-white">
            <div class="px-10 py-8 overflow-x-auto">
                <table class="w-full text-sm text-left table-auto border-collapse rounded-lg overflow-hidden">
    <thead class="bg-rose-500 text-white text-sm uppercase">
        <tr>
            <th class="py-3 px-4 text-center">ID</th>
            <th class="py-3 px-4">Image</th>
            <th class="py-3 px-4">Name</th>
            <th class="py-3 px-4">Description</th>
            <th class="py-3 px-4 text-center">Price</th>
            <th class="py-3 px-4 text-center">Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($products as $index => $pt)
        <tr class="{{ $index % 2 === 0 ? 'bg-rose-50' : 'bg-rose-100' }} hover:bg-blue-200 transition duration-200">
            <td class="py-3 px-4 text-center font-medium">{{ $pt->id }}</td>
            <td class="py-3 px-4">
                @if ($pt->image)
                    <img src="{{ asset('storage/' . $pt->image) }}" alt="Product Image" class="h-16 w-16 object-cover rounded-md border">
                @else
                    <span class="text-gray-400 italic">No Image</span>
                @endif
            </td>
            <td class="py-3 px-4 font-semibold text-gray-800">{{ $pt->name }}</td>
            <td class="py-3 px-4 text-gray-700">{{ $pt->description }}</td>
            <td class="py-3 px-4 text-center font-medium text-green-700">RM {{ number_format($pt->price, 2) }}</td>
            <td class="py-3 px-4 text-center flex justify-center gap-2">
                <flux:button wire:click="edit({{ $pt->id }})" icon="pencil-square" variant="primary" class="bg-sky-500 text-white rounded-md text-sm"></flux:button>
                <flux:button wire:click="$dispatch('confirmDelete',{{ $pt->id }})" icon="trash" variant="danger"></flux:button>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

                {{-- Pagination --}}
                <div class="mt-6 flex justify-center">
                    {{ $products->links('pagination::tailwind') }}
                </div>
            </div>
        </div>
    </div>

    {{-- Product Form --}}
    <div class="flex flex-col gap-6 mt-10">
        <div class="rounded-xl border shadow-sm bg-white">
            <flux:heading class="px-10 pt-6 text-xl font-semibold">
                {{ $productId ? 'Edit Product' : 'Add Product' }}
            </flux:heading>
            <div class="px-10 py-8">
                <form wire:submit.prevent="save" class="space-y-6">
                    <div class="grid md:grid-cols-2 gap-6">

                        {{-- Image Upload --}}
                        <div class="col-span-2">
                            <label class="block mb-2 font-medium text-gray-700">Product Image</label>
                            <input type="file" wire:model="image" class="block w-full text-sm text-gray-500
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-md file:border-0
                                file:text-sm file:font-semibold
                                file:bg-blue-50 file:text-blue-700
                                hover:file:bg-blue-100"/>

                            @error('image') 
                                <span class="text-red-500 text-sm">{{ $message }}</span> 
                            @enderror

                            @if ($image instanceof \Livewire\TemporaryUploadedFile)
                            <div class="mt-3">
                                <label class="text-sm font-medium text-gray-600">Preview:</label>
                                <img src="{{ $image->temporaryUrl() }}" class="h-24 mt-1 rounded shadow">
                            </div>
                        @elseif ($productId)
                                {{-- Display existing image if editing --}}
                                @php $existingProduct = \App\Models\Product::find($productId); @endphp
                                @if ($existingProduct && $existingProduct->image)
                                    <div class="mt-3">
                                        <label class="text-sm font-medium text-gray-600">Current Image:</label>
                                        <img src="{{ asset('storage/' . $existingProduct->image) }}" class="h-24 mt-1 rounded shadow">
                                    </div>
                                @endif
                            @endif
                        </div>

                        {{-- Name --}}
                        <flux:input wire:model="name" label="Product Name" placeholder="Product Name"/>

                        {{-- Description --}}
                        <flux:textarea wire:model="description" label="Description" placeholder="Product Description"/>

                        {{-- Price --}}
                        <flux:input wire:model="price" label="Price (RM)" placeholder="e.g. 99.90" />

                        {{-- Submit Button --}}
                        <div class="col-span-2">
                           <flux:button type="submit" variant="primary" icon="paper-airplane" class="px-6 py-2 text-base bg-green-500 text-white rounded-md text-sm">
                                {{ $productId ? 'Update Product' : 'Add Product' }}
                           </flux:button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- SweetAlert Scripts --}}
    <script>
        document.addEventListener('livewire:init', function(){
            Livewire.on('productSaved', function(res){
                Swal.fire('Success!', res.message, 'success');
            });

            Livewire.on('confirmDelete', function(id){
                Swal.fire({
                    title: 'Are you sure?',
                    text: "This action cannot be undone!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Livewire.dispatch('delete', { id: id });
                    }
                });
            });
        });
    </script>
</div>
