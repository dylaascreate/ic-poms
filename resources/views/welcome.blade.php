<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>I-Creative</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
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
        .bg-custom-maroon {
            background-color: #730505;
        }
        #bubbleMenu {
            transition: all 0.3s ease-in-out;
        }
        
        /* New styles for product carousel */
        .product-carousel-container {
            position: relative;
            margin: 0 auto;
            max-width: 1200px;
            z-index: 1;
        }
        .product-carousel {
            overflow: hidden;
            padding: 10px 0;
        }
        .carousel-track {
            display: flex;
            transition: transform 0.5s ease;
            gap: 20px;
        }
        .product-card {
            flex: 0 0 calc(50% - 10px);
            min-width: 250px;
        }
        .carousel-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: white;
            border: none;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            justify-content: center;
            align-items: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
            cursor: pointer;
            z-index: 10;
        }
        .carousel-prev {
            left: -20px;
        }
        .carousel-next {
            right: -20px;
        }
        @media (min-width: 768px) {
            .product-card {
                flex: 0 0 calc(33.333% - 14px);
            }
        }
        @media (min-width: 1024px) {
            .product-card {
                flex: 0 0 calc(25% - 15px);
            }
        }
        /*Hero Carousel Styles*/
        .hero-carousel {
            position: relative;
        }
        .hero-slide {
            position: absolute;
            width: 100%;
            height: 100%;
            opacity: 0;
            transition: opacity 1s ease-in-out;
        }
        .hero-slide.active {
            opacity: 1;
            position: absolute;
            width: 100%;
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
                        <a href="{{ url('/dashboard') }}" class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] text-[#1b1b18] border border-transparent hover:border-[#19140035] dark:hover:border-[#3E3E3A] rounded-sm text-sm leading-normal">
                            Log in
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] text-[#1b1b18] border border-transparent hover:border-[#19140035] dark:hover:border-[#3E3E3A] rounded-sm text-sm leading-normal">       
                                Register
                            </a>
                        @endif
                    @endauth
                </nav>
            @endif
        </header>
    </div>

        <!-- Hero Section -->
        <div class="relative bg-gray-100 h-80 md:h-96 flex flex-col justify-center items-center text-center px-4 overflow-hidden">
            <!-- Carousel Container -->
            <div class="hero-carousel absolute w-full h-full -z-20">
                <!-- Image 1 (Active by default) -->
                <div class="hero-slide active">
                    <img src="images/header.jpg" alt="I-Creative Banner 1" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-black/30"></div>
                </div>

                <!-- Image 2 -->
                <div class="hero-slide">
                    <img src="images/banner.jpg" alt="I-Creative Banner 2" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-black/30"></div>
                </div>
                
                <!-- Image 3 -->
                <div class="hero-slide">
                    <img src="images/flyers.jpg" alt="I-Creative Banner 3" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-black/30"></div>
                </div>
            </div>
            
            <!-- Navigation Dots -->
            <div class="hero-dots absolute bottom-4 flex space-x-2">
                <button class="w-3 h-3 rounded-full bg-white/50 hover:bg-white transition" data-slide="0"></button>
                <button class="w-3 h-3 rounded-full bg-white/50 hover:bg-white transition" data-slide="1"></button>
                <button class="w-3 h-3 rounded-full bg-white/50 hover:bg-white transition" data-slide="2"></button>
            </div>
        </div>

        <!-- Promotion Section -->
        <div class="container mx-auto px-4 py-12">
            <h2 class="text-3xl font-bold mb-8 text-center">Promotions</h2>

        <!-- Promotion Carousel -->
        <div class="product-carousel-container">
            <button class="carousel-btn carousel-prev" aria-label="Previous">
                <i class="fas fa-chevron-left"></i>
            </button>
            <button class="carousel-btn carousel-next" aria-label="Next">
                <i class="fas fa-chevron-right"></i>
            </button>
            
            <div class="product-carousel">
                <div class="carousel-track">
                    <div class="product-card">
                        <img src="images/button-badge.jpg" alt="Button Badge" class="w-full h-70 object-cover mb-4 rounded">
                        <h3 class="font-bold">BUTTON BADGE</h3>
                        <p class="text-sm">Pilihan: Pin / Magnet</p><br>
                    </div>
                    <div class="product-card">
                        <img src="images/brochure.jpg" alt="Brochure" class="w-full h-70 object-cover mb-4 rounded">
                        <h3 class="font-bold">BROCHURES</h3>
                        <p class="text-sm">Pelbagai saiz & lipatan</p><br>
                    </div>
                    <div class="product-card">
                        <img src="images/bunting.jpg" alt="Bunting" class="w-full h-70 object-cover mb-4 rounded">
                        <h3 class="font-bold">ROLL-UP BUNTING</h3>
                        <p class="text-sm">Material: Synthetic Paper (200gsm / 320gsm)</p><br>
                    </div>
                    <div class="product-card">
                        <img src="images/velvet-box.jpg" alt="Velvet Box" class="w-full h-70 object-cover mb-4 rounded">
                        <h3 class="font-bold">VELVET BOX</h3>
                        <p class="text-sm">Material: Wood & Velvet</p><br>
                    </div>
                    <div class="product-card">
                        <img src="images/banner.jpg" alt="Banner" class="w-full h-70 object-cover mb-4 rounded">
                        <h3 class="font-bold">BANNER</h3>
                        <p class="text-sm">Material: Tarpaulin (380gsm) <br>Saiz: Pelbagai</p><br>
                    </div>
                    <div class="product-card">
                        <img src="images/flyers.jpg" alt="Flyers" class="w-full h-70 object-cover mb-4 rounded">
                        <h3 class="font-bold">FLYERS</h3>
                        <p class="text-sm">Material: Art Paper (Kertas Licin)</p><br>
                    </div>
                    <div class="product-card">
                        <img src="images/foamboard.jpg" alt="Foamboard" class="w-full h-70 object-cover mb-4 rounded">
                        <h3 class="font-bold">FOAMBOARD</h3>
                        <p class="text-sm">Material ringan, mudah dibawa & dipasang</p><br>
                    </div>
                    <div class="product-card">
                        <img src="images/mock-cheque.jpg" alt="Mock Cheque" class="w-full h-70 object-cover mb-5 rounded">
                        <h3 class="font-bold">MOCK CHEQUE</h3>
                        <p class="text-sm">Material: Foam Board</p>
                    </div>
                </div>
            </div>
        </div>

    <!-- Our Products Section -->
    <div class="container mx-auto px-4 py-12">
        <h2 class="text-3xl font-bold mb-8 text-center">Our Products</h2>

        <!-- Products Carousel -->
        <div class="product-carousel-container">
            <button class="carousel-btn carousel-prev" aria-label="Previous">
                <i class="fas fa-chevron-left"></i>
            </button>
            <button class="carousel-btn carousel-next" aria-label="Next">
                <i class="fas fa-chevron-right"></i>
            </button>
            
            <div class="product-carousel">
                <div class="carousel-track">
                    <div class="product-card">
                        <img src="images/button-badge.jpg" alt="Button Badge" class="w-full h-70 object-cover mb-4 rounded">
                        <h3 class="font-bold">BUTTON BADGE</h3>
                        <p class="text-sm">Pilihan: Pin / Magnet</p><br>
                    </div>
                    <div class="product-card">
                        <img src="images/brochure.jpg" alt="Brochure" class="w-full h-70 object-cover mb-4 rounded">
                        <h3 class="font-bold">BROCHURES</h3>
                        <p class="text-sm">Pelbagai saiz & lipatan</p><br>
                    </div>
                    <div class="product-card">
                        <img src="images/bunting.jpg" alt="Bunting" class="w-full h-70 object-cover mb-4 rounded">
                        <h3 class="font-bold">ROLL-UP BUNTING</h3>
                        <p class="text-sm">Material: Synthetic Paper (200gsm / 320gsm)</p><br>
                    </div>
                    <div class="product-card">
                        <img src="images/velvet-box.jpg" alt="Velvet Box" class="w-full h-70 object-cover mb-4 rounded">
                        <h3 class="font-bold">VELVET BOX</h3>
                        <p class="text-sm">Material: Wood & Velvet</p><br>
                    </div>
                    <div class="product-card">
                        <img src="images/banner.jpg" alt="Banner" class="w-full h-70 object-cover mb-4 rounded">
                        <h3 class="font-bold">BANNER</h3>
                        <p class="text-sm">Material: Tarpaulin (380gsm) <br>Saiz: Pelbagai</p><br>
                    </div>
                    <div class="product-card">
                        <img src="images/flyers.jpg" alt="Flyers" class="w-full h-70 object-cover mb-4 rounded">
                        <h3 class="font-bold">FLYERS</h3>
                        <p class="text-sm">Material: Art Paper (Kertas Licin)</p><br>
                    </div>
                    <div class="product-card">
                        <img src="images/foamboard.jpg" alt="Foamboard" class="w-full h-70 object-cover mb-4 rounded">
                        <h3 class="font-bold">FOAMBOARD</h3>
                        <p class="text-sm">Material ringan, mudah dibawa & dipasang</p><br>
                    </div>
                    <div class="product-card">
                        <img src="images/mock-cheque.jpg" alt="Mock Cheque" class="w-full h-70 object-cover mb-5 rounded">
                        <h3 class="font-bold">MOCK CHEQUE</h3>
                        <p class="text-sm">Material: Foam Board</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

        <div class="w-full text-center mt-8">
            <a href="{{ route('login') }}" class="inline-block px-6 py-2 rounded hover:bg-red-100 transition-colors">
                Discover More
            </a>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-custom-maroon text-white py-12 px-4">
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
            <p class="text-gray-300 font-mono text-sm font-semibold">©I-Creative 2025. All rights reserved.</p>
        </div>
    </footer>

    <!-- Floating Bubble Button with Nav and Socmed -->
    <div id="bubbleNav" class="fixed bottom-5 left-5 z-50">
        <button onclick="toggleBubbleMenu()" class="w-14 h-14 bg-red-600 text-white rounded-full shadow-lg flex items-center justify-center hover:bg-red-700 focus:outline-none">
            <i class="fas fa-bars"></i>
        </button>
    <div id="bubbleMenu" class="mt-3 hidden flex-col space-y-2">
        
    <!-- App Nav -->
        <a href="{{ route('login') }}" class="block w-38 bg-white text-black px-4 py-2 rounded-lg shadow hover:bg-gray-100 text-sm"><i class="fas fa-sign-in-alt mr-2"></i>Login / Register</a>
        <a href="/" class="block w-38 bg-white text-black px-4 py-2 rounded-lg shadow hover:bg-gray-100 text-sm"><i class="fas fa-home mr-2"></i>Home</a>
    <!-- Social Media -->
        <a href="https://www.facebook.com/szuplus" target="_blank" class="block w-38 bg-white text-blue-600 px-4 py-2 rounded-lg shadow hover:bg-gray-100 text-sm">
            <i class="fab fa-facebook mr-2"></i>Facebook
        </a>
        <a href="https://www.instagram.com/icreativetm" target="_blank" class="block w-38 bg-white text-pink-600 px-4 py-2 rounded-lg shadow hover:bg-gray-100 text-sm">
            <i class="fab fa-instagram mr-2"></i>Instagram
        </a>
        <a href="https://wa.me/60126826859" target="_blank" class="block w-38 bg-white text-green-600 px-4 py-2 rounded-lg shadow hover:bg-gray-100 text-sm">
            <i class="fab fa-whatsapp mr-2"></i>WhatsApp
        </a>
        </div>
    </div>

    <!-- Toggle Script -->
    <script>
        function toggleBubbleMenu() {
        document.getElementById('bubbleMenu').classList.toggle('hidden');
        }
        
        // Hero Carousel Script
        document.addEventListener('DOMContentLoaded', function() {
            const slides = document.querySelectorAll('.hero-slide');
            const dots = document.querySelectorAll('.hero-dots button');
            let currentSlide = 0;
            let slideInterval;
        
            // Function to change slide
            function goToSlide(n) {
                slides[currentSlide].classList.remove('active');
                dots[currentSlide].classList.remove('bg-white');
                dots[currentSlide].classList.add('bg-white/50');
                
                currentSlide = (n + slides.length) % slides.length;
                
                slides[currentSlide].classList.add('active');
                dots[currentSlide].classList.remove('bg-white/50');
                dots[currentSlide].classList.add('bg-white');
            }
            
            // Auto-scroll function
            function startCarousel() {
                slideInterval = setInterval(() => {
                    goToSlide(currentSlide + 1);
                }, 3000); // Change slide every 3 seconds
            }
            
            // Pause on hover
            const carousel = document.querySelector('.hero-carousel');
            carousel.addEventListener('mouseenter', () => clearInterval(slideInterval));
            carousel.addEventListener('mouseleave', startCarousel);
            
            // Dot navigation
            dots.forEach((dot, index) => {
                dot.addEventListener('click', () => {
                    clearInterval(slideInterval);
                    goToSlide(index);
                    startCarousel();
                });
            });
            
            // Initialize
            dots[0].classList.remove('bg-white/50');
            dots[0].classList.add('bg-white');
            startCarousel();

            // Product Carousel Script - modified to handle multiple carousels
            const carousels = document.querySelectorAll('.product-carousel-container');
            
            carousels.forEach(container => {
                const track = container.querySelector('.carousel-track');
                const prevBtn = container.querySelector('.carousel-prev');
                const nextBtn = container.querySelector('.carousel-next');
                const products = container.querySelectorAll('.product-card');
                let productWidth = products[0] ? products[0].offsetWidth + 20 : 0; // including gap
                let currentPosition = 0;
                let maxPosition = 0;
                
                function updateMaxPosition() {
                    if (!products.length) return;
                    
                    productWidth = products[0].offsetWidth + 20;
                    const screenWidth = window.innerWidth;
                    let visibleProducts = 4; // default for large screens
                    
                    if (screenWidth < 768) {
                        visibleProducts = 1;
                    } else if (screenWidth < 1024) {
                        visibleProducts = 2;
                    } else if (screenWidth < 1280) {
                        visibleProducts = 3;
                    }
                    
                    maxPosition = -(productWidth * (products.length - visibleProducts));
                    if (currentPosition < maxPosition) {
                        currentPosition = maxPosition;
                        track.style.transform = `translateX(${currentPosition}px)`;
                    }
                }
                
                // Initialize
                updateMaxPosition();
                
                // Navigation
                nextBtn?.addEventListener('click', function() {
                    currentPosition -= productWidth * 1;
                    if (currentPosition < maxPosition) {
                        currentPosition = maxPosition;
                    }
                    track.style.transform = `translateX(${currentPosition}px)`;
                });
                
                prevBtn?.addEventListener('click', function() {
                    currentPosition += productWidth * 1;
                    if (currentPosition > 0) {
                        currentPosition = 0;
                    }
                    track.style.transform = `translateX(${currentPosition}px)`;
                });
                
                // Handle window resize
                window.addEventListener('resize', updateMaxPosition);
            });
        });
    </script>
</body>
</html>