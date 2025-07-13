<!-- resources/views/livewire/home-products.blade.php -->
<div class="max-w-screen-xl mx-auto px-4 py-12 bg-transparent rounded-2xl shadow-2xl">
    <h2 class="text-4xl font-extrabold mb-10 text-center text-white drop-shadow-lg tracking-wide animate-pulse">
   
    </h2>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-10">
        @foreach($products as $product)
            <div class="bg-white rounded-2xl shadow-xl p-6 hover:shadow-2xl transition transform hover:-translate-y-2 hover:scale-105 border-4 border-transparent hover:border-indigo-400 relative">
               
                <img src="{{ asset('images/' . $product->image) }}"
                     alt="{{ $product->name }}"
                     class="w-full h-48 object-cover mb-4 rounded-lg border-2 border-indigo-200 shadow-md">
                <h3 class="text-xl font-extrabold text-indigo-700 mb-2 tracking-wide">{{ strtoupper($product->name) }}</h3>
                <p class="text-base text-gray-700 mb-4">{{ $product->description }}</p>
               
            </div>
        @endforeach
    </div>
</div>
