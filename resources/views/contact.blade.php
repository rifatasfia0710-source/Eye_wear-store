@extends('layouts.home')

@section('title', 'About Us - Premium Eyewear')

@section('content')

    <div class="container mx-auto px-4 py-12">
        <div class="max-w-6xl mx-auto">
            <!-- Header -->
            <div class="text-center mb-12">
                <h1 class="text-4xl md:text-5xl font-bold text-slate-800 mb-4">Get In Touch</h1>
                <p class="text-lg text-slate-600">We'd love to hear from you. Send us a message and we'll respond as soon as possible.</p>
            </div>

            <div class="grid md:grid-cols-2 gap-8">
                <!-- Contact Form -->
                <div class="bg-white rounded-2xl shadow-xl p-8">
                    <h2 class="text-2xl font-semibold text-slate-800 mb-6">Send us a message</h2>
                    
                    @if(session('success'))
                        <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg mb-6">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('contact.submit') }}" method="POST">
                        @csrf
                        
                        <!-- Name Field -->
                        <div class="mb-5">
                            <label for="name" class="block text-sm font-medium text-slate-700 mb-2">Full Name</label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}" 
                                class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('name') border-red-500 @enderror" 
                                placeholder="John Doe" required>
                            @error('name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email Field -->
                        <div class="mb-5">
                            <label for="email" class="block text-sm font-medium text-slate-700 mb-2">Email Address</label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" 
                                class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('email') border-red-500 @enderror" 
                                placeholder="john@example.com" required>
                            @error('email')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Subject Field -->
                        <div class="mb-5">
                            <label for="subject" class="block text-sm font-medium text-slate-700 mb-2">Subject</label>
                            <input type="text" id="subject" name="subject" value="{{ old('subject') }}" 
                                class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('subject') border-red-500 @enderror" 
                                placeholder="How can we help?" required>
                            @error('subject')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Message Field -->
                        <div class="mb-6">
                            <label for="message" class="block text-sm font-medium text-slate-700 mb-2">Message</label>
                            <textarea id="message" name="message" rows="5" 
                                class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition resize-none @error('message') border-red-500 @enderror" 
                                placeholder="Tell us more about your inquiry..." required>{{ old('message') }}</textarea>
                            @error('message')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" 
                            class="bg-gradient-to-br from-purple-300 to-purple-500 text-white font-semibold py-3 px-6 rounded-lg transition duration-200 transform hover:scale-105">
                            Send Message
                        </button>
                    </form>
                </div>

                <!-- Contact Information -->
                <div class="space-y-6">
                    <!-- Info Card -->
                    <div class="bg-white rounded-2xl shadow-xl p-8">
                        <h2 class="text-2xl font-semibold text-slate-800 mb-6">Contact Information</h2>
                        
                        <!-- Address -->
                        <div class="flex items-start mb-6">
                            <div class="bg-blue-100 rounded-lg p-3 mr-4">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-slate-800 mb-1">Address</h3>
                                <p class="text-slate-600">123 Business Street<br>City, State 12345</p>
                            </div>
                        </div>

                        <!-- Phone -->
                        <div class="flex items-start mb-6">
                            <div class="bg-green-100 rounded-lg p-3 mr-4">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-slate-800 mb-1">Phone</h3>
                                <p class="text-slate-600">+1 (555) 123-4567</p>
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="flex items-start">
                            <div class="bg-purple-100 rounded-lg p-3 mr-4">
                                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-slate-800 mb-1">Email</h3>
                                <p class="text-slate-600">contact@example.com</p>
                            </div>
                        </div>
                    </div>

                    <!-- Business Hours -->
                    <div class="bg-gradient-to-br from-purple-300 to-purple-500 rounded-2xl shadow-xl p-8 text-white">
                        <h2 class="text-2xl font-semibold mb-4">Business Hours</h2>
                        <div class="space-y-2">
                            <div class="flex justify-between">
                                <span>Monday - Friday</span>
                                <span class="font-semibold">9:00 AM - 6:00 PM</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Saturday</span>
                                <span class="font-semibold">10:00 AM - 4:00 PM</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Sunday</span>
                                <span class="font-semibold">Closed</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

   @endsection