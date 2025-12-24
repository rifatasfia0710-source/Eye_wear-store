<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - VisionStyle</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { 
            font-family: 'Inter', sans-serif; 
        }
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
        }
        .glass-effect {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
        }
        .input-glow:focus {
            box-shadow: 0 0 0 3px rgba(124, 58, 237, 0.1);
        }
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        .floating {
            animation: float 6s ease-in-out infinite;
        }
    </style>
</head>

<body class="bg-gradient-to-br from-gray-50 to-gray-100">

    <div class="flex min-h-screen">
        
        <!-- Left Side - Enhanced Branding -->
        <div class="hidden lg:flex w-1/2 gradient-bg relative overflow-hidden items-center justify-center p-12">
            <!-- Animated Background Elements -->
            <div class="absolute inset-0 opacity-20">
                <div class="absolute top-20 left-20 w-72 h-72 bg-white rounded-full blur-3xl floating"></div>
                <div class="absolute bottom-20 right-20 w-96 h-96 bg-purple-300 rounded-full blur-3xl floating" style="animation-delay: 2s;"></div>
            </div>
            
            <div class="relative z-10 text-center max-w-lg">
                <div class="mb-8">
                    <svg class="w-24 h-24 mx-auto mb-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                </div>
                <h1 class="text-white text-6xl font-extrabold mb-6 leading-tight">Welcome to<br/>VisionStyle</h1>
                <p class="text-white text-xl opacity-95 leading-relaxed">Discover premium eyewear collections and exclusive designs crafted for your unique style.</p>
                <div class="mt-12 flex justify-center gap-8 text-white">
                    <div class="text-center">
                        <div class="text-3xl font-bold">10K+</div>
                        <div class="text-sm opacity-90">Happy Customers</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold">500+</div>
                        <div class="text-sm opacity-90">Products</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold">4.9★</div>
                        <div class="text-sm opacity-90">Rating</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side - Modern Login Form -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-6 lg:p-12">
            <div class="w-full max-w-md">
                
                <!-- Mobile Logo -->
                <div class="lg:hidden text-center mb-8">
                    <svg class="w-16 h-16 mx-auto mb-3 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                    <h2 class="text-2xl font-bold text-gray-800">VisionStyle</h2>
                </div>

                <div class="glass-effect shadow-2xl rounded-3xl p-8 lg:p-10">

                    <div class="mb-8">
                        <h2 class="text-3xl font-bold text-gray-800 mb-2">Welcome Back!</h2>
                        <p class="text-gray-600">Enter your credentials to access your account</p>
                    </div>

                    <!-- Form -->
                    <form method="POST" action="{{ route('login') }}" class="space-y-6">
                        @csrf

                        <!-- Email Input -->
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2 text-sm">Email Address</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                                    </svg>
                                </div>
                                <input type="email" name="email" required 
                                    class="w-full pl-12 pr-4 py-3.5 border-2 border-gray-200 rounded-xl focus:border-purple-500 outline-none transition input-glow bg-white text-gray-800"
                                    placeholder="you@example.com">
                            </div>
                        </div>

                        <!-- Password Input -->
                        <div>
                            <div class="flex justify-between items-center mb-2">
                                <label class="block text-gray-700 font-semibold text-sm">Password</label>
                                <a href="#" class="text-sm text-purple-600 hover:text-purple-700 font-medium">Forgot?</a>
                            </div>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                    </svg>
                                </div>
                                <input type="password" name="password" required 
                                    class="w-full pl-12 pr-4 py-3.5 border-2 border-gray-200 rounded-xl focus:border-purple-500 outline-none transition input-glow bg-white text-gray-800"
                                    placeholder="••••••••">
                            </div>
                        </div>

                        <!-- Remember Me -->
                        <div class="flex items-center">
                            <input type="checkbox" id="remember" class="w-4 h-4 text-purple-600 border-gray-300 rounded focus:ring-purple-500">
                            <label for="remember" class="ml-2 text-sm text-gray-600">Remember me for 30 days</label>
                        </div>

                        <!-- Login Button -->
                        <button type="submit" class="w-full bg-gradient-to-r from-purple-600 to-indigo-600 text-white py-4 rounded-xl font-semibold text-lg hover:from-purple-700 hover:to-indigo-700 transition shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 duration-200">
                            Sign In
                        </button>

                        <!-- Divider -->
                        <div class="relative my-6">
                            <div class="absolute inset-0 flex items-center">
                                <div class="w-full border-t border-gray-300"></div>
                            </div>
                            <!-- <div class="relative flex justify-center text-sm">
                                <span class="px-4 bg-white text-gray-500">Or continue with</span>
                            </div> -->
                        </div>

                        <!-- Social Login -->
                        <!-- <div class="grid grid-cols-2 gap-3">
                            <button type="button" class="flex items-center justify-center px-4 py-3 border-2 border-gray-200 rounded-xl hover:bg-gray-50 transition">
                                <svg class="w-5 h-5 mr-2" viewBox="0 0 24 24">
                                    <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                                    <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                                    <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                                    <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                                </svg>
                                <span class="text-sm font-medium text-gray-700">Google</span>
                            </button>
                            <button type="button" class="flex items-center justify-center px-4 py-3 border-2 border-gray-200 rounded-xl hover:bg-gray-50 transition">
                                <svg class="w-5 h-5 mr-2" fill="#1877F2" viewBox="0 0 24 24">
                                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                </svg>
                                <span class="text-sm font-medium text-gray-700">Facebook</span>
                            </button>
                        </div> -->

                        <!-- Register Link -->
                        <p class="text-center text-gray-600 mt-6">
                            Don't have an account?
                            <a href="{{ route('register') }}" class="text-purple-600 font-semibold hover:text-purple-700 transition">Create Account</a>
                        </p>
                    </form>

                </div>

                <!-- Footer -->
                <p class="text-center text-gray-500 text-sm mt-8">
                    © 2024 VisionStyle. All rights reserved.
                </p>

            </div>
        </div>

    </div>

</body>
</html>