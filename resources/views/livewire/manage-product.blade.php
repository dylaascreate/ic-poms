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
        {{-- Heading + Add Button --}}
        <div class="px-10 flex items-center justify-between">
            <flux:heading class="flex items-center gap-2 text-xl font-semibold">
                All Products 
                <flux:badge variant="primary">
                    {{ $products->total() }}
                </flux:badge>
            </flux:heading>

            {{-- Scroll to form button --}}
            <button
                onclick="document.getElementById('product-form').scrollIntoView({ behavior: 'smooth' });"
                class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-md text-sm"
            >
                + Add Product
            </button>
        </div>
<button
    onclick="window.scrollTo({ top: 0, behavior: 'smooth' });"
    class="fixed bottom-6 right-6 z-50 bg-gray-700 hover:bg-gray-900 text-black w-14 h-14 rounded-full shadow-lg flex items-center justify-center transition-all duration-300"
    style="right: 2rem; bottom: 2rem;"
    aria-label="Scroll to top"
    title="Scroll to top">
    <span class="text-2xl">↑</span>
</button>
        <div class="rounded-xl border shadow-sm bg-white">
            <div class="px-10 py-8 overflow-x-auto">
                <table class="w-full text-sm text-left table-auto border-collapse rounded-lg overflow-hidden">
                    <thead class="bg-rose-500 text-white text-sm uppercase">
                        <tr>
                            {{-- <th class="py-3 px-4 text-center">ID</th> --}}
                            <th class="py-3 px-4">Image</th>
                            <th class="py-3 px-4 text-center">Category</th>
                            <th class="py-3 px-4">Name</th>
                            <th class="py-3 px-4">Description</th>
                            <th class="py-3 px-4 text-center">Price</th>
                            <th class="py-3 px-4 text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $index => $pt)
                            <tr class="{{ $index % 2 === 0 ? 'bg-rose-200' : 'bg-rose-100' }} hover:bg-blue-200 transition duration-200">
                                {{-- <td class="py-3 px-4 text-center font-medium">{{ $pt->id }}</td> --}}
                                <td class="py-3 px-4 text-center">
                                    @if ($pt->image)
                                        <img src="{{ asset('storage/' . $pt->image) }}" alt="Product Image" class="h-16 w-16 object-cover rounded-md border mx-auto">
                                    @else
                                        <span class="text-gray-400 italic">No Image</span>
                                    @endif
                                </td>
                                <td class="py-3 px-4 text-center text-sm text-gray-800">{{ $pt->category }}</td>
                                <td class="py-3 px-4 font-semibold text-gray-800">{{ $pt->name }}</td>
                                <td class="py-3 px-4 text-gray-700">{{ $pt->description }}</td>
                                <td class="py-3 px-4 text-center font-medium text-green-700">RM {{ number_format($pt->price, 2) }}</td>
                                <td class="py-3 px-4 text-center">
                                    <div class="flex justify-center gap-2">
                                        <flux:button wire:click="edit({{ $pt->id }})" icon="pencil-square" variant="primary" class="bg-sky-500 text-white rounded-md text-sm"></flux:button>
                                        <flux:button wire:click="$dispatch('confirmDelete',{{ $pt->id }})" icon="trash" variant="danger"></flux:button>
                                    </div>
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
    <div id="product-form" class="flex flex-col gap-6 mt-10">
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
                                @php $existingProduct = \App\Models\Product::find($productId); @endphp
                                @if ($existingProduct && $existingProduct->image)
                                    <div class="mt-3">
                                        <label class="text-sm font-medium text-gray-600">Current Image:</label>
                                        <img src="{{ asset('storage/' . $existingProduct->image) }}" class="h-24 mt-1 rounded shadow">
                                    </div>
                                @endif
                            @endif
                        </div>

                        {{-- Category --}}
                        <flux:select wire:model="category" label="Category" required>
                            <option value="">-- Select Category --</option>
                            <option value="Business Card">Business Card</option>
                            <option value="Flyer">Flyer</option>
                            <option value="Poster">Poster</option>
                            <option value="Sticker">Sticker</option>
                            <option value="Brochure">Brochure</option>
                            <option value="Banner">Banner</option>
                            <option value="T-Shirt Printing">T-Shirt Printing</option>
                            <option value="Mug Printing">Mug Printing</option>
                        </flux:select>

                        @error('category')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror

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
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: res.message,
                    confirmButtonColor: '#3085d6'
                });
            });

            Livewire.on('productSaveFailed', function(res){
                Swal.fire({
                    icon: 'error',
                    title: 'Oops!',
                    text: res.message,
                    confirmButtonColor: '#d33'
                });
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
