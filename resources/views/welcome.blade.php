<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>I-Creative</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
        }
        .nav-item {
            position: relative;
            padding-bottom: 5px;
        }
        .nav-item:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background-color: black;
            transition: width 0.3s ease;
        }
        .nav-item:hover:after {
            width: 100%;
        }
        .top-navbar {
            width: 100%;
            max-width: 56rem;
            margin-bottom: 1.5rem;
        }
        @media (max-width: 640px) {
            .top-navbar {
                max-width: 335px;
            }
        }
        .bg-custom-purple {
            background-color: #660066;
        }
        .hover\:bg-custom-purple-dark:hover {
            background-color: #4d004d;
        }
        .bg-custom-darkpurple {
            background-color: #440144;
        }
    </style>
</head>
<body class="font-sans bg-white text-gray-900">

    <!-- Top Navbar -->
    <div class="container mx-auto px-4 py-4">
        <header class="top-navbar mx-auto">
            @if (Route::has('login'))
                <nav class="flex items-center justify-end gap-4">
                    @auth
                        <a
                            href="{{ url('/dashboard') }}"
                            class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal">
                            Dashboard
                        </a>
                    @else
                        <a 
                            href="{{ route('about') }}" 
                            class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] text-[#1b1b18] border border-transparent hover:border-[#19140035] dark:hover:border-[#3E3E3A] rounded-sm text-sm leading-normal">
                            About
                        </a>
                    
                        <a
                            href="{{ route('login') }}"
                            class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] text-[#1b1b18] border border-transparent hover:border-[#19140035] dark:hover:border-[#3E3E3A] rounded-sm text-sm leading-normal">
                            Log in
                        </a>

                        @if (Route::has('register'))
                            <a
                                href="{{ route('register') }}"
                                class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] text-[#1b1b18] border border-transparent hover:border-[#19140035] dark:hover:border-[#3E3E3A] rounded-sm text-sm leading-normal">       
                                Register
                            </a>

                        @endif
                    @endauth
                </nav>
            @endif
        </header>
    </div>

    <!-- Hero Section -->    
    <div class="relative bg-gray-100 h-80 flex flex-col justify-center items-center text-center px-4 overflow-hidden">
        <img src="images/header.jpg" alt="" class="absolute w-full h-full object-cover -z-10">
        <div class="absolute inset-0 bg-black/30 -z-10"></div>
        <h1 class="text-4xl md:text-6xl font-bold mb-4 text-white">I-Creative</h1>
        <p class="text-xl md:text-2xl mb-8 text-white">Pusat Percetakan Taman Universiti</p>
    </div>

    <!-- Our Products Section -->
    <div class="container mx-auto px-4 py-12">
        <h2 class="text-3xl font-bold mb-8 text-center">Our Products</h2>

        <!-- Products Grid -->
        <div class="product-grid">
            <!-- Product 1 -->
            <div class="product-card">
            <img src="images/button-badge.jpg" alt="Button Badge" class="w-full h-70 object-cover mb-4 rounded">
                <h3 class="font-bold">BUTTON BADGE</h3>
                <p class="text-sm">Pilihan: Pin / Magnet</p><br>
            </div>
            
            <!-- Product 2 -->
            <div class="product-card">
            <img src="images/brochure.jpg" alt="Button Badge" class="w-full h-70 object-cover mb-4 rounded">
                <h3 class="font-bold">BROCHURES</h3>
                <p class="text-sm">Pelbagai saiz & lipatan</p><br>
            </div>
            
            <!-- Product 3 -->
            <div class="product-card">
            <img src="images/bunting.jpg" alt="Button Badge" class="w-full h-70 object-cover mb-4 rounded">
                <h3 class="font-bold">ROLL-UP BUNTING</h3>
                <p class="text-sm">Material: Synthetic Paper (200gsm / 320gsm)</p><br>
            </div>
            
            <!-- Product 4 -->
            <div class="product-card">
            <img src="images/velvet-box.jpg" alt="Button Badge" class="w-full h-70 object-cover mb-4 rounded">
                <h3 class="font-bold">VELVET BOX</h3>
                <p class="text-sm">Material: Wood & Velvet</p><br>
            </div>
            
            <!-- Product 5 -->
            <div class="product-card">
            <img src="images/banner.jpg" alt="Button Badge" class="w-full h-70 object-cover mb-4 rounded">
                <h3 class="font-bold">BANNER</h3>
                <p class="text-sm">Material: Tarpaulin (380gsm) <br>
                                   Saiz: Pelbagai</p><br>
            </div>
            
            <!-- Product 6 -->
            <div class="product-card">
            <img src="images/flyers.jpg" alt="Button Badge" class="w-full h-70 object-cover mb-4 rounded">
                <h3 class="font-bold">FLYERS</h3>
                <p class="text-sm">Material: Art Paper (Kertas Licin)</p><br>
            </div>
            
            <!-- Product 7 -->
            <div class="product-card">
            <img src="images/foamboard.jpg" alt="Button Badge" class="w-full h-70 object-cover mb-4 rounded">
                <h3 class="font-bold">FOAMBOARD</h3>
                <p class="text-sm">Material ringan, mudah dibawa & dipasang</p><br>
            </div>
            
            <!-- Product 8 -->
            <div class="product-card">
            <img src="images/mock-cheque.jpg" alt="Button Badge" class="w-full h-70 object-cover mb-5 rounded">
                <h3 class="font-bold">MOCK CHEQUE</h3>
                <p class="text-sm">Material: Foam Board</p><br>
            </div>
            </div>
            <br>

        <!-- More Link -->
        <div class="w-full text-center mt-8">
            <a href="{{ route('about') }}"  class="inline-block px-6 py-2 rounded hover:bg-purple-100 transition-colors">
                Discover More
            </a>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-custom-darkpurple text-white py-12 px-4">
        <div class="container mx-auto text-center"> 
            <div class="flex justify-center space-x-6 mb-6 text-white">
                <a href="https://www.facebook.com/szuplus" target="_blank" class="hover:text-gray-300 flex items-center space-x-2">
                    <i class="fab fa-facebook"></i>
                    <span>I-Creative</span>
                </a>
                
                <a href="https://www.instagram.com/icreativetm" target="_blank" class="hover:text-gray-300 flex items-center space-x-2">
                    <i class="fab fa-instagram"></i>
                    <span>icreativetm</span>
                </a>
                
                <a href="https://wa.me/60126826859" target="_blank" class="hover:text-gray-300 flex items-center space-x-2">
                    <i class="fab fa-whatsapp"></i>
                    <span>012-6826859</span>
                </a>
            </div>

            <p class="text-gray-300 font-serif text-sm font-semibold">©I-Creative. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>