<div class="px-10 py-6">
    {{-- Top bar with Home and Profile Icons --}}
    <div class="flex justify-between items-center mb-6">
        <div class="flex items-center gap-4">
            <a href="{{ url('/') }}">
                <flux:button icon="home" variant="outline" />
            </a>
            <h1 class="text-2xl font-bold">Products</h1>
        </div>
        <a href="{{ url('/profile') }}">
            <flux:button icon="user-circle" variant="outline" />
        </a>
    </div>

    {{-- Search Bar --}}
    <div class="mb-6">
        <flux:input wire:model.debounce.300ms="search" placeholder="Search products..." />
    </div>

    {{-- Success Message --}}
    @if(session('message'))
        <div class="text-center text-green-600 font-bold">{{ session('message') }}</div>
    @endif

    {{-- Product Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($products as $product)
            <div class="border rounded-xl p-4 shadow hover:shadow-lg transition">
                {{-- Placeholder for future image --}}
                <div class="h-40 bg-gray-100 rounded-lg flex items-center justify-center text-gray-400 mb-4">
                    <img src="{{ asset('images/products/' . $product->image) }}"
                        alt="{{ $product->name }}"
                        class="w-full h-48 object-cover rounded-t-xl">

                </div>
                <h2 class="text-xl font-semibold mb-2">
                    <a href="#" class="text-blue-600 hover:underline">{{ $product->name }}</a>
                </h2>
                <p class="text-gray-600 mb-2">{{ Str::limit($product->description, 100) }}</p>
                <div class="text-lg font-bold mb-2">RM {{ number_format($product->price, 2) }}</div>
                    <a href="{{ route('order.form', $product->id) }}">
                    <flux:button icon="shopping-cart" variant="outline" />
                    </a>
            </div>
        @empty
            <div class="col-span-3 text-center text-gray-500">No products found.</div>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div class="mt-6 text-center">
        {{ $products->links() }}
    </div>


</div>


