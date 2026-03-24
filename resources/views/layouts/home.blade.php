<!DOCTYPE html>
<html lang="en" data-qb-installed="true">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!--=== CSS Files ===-->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('')}}frontend/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{asset('')}}frontend/assets/fonts/flaticon.css">
    <link rel="stylesheet" href="{{asset('')}}frontend/assets/css/nice-select.min.css">
    <link rel="stylesheet" href="{{asset('')}}frontend/assets/css/boxicons.min.css">
    <link rel="stylesheet" href="{{asset('')}}frontend/assets/css/meanmenu.css">
    <link rel="stylesheet" href="{{asset('')}}frontend/assets/css/settings.css">
    <link rel="stylesheet" href="{{asset('')}}frontend/assets/css/layers.css">
    <link rel="stylesheet" href="{{asset('')}}frontend/assets/css/navigation.css">
    <link rel="stylesheet" href="{{asset('')}}frontend/assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="{{asset('')}}frontend/assets/css/owl.theme.default.min.css">
    <link rel="stylesheet" href="{{asset('')}}frontend/assets/css/modal-video.min.css">
    <link rel="stylesheet" href="{{asset('')}}frontend/assets/css/style.css">
    <link rel="stylesheet" href="{{asset('')}}frontend/assets/css/responsive.css">
    <link rel="stylesheet" href="{{asset('')}}frontend/assets/notifications/notification.css">
<link rel="stylesheet" href="{{asset('')}}frontend/assets/css/custom.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

</head>

<body style="font-family: 'Inter', sans-serif;">

<style>
    .bx-x:hover {
        color: red !important;
        cursor: pointer;
        transform: scale(1.2);
        transition: transform 0.3s ease;
    }
    /* Remove all gaps between navbar and hero */
body {
    margin: 0;
    padding: 0;
}

nav {
    margin-bottom: 0 !important;
}

.banner-area-two {
    margin-top: 0 !important;
    padding-top: 0 !important;
}

.banner-slider {
    margin-top: 0 !important;
}
</style>

<!-- ================= NAVBAR ================== -->

<nav class="bg-gray-100 shadow-md sticky top-0 z-50 mb-0">
    <div class="container mx-auto px-4 py-3">
        <div class="flex items-center justify-between">

            <!-- Logo -->
            <div class="text-2xl font-bold text-purple-600">VisionStyle</div>

            <!-- Menu -->
            <div class="hidden md:flex space-x-8">
                <a href="{{ route('home') }}" class="text-gray-700 hover:text-purple-600">Home</a>
                <a href="{{ route('frontend.shop') }}" class="text-gray-700 hover:text-purple-600">Shop</a>
                
                <a href="{{ route('aboutus') }}" class="text-gray-700 hover:text-purple-600">About Us</a>
                <a href="{{ route('contact.show') }}" class="text-gray-700 hover:text-purple-600">Contact</a>
                <a href="{{ route('faq') }}" class="text-gray-700 hover:text-purple-600">FAQ's</a>
            </div>

            <!-- Icons / Buttons -->
            <div class="flex items-center space-x-4">

                <!-- Search -->
                <!-- <button class="text-gray-700 hover:text-purple-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button> -->

                <!-- User Icon -->
                <!-- <a href="{{ route('login') }}" class="text-gray-700 hover:text-purple-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </a> -->

                <!-- Cart -->
                <!-- <button class="text-gray-700 hover:text-purple-600 relative">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    <span class="absolute -top-2 -right-2 bg-purple-600 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">3</span>
                </button> -->

                <!-- Login -->
                <a href="{{ route('login') }}" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700">
                    Login
                </a>

                <!-- Register -->
                <a href="{{ route('register') }}" class="px-4 py-2 border border-purple-600 text-purple-600 rounded-lg hover:bg-purple-600 hover:text-white">
                    Register
                </a>

            </div>
        </div>
    </div>
</nav>

<!-- ================= END NAVBAR ================= -->
@yield('content')
<!-- ================= FOOTER ================= -->

<footer class="bg-gray-900 text-white py-12">
    <div class="max-w-7xl mx-auto px-6">

        <!-- Main Footer - Horizontal Flex Layout -->
        <div class="flex flex-wrap justify-between items-start gap-12 mb-10">

            <!-- Brand Section -->
            <div class="flex-shrink-0">
                <h3 class="text-white text-xl font-bold mb-3">VisionStyle</h3>
                <p class="text-gray-400 text-sm max-w-xs">
                    Your trusted destination for premium eyewear.
                </p>
            </div>

            <!-- Shop Links -->
            <div class="flex-shrink-0">
                <h4 class="text-white font-semibold mb-4">Shop</h4>
                <ul class="space-y-2">
                    <li><a href="#" class="text-gray-300 hover:text-white text-sm transition-colors">Prescription Glasses</a></li>
                    <li><a href="#" class="text-gray-300 hover:text-white text-sm transition-colors">Sunglasses</a></li>
                    <li><a href="#" class="text-gray-300 hover:text-white text-sm transition-colors">Blue Light Glasses</a></li>
                    <li><a href="#" class="text-gray-300 hover:text-white text-sm transition-colors">Kids Eyewear</a></li>
                </ul>
            </div>

            <!-- Support Links -->
            <div class="flex-shrink-0">
                <h4 class="text-white font-semibold mb-4">Support</h4>
                <ul class="space-y-2">
                    <li><a href="{{ route('contact.show') }}" class="hover:text-white">Contact Us</a></li>
                    <li><a href="{{ route('delivery-policy') }}" class="hover:text-white">Delivery Policy</a></li>
                    <li><a href="{{ route('returns') }}" class="hover:text-white">Returns</a></li>
                    <li><a href="{{ route('faq') }}" class="hover:text-white">FAQ</a></li>
                </ul>
            </div>

            <!-- Social Media -->
            <div class="flex-shrink-0">
                <h4 class="text-white font-semibold mb-4">Follow Us</h4>
                <div class="flex space-x-4">
                    <!-- Facebook -->
                    <a href="https://www.facebook.com" 
                       class="text-white hover:text-purple-400 transition-colors text-xl">
                        <i class="fab fa-facebook-f"></i>
                    </a>

                    <!-- Instagram -->
                    <a href="https://www.instagram.com" 
                       class="text-white hover:text-purple-400 transition-colors text-xl">
                        <i class="fab fa-instagram"></i>
                    </a>

                    <!-- Twitter (X) -->
                    <a href="https://twitter.com" 
                       class="text-white hover:text-purple-400 transition-colors text-xl">
                        <i class="fab fa-x-twitter"></i>
                    </a>
                </div>
            </div>

        </div>

        <!-- Footer Bottom - Copyright -->
        <div class="border-t border-gray-700 pt-6">
            <p class="text-center text-gray-400 text-sm">
                © 2024 VisionStyle. All rights reserved.
            </p>
        </div>

    </div>
</footer>
<!-- JS FILES -->
<script src="{{asset('')}}frontend/assets/js/jquery.min.js"></script>
<script src="{{asset('')}}frontend/assets/js/bootstrap.bundle.min.js"></script>
<script src="{{asset('')}}frontend/assets/js/custom.js"></script>



</body>
</html>
