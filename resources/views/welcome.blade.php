<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <script src="//unpkg.com/alpinejs" defer></script>
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
        .bg-pink-transparent {
        background-color: rgba(255, 192, 203, 0.3); 
        }
        .floating-card {
        position: relative;
        border-radius: 16px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        border-top: 3px solid #de1e2e;
        border-bottom: 3px solid #de1e2e;
        transition: transform 0.3s ease;
        }

        .floating-card:hover {
            transform: translateY(-5px);
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
                        Login / Sign Up
                    </a>
                @endauth


                <!-- Track Order Button -->
                <button 
                    x-data 
                    @click="$dispatch('open-track-order')" 
                    class="inline-block px-5 py-1.5 bg-red-600 text-white rounded-sm text-sm leading-normal hover:bg-red-700 transition"
                >
                    Track Order
                </button>
            </nav>
        @endif
    </header>
</div>
 <!-- Track Order Modal -->
<div 
    x-data="{
        open: false,
        orderId: '',
        loading: false,
        result: null,
        error: '',
        getStatusColor(status) {
            switch (status) {
                case 'waiting': return 'bg-gray-400 text-white';
                case 'printing': return 'bg-green-500 text-white';
                case 'can_pick_up': return 'bg-yellow-500 text-white';
                case 'picked_up': return 'bg-indigo-500 text-white';
                default: return 'bg-gray-200 text-gray-800';
            }
        }
    }"
    x-on:open-track-order.window="open = true"
    x-show="open"
    style="background: rgba(0,0,0,0.4)"
    class="fixed inset-0 flex items-center justify-center z-50"
    x-cloak
>
    <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md relative">
        <!-- Icon Row -->
        <div class="absolute top-2 right-2 flex items-center space-x-3">
            <!-- Refresh/Clear Icon -->
            <i 
                class="fas fa-rotate-right cursor-pointer text-gray-400 hover:text-blue-600 text-xl"
                title="Clear"
                @click="orderId = ''; result = null; error = ''"
            ></i>
            <!-- Close Icon -->
            <button @click="open = false" class="text-gray-400 hover:text-gray-700 text-2xl" title="Close">&times;</button>
        </div>
        <h2 class="text-xl font-bold mb-4">Track Your Order</h2>
        <form @submit.prevent="
            loading = true;
            error = '';
            result = null;
            fetch('/track-order?order_id=' + orderId)
                .then(res => res.ok ? res.json() : Promise.reject(res))
                .then(data => { result = data; loading = false; })
                .catch(async err => {
                    loading = false;
                    error = (await err.text()) || 'Order not found';
                });
        ">
            <input type="text" x-model="orderId" placeholder="Enter Order ID" class="border rounded px-3 py-2 w-full mb-4" required>
            <div class="flex gap-2">
                <button type="submit" class="flex-1 bg-red-600 text-white py-2 rounded hover:bg-red-700 transition" :disabled="loading">
                    <span x-show="!loading">Track</span>
                    <span x-show="loading">Loading...</span>
                </button>
            </div>
        </form>
        <template x-if="result">
            <div class="mt-4 p-4 bg-gray-50 rounded border">
                <div class="font-semibold mb-2">Order: <span x-text="result.no_order"></span></div>
                <div>
                    Status:
                    <span
                        x-bind:class="result ? getStatusColor(result.status) + ' px-2 py-1 rounded font-bold ml-1' : ''"
                        x-text="result ? result.status.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase()) : ''"
                        style="display: inline-block;"
                    ></span>
                </div>
                <div>Description: <span x-text="result.description"></span></div>
                <div>Total Price: RM <span x-text="result.price"></span></div>
            </div>
        </template>
        <div x-show="error" class="mt-4 text-red-600" x-text="error"></div>
    </div>
