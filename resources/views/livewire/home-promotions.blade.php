<!-- resources/views/livewire/home-promotions.blade.php -->
<div class="product-carousel-container">
    <button class="carousel-btn carousel-prev" aria-label="Previous">
        <i class="fas fa-chevron-left"></i>
    </button>
    <button class="carousel-btn carousel-next" aria-label="Next">
        <i class="fas fa-chevron-right"></i>
    </button>
    <div class="product-carousel">
        <div class="carousel-track">
            @foreach($promotions as $promo)
                <div class="product-card">
                    @if($promo->image)
                        <img src="{{ asset('storage/' . $promo->image) }}" alt="{{ $promo->title }}" class="w-full h-70 object-cover mb-4 rounded">
                    @endif
                    <h3 class="font-bold">{{ $promo->title }}</h3>
                    <p class="text-sm">{{ $promo->description }}</p>
                </div>
            @endforeach
        </div>
    </div>
</div>