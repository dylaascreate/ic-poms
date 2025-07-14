<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <script src="//unpkg.com/alpinejs" defer></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>I-Creative Lab Sdn Bhd</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        @keyframes float {
            0% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(3deg); }
            100% { transform: translateY(0) rotate(0deg); }
        }
        .animate-float {
            animation: float 10s ease-in-out infinite;
        }
        .bg-custom-maroon { background-color: #730505; }
        .floating-card {
            position: relative;
            border-radius: 16px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            border-top: 3px solid #de1e2e;
            border-bottom: 3px solid #de1e2e;
            transition: transform 0.3s ease;
        }
        .floating-card:hover { transform: translateY(-5px); }

        /* Optional background logo watermark */
        body::before {
            content: "";
            position: fixed;
            top: 50%;
            left: 50%;
            width: 300px;
            height: 300px;
            background-image: url('/images/logo_watermark.png'); /* Change this to your logo */
            background-repeat: no-repeat;
            background-size: contain;
            background-position: center;
            opacity: 0.05;
            transform: translate(-50%, -50%);
            z-index: 0;
        }
    </style>
</head>
<body class="font-sans text-white bg-gradient-to-br from-red-600 via-yellow-300 via-blue-400 to-black relative overflow-x-hidden">

<div class="max-w-screen-xl mx-auto px-4 relative z-10">
    <!-- Header -->
    <header class="flex justify-between items-center py-4">
        <h1 class="text-2xl font-bold">I-Creative Lab Sdn.Bhd</h1>
        <nav class="flex gap-4 items-center">
            @auth
                <a href="{{ url('/dashboard') }}" class="text-sm px-4 py-2 border rounded hover:border-white">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="text-sm px-4 py-2 border rounded hover:border-white">Staff Login</a>
            @endauth
            <button x-data @click="$dispatch('open-track-order')" class="text-sm px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Track Order</button>
        </nav>
    </header>

    <!-- Hero Section -->
    <section class="relative h-80 md:h-96 rounded overflow-hidden">
        <div class="absolute inset-0">
            <img src="images/header.jpg" class="w-full h-full object-cover" alt="Hero" />
            <div class="absolute inset-0 bg-black/30"></div>
        </div>
        <div class="relative z-10 flex items-center justify-center h-full text-white text-3xl font-bold"></div>
    </section>

   

 <!-- Promotions -->
<section class="my-20 px-4">
    <div class="max-w-screen-xl mx-auto text-center">
        <h2 class="text-4xl font-extrabold mb-8 text-yellow-300 tracking-wide animate-pulse"></h2>
        <livewire:home-promotions />
    </div>
</section>

<!-- Products -->
<section class="my-20 px-4">
    <div class="max-w-screen-xl mx-auto text-center">
        <h2 class="text-4xl font-extrabold mb-8 text-white tracking-wide">📦 Our Featured Products</h2>
        <livewire:home-products />
    </div>
</section>

    <!-- About Us -->
   
<section class="my-16">
    <div class="max-w-4xl mx-auto bg-white shadow-2xl border-t-4 border-red-600 rounded-2xl p-10 text-center">
        <h2 class="text-4xl font-extrabold mb-4 text-red-700 tracking-tight">Discover Who We Are</h2>
        <p class="mb-6 text-lg text-gray-800 font-medium">Empowering your brand with vibrant, high-quality print solutions.</p>
        <p class="text-base leading-relaxed text-gray-700 italic">
            Our mission is to help businesses and individuals bring their creative ideas to life with exceptional print products that stand out.
        </p>
    </div>
</section>


    <!-- Team -->
    <section class="my-12 text-center">
        <h2 class="text-2xl font-semibold mb-6">Our Team</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8">
            <div class="flex flex-col items-center">
                <img src="https://ui-avatars.com/api/?name=Adam&background=730505&color=fff" class="w-32 h-32 rounded-full mb-2" />
                <h4 class="font-medium">Mr. Adam</h4><p>Manager</p>
            </div>
            <div class="flex flex-col items-center">
                <img src="https://ui-avatars.com/api/?name=Bella&background=730505&color=fff" class="w-32 h-32 rounded-full mb-2" />
                <h4 class="font-medium">Ms. Bella</h4><p>Marketing</p>
            </div>
            <div class="flex flex-col items-center">
                <img src="https://ui-avatars.com/api/?name=Chen&background=730505&color=fff" class="w-32 h-32 rounded-full mb-2" />
                <h4 class="font-medium">Mr. Chen</h4><p>Production</p>
            </div>
            <div class="flex flex-col items-center">
                <img src="https://ui-avatars.com/api/?name=Dina&background=730505&color=fff" class="w-32 h-32 rounded-full mb-2" />
                <h4 class="font-medium">Ms. Dina</h4><p>Promotion</p>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-custom-maroon text-white py-6 text-center">
        <div class="mb-4 space-x-4">
            <a href="https://facebook.com/szuplus" target="_blank" class="hover:text-gray-300"><i class="fab fa-facebook mr-1"></i>I-Creative Lab Sdn Bhd</a>
            <a href="https://instagram.com/icreativetm" target="_blank" class="hover:text-gray-300"><i class="fab fa-instagram mr-1"></i>@icreativetm</a>
            <a href="https://wa.me/60126826859" target="_blank" class="hover:text-gray-300"><i class="fab fa-whatsapp mr-1"></i>012-6826859</a>
        </div>
        <p class="text-sm">© I-Creative 2025. All rights reserved.</p>
    </footer>
</div>

<!-- Floating Blobs for Decoration -->
<div class="pointer-events-none fixed top-0 left-0 w-full h-full z-0 overflow-hidden">
    <div class="absolute w-96 h-96 bg-red-500 opacity-30 rounded-full mix-blend-multiply filter blur-3xl animate-float" style="top: 10%; left: 5%;"></div>
    <div class="absolute w-72 h-72 bg-yellow-400 opacity-30 rounded-full mix-blend-multiply filter blur-2xl animate-float" style="top: 50%; left: 40%;"></div>
    <div class="absolute w-80 h-80 bg-blue-500 opacity-30 rounded-full mix-blend-multiply filter blur-3xl animate-float" style="top: 30%; right: 5%;"></div>
    <div class="absolute w-60 h-60 bg-black opacity-20 rounded-full mix-blend-multiply filter blur-3xl animate-float" style="top: 70%; right: 20%;"></div>
</div>

</body>
</html>
