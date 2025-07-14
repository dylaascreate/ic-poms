<!-- resources/views/livewire/home-promotions.blade.php -->
<div class="max-w-screen-xl mx-auto px-4 py-20 bg-transparent">
    <h2 class="text-5xl font-extrabold text-center text-red-700 mb-14 drop-shadow-lg tracking-wide bg-yellow-100 bg-opacity-80 rounded-2xl px-6 py-4 border-4 border-yellow-400 shadow-xl animate-bounce">
        🔥 Limited-Time Promotions!
    </h2>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-12">
        @foreach ($promotions as $promo)
            <div class="relative bg-gradient-to-br from-yellow-200 via-white to-yellow-50 border-4 border-yellow-400 shadow-2xl rounded-3xl p-8 hover:-translate-y-3 hover:shadow-yellow-600 transition duration-300 scale-100 hover:scale-105">

                {{-- Promo Image --}}
                @if ($promo->image)
                    <div class="mb-5">
                        <img src="{{ asset('storage/' . $promo->image) }}" alt="{{ $promo->title }}" class="w-full h-52 object-cover rounded-2xl shadow-lg border-2 border-yellow-300">
                        <div class="absolute top-6 left-6 bg-red-600 text-white px-3 py-1 rounded-full font-bold text-xs shadow-lg animate-bounce">
                            Hot deal!
                        </div>
                    </div>
                @endif

                {{-- Tags and Highlight --}}
                {{-- <div class="flex justify-between items-center mb-5">
                    <span class="text-sm font-semibold bg-yellow-400 text-white px-4 py-2 rounded-full uppercase shadow-md border border-yellow-500">
                        {{ $promo->tag ?? 'Hot Deal' }}
                    </span>

                    @if ($promo->highlight)
                        <span class="bg-white text-red-600 font-extrabold text-xl animate-bounce px-4 py-2 rounded-2xl shadow-lg border-2 border-red-300 ml-2">
                            {{ $promo->highlight }}
                        </span>
                    @endif
                </div> --}}

                {{-- Title, Description, Date --}}
                <h3 class="text-3xl font-extrabold mb-3 text-gray-900 drop-shadow-md">{{ $promo->title }}</h3>
                <p class="text-gray-700 mb-5 text-lg">{{ $promo->description }}</p>

                @if ($promo->valid_until)
                    <p class="text-sm text-red-500 italic mb-7 font-semibold">Valid until: {{ \Carbon\Carbon::parse($promo->valid_until)->format('d M Y') }}</p>
                @endif

                {{-- Call to Action
                <a href="#order-now" class="bg-gradient-to-r from-red-600 to-yellow-400 text-white px-7 py-3 rounded-full font-bold text-lg shadow-lg hover:from-red-700 hover:to-yellow-500 transition border-2 border-red-700">
                    {{ $promo->button_text ?? 'Get Now' }}
                </a> --}}
            </div>
        @endforeach
    </div>
</div>
