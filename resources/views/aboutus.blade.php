@extends('layouts.home')

@section('title', 'About Us - Premium Eyewear')

@section('content')
<main class="main">
<div class="about-us-page">
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="hero-content">
                <h1>Our Vision, Your Style</h1>
                <p>Crafting exceptional eyewear experiences since 2010</p>
            </div>
        </div>
    </section>

    <!-- Our Story Section -->
    <section class="story-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="story-image">
                        <img src="{{ asset('storage/ads_banner/1717576512.jpg') }}" alt="Our Story" class="img-fluid">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="story-content">
                        <h2>Our Story</h2>
                        <p>What began as a small passion project has evolved into a leading destination for quality eyewear. We believe that glasses are more than just a vision correction tool—they're a statement of personal style and confidence.</p>
                        <p>Our journey started with a simple mission: to make premium eyewear accessible to everyone. Today, we serve thousands of satisfied customers worldwide, offering carefully curated collections that blend fashion, function, and affordability.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Values Section -->
    <section class="values-section">
        <div class="container">
            <h2 class="section-title">Our Values</h2>
            <div class="row">
                <div class="col-md-4">
                    <div class="value-card">
                        <div class="icon">
                            <i class="fas fa-eye"></i>
                        </div>
                        <h3>Quality First</h3>
                        <p>Every frame is meticulously crafted with premium materials and undergoes rigorous quality checks to ensure durability and comfort.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="value-card">
                        <div class="icon">
                            <i class="fas fa-palette"></i>
                        </div>
                        <h3>Style Innovation</h3>
                        <p>We stay ahead of trends, curating collections that combine timeless elegance with contemporary design.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="value-card">
                        <div class="icon">
                            <i class="fas fa-heart"></i>
                        </div>
                        <h3>Customer Care</h3>
                        <p>Your satisfaction is our priority. We provide exceptional service, from selection to after-sales support.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats-section">
        <div class="container">
            <div class="row text-center">
                <div class="col-md-3 col-6">
                    <div class="stat-item">
                        <h3 class="stat-number">50K+</h3>
                        <p>Happy Customers</p>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-item">
                        <h3 class="stat-number">500+</h3>
                        <p>Unique Designs</p>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-item">
                        <h3 class="stat-number">15+</h3>
                        <p>Years Experience</p>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-item">
                        <h3 class="stat-number">99%</h3>
                        <p>Satisfaction Rate</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Team Section -->
    <section class="team-section">
        <div class="container">
            <h2 class="section-title">Meet Our Team</h2>
            <p class="section-subtitle">Passionate professionals dedicated to your vision</p>
            <div class="row">
                <div class="col-md-4">
                    <div class="team-card">
                        <div class="team-image">
                            <img src="{{ asset('storage/member/member.jpg') }}" alt="Team Member" class="img-fluid">
                        </div>
                        <h4>Sarah Johnson</h4>
                        <p class="role">Founder & CEO</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="team-card">
                        <div class="team-image">
                            <img src="{{ asset('storage/member/member.jpg') }}" alt="Team Member" class="img-fluid">
                        </div>
                        <h4>Michael Chen</h4>
                        <p class="role">Chief Designer</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="team-card">
                        <div class="team-image">
                            <img src="{{ asset('storage/member/member.jpg') }}" alt="Team Member" class="img-fluid">
                        </div>
                        <h4>Emily Rodriguez</h4>
                        <p class="role">Customer Experience Lead</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <div class="cta-content">
                <h2>Ready to Find Your Perfect Frames?</h2>
                <p>Explore our collection and discover eyewear that matches your unique style</p>
                <a href="{{ route('frontend.shop') }}" class="btn btn-primary btn-lg">Shop Now</a>
            </div>
        </div>
    </section>
</div>
</main>
@endsection