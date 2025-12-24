@extends('layouts.index')
@section('title', 'About us')
@section('main')

<!-- Main content starts -->
<nav class="bg-gray-100 shadow-md sticky top-0 z-50">
    <!-- Navbar content here -->
</nav>

<main class="main single-page">
    <section class="section-padding mt-100 mb-50">
        <div class="container pt-25">
            <div class="row">
                <div class="col-lg-12 align-self-center mb-lg-0 mb-4">
                    <h6 class="mt-0 mb-15 text-uppercase font-sm text-brand wow fadeIn animated">Our Company</h6>
                    @foreach($aboutus as $about)
                        <h1>{{ $about->title }}</h1>
                        <p>{!! $about->about_desc !!}</p>
                    @endforeach

                </div>
            </div>
        </div>
    </section>
</main>

<!-- Team Section -->
<section class="py-16 bg-white">
    <!-- Team content here -->
</section>

<!-- Mission Banner -->
<section class="py-20 bg-gradient-to-r from-purple-600 to-pink-500 text-white text-center">
    <!-- Mission content here -->
</section>

<!-- Footer -->
<footer class="bg-gray-900 text-gray-300 py-12">
    <!-- Footer content here -->
</footer>

@endsection
