<!-- filepath: resources/views/livewire/home-products.blade.php -->
<div class="product-carousel-container">
    <button class="carousel-btn carousel-prev" aria-label="Previous">
        <i class="fas fa-chevron-left"></i>
    </button>
    <button class="carousel-btn carousel-next" aria-label="Next">
        <i class="fas fa-chevron-right"></i>
    </button>
    <div class="product-carousel">
        <div class="carousel-track">
            @foreach($products as $product)
                <div class="product-card">
                    <img src="{{ asset('images/' . $product->image) }}"
                         alt="{{ $product->name }}"
                         class="w-full h-70 object-cover mb-4 rounded">
                    <h3 class="font-bold">{{ strtoupper($product->name) }}</h3>
                    <p class="text-sm">{{ $product->description }}</p>
                </div>
            @endforeach
        </div>
    </div>
</div>