</div>
        </form>
        <template x-if="result">
            <div class="mt-4 p-4 bg-gray-50 rounded border">
                <div class="font-semibold mb-2">Order: <span x-text="result.no_order"></span></div>
                <div>Status: <span class="font-bold" x-text="result.status"></span></div>
                <div>Description: <span x-text="result.description"></span></div>
                <div>Total Price: RM <span x-text="result.price"></span></div>
            </div>
        </template>
        <div x-show="error" class="mt-4 text-red-600" x-text="error"></div>
    </div>
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
                    <img src="images/foamboard.jpg" alt="I-Creative Banner 3" class="w-full h-full object-cover">
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

        <!-- No SSM Section -->
        <div class="container mx-auto px-4 py-12">
            <h3 class="text-xl font-bold text-center">No SSM</h3>
        </div>

        <!-- Promotion Section -->
        <div class="container mx-auto px-4 py-12">
            <h2 class="text-3xl font-bold mb-8 text-center">Promotions</h2>
            <livewire:home-promotions />
        </div>

    <!-- Our Products Section -->
        <div class="container mx-auto px-4 py-12">
            <h2 class="text-3xl font-bold mb-8 text-center">Our Products</h2>
            <livewire:home-products />
        </div>

    <!-- About Us Section -->
    <div class="container mx-auto px-4">
        <div class="floating-card max-w-6xl mx-auto p-8 bg-white bg-opacity-70">
            <h2 class="text-2xl font-semibold mb-8 text-center">About Us</h2>
            <div class="max-w-4xl mx-auto">
                <p class="text-lg text-gray-700 mb-6 text-center text-justify">
                    I-Creative is a leading provider of high-quality printing solutions, specializing in custom promotional materials, banners and more. Our mission is to help businesses and individuals bring their creative ideas to life with exceptional print products that stand out.
                </p>
                <p class="text-lg text-gray-700 mb-6 text-center text-justify">
                    Our team of experienced professionals is dedicated to delivering top-notch products and services, ensuring that your vision is realized with precision and care. We pride ourselves on our attention to detail, quick turnaround times, and competitive pricing.
                </p>
                </div>
        </div>
    </div><br><br>


    <!-- Team Section -->
    <div class="mt-12">
        <h2 class="text-2xl font-semibold mb-8 text-center">Our Team</h2><br>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8">
            <!-- Manager -->
            <div class="flex flex-col items-center">
                <div class="w-32 h-32 rounded-full overflow-hidden border-4 border-white shadow-lg">
                    <img src="/path-to-manager-image.jpg" alt="Manager" class="w-full h-full object-cover">
                </div>
                <h4 class="mt-4 text-xl font-medium">......</h4>
                <p class="text-gray-600">Manager</p>
            </div>
            
            <!-- Marketing -->
            <div class="flex flex-col items-center">
                <div class="w-32 h-32 rounded-full overflow-hidden border-4 border-white shadow-lg">
                    <img src="/path-to-marketing-image.jpg" alt="Marketing" class="w-full h-full object-cover">
                </div>
                <h4 class="mt-4 text-xl font-medium">.....</h4>
                <p class="text-gray-600">Marketing</p>
            </div>
            
            <!-- Production -->
            <div class="flex flex-col items-center">
                <div class="w-32 h-32 rounded-full overflow-hidden border-4 border-white shadow-lg">
                    <img src="/path-to-production-image.jpg" alt="Production" class="w-full h-full object-cover">
                </div>
                <h4 class="mt-4 text-xl font-medium">.....</h4>
                <p class="text-gray-600">Production</p>
            </div>
            
            <!-- Promotion -->
            <div class="flex flex-col items-center">
                <div class="w-32 h-32 rounded-full overflow-hidden border-4 border-white shadow-lg">
                    <img src="/path-to-promotion-image.jpg" alt="Promotion" class="w-full h-full object-cover">
                </div>
                <h4 class="mt-4 text-xl font-medium">......</h4>
                <p class="text-gray-600">Promotion</p>
            </div>
        </div>
    </div>
</div>
</div></div><br>

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
        <a href="{{ route('login') }}" class="block w-38 bg-white text-black px-4 py-2 rounded-lg shadow hover:bg-gray-100 text-sm"><i class="fas fa-sign-in-alt mr-2"></i>Login / Sign Up</a>
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