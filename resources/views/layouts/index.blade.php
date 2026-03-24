@extends('layouts.home')

@section('title', 'Eyewear')
@section('content')

<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600&family=Playfair+Display:wght@400;600;700&display=swap" rel="stylesheet">

<style>
    :root {
        --purple-50:  #f5f3ff;
        --purple-100: #ede9fe;
        --purple-200: #ddd6fe;
        --purple-500: #8b5cf6;
        --purple-600: #7c3aed;
        --purple-700: #6d28d9;
        --purple-900: #2e1065;
        --gray-50:  #f9fafb;
        --gray-100: #f3f4f6;
        --gray-200: #e5e7eb;
        --gray-400: #9ca3af;
        --gray-600: #4b5563;
        --gray-800: #1f2937;
        --gray-900: #111827;
    }

    * { box-sizing: border-box; }

    body {
        font-family: 'DM Sans', sans-serif;
        color: var(--gray-800);
        background: #fff;
        margin: 0;
    }

    /* ─── SLIDER ─────────────────────────────────────────── */
    .banner-area-two {
        margin: 0 !important;
        padding: 0 !important;
        position: relative;
    }

    .banner-slider { position: relative; }

    .banner-item {
        position: relative;
        height: 580px;
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        display: flex;
        align-items: center;
        overflow: hidden;
    }

    /* soft purple gradient overlay */
    /* .banner-item::before {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(
            100deg,
            rgba(109, 40, 217, 0.72) 0%,
            rgba(139, 92, 246, 0.45) 45%,
            rgba(0,0,0,0.05) 100%
        );
        z-index: 1;
    } */

   .banner-content-overlay {
    position: absolute;
    right: 80px;          /* right side এ position */
    left: auto;           /* left override করতে */
    top: 50%;
    transform: translateY(-50%);
    text-align: right;    /* text right align */
    align-items: flex-end; /* যদি flexbox থাকে */
}

    .banner-eyebrow {
        display: inline-block;
        background: rgba(255,255,255,0.18);
        border: 1px solid rgba(255,255,255,0.35);
        color: #fff;
        font-size: 11px;
        font-weight: 600;
        letter-spacing: 2.5px;
        text-transform: uppercase;
        padding: 6px 16px;
        border-radius: 100px;
        margin-bottom: 20px;
        backdrop-filter: blur(6px);
    }

    .banner-headline {
        font-family: 'Playfair Display', serif;
        font-size: clamp(36px, 5vw, 60px);
        font-weight: 700;
        color: #fff;
        line-height: 1.12;
        margin: 0 0 16px;
        letter-spacing: -0.5px;
    }

    .banner-sub {
        font-size: 16px;
        color: rgba(255,255,255,0.85);
        margin: 0 0 36px;
        line-height: 1.6;
        font-weight: 300;
    }

    .banner-cta {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        background: #fff;
        color: var(--purple-700);
        font-weight: 600;
        font-size: 14px;
        padding: 14px 30px;
        border-radius: 100px;
        text-decoration: none;
        transition: all 0.25s ease;
        box-shadow: 0 4px 20px rgba(0,0,0,0.15);
    }

    .banner-cta:hover {
        background: var(--purple-600);
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 8px 28px rgba(109,40,217,0.45);
    }

    .banner-cta svg { width: 16px; height: 16px; flex-shrink: 0; }

    /* Owl nav dots override */
    .owl-dots {
        position: absolute;
        bottom: 28px;
        left: 7%;
        z-index: 10;
        display: flex;
        gap: 8px;
    }

    .owl-dot span {
        width: 8px !important;
        height: 8px !important;
        background: rgba(255,255,255,0.45) !important;
        border-radius: 100px !important;
        transition: all 0.3s !important;
        margin: 0 !important;
    }

    .owl-dot.active span {
        width: 24px !important;
        background: #fff !important;
    }

    .owl-nav button {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background: rgba(255,255,255,0.15) !important;
        border: 1px solid rgba(255,255,255,0.3) !important;
        backdrop-filter: blur(8px);
        width: 48px;
        height: 48px;
        border-radius: 50% !important;
        color: #fff !important;
        font-size: 20px !important;
        transition: all 0.2s;
        z-index: 10;
    }

    .owl-nav button:hover {
        background: rgba(255,255,255,0.3) !important;
    }

    .owl-nav .owl-prev { left: 24px; }
    .owl-nav .owl-next { right: 24px; }

    /* ─── TRUST BAR ───────────────────────────────────────── */
    .trust-bar {
        background: var(--gray-900);
        padding: 14px 0;
        overflow: hidden;
    }

    .trust-bar-inner {
        display: flex;
        justify-content: center;
        gap: 48px;
        flex-wrap: wrap;
        padding: 0 24px;
    }

    .trust-item {
        display: flex;
        align-items: center;
        gap: 10px;
        color: rgba(255,255,255,0.75);
        font-size: 13px;
        font-weight: 500;
        letter-spacing: 0.3px;
    }

    .trust-item svg {
        color: var(--purple-400, #a78bfa);
        width: 18px;
        height: 18px;
        flex-shrink: 0;
    }

    /* ─── SECTION LABEL ──────────────────────────────────── */
    .section-eyebrow {
        display: inline-block;
        font-size: 11px;
        font-weight: 600;
        letter-spacing: 2.5px;
        text-transform: uppercase;
        color: var(--purple-600);
        margin-bottom: 10px;
    }

    .section-title {
        font-family: 'Playfair Display', serif;
        font-size: clamp(26px, 3.5vw, 38px);
        font-weight: 700;
        color: var(--gray-900);
        margin: 0 0 4px;
        letter-spacing: -0.3px;
    }

    .section-divider {
        width: 40px;
        height: 3px;
        background: linear-gradient(90deg, var(--purple-600), var(--purple-400, #a78bfa));
        border-radius: 2px;
        margin: 14px auto 0;
    }

    /* ─── CATEGORIES ─────────────────────────────────────── */
    .categories-section {
        padding: 80px 0;
        background: #fff;
    }

    .categories-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        margin-top: 48px;
    }

    @media (max-width: 900px) { .categories-grid { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 500px) { .categories-grid { grid-template-columns: 1fr; } }

    .cat-card {
        border: 1.5px solid var(--gray-100);
        border-radius: 20px;
        padding: 36px 24px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.22, 1, 0.36, 1);
        position: relative;
        overflow: hidden;
        background: #fff;
    }

    .cat-card::before {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, var(--purple-50), var(--purple-100));
        opacity: 0;
        transition: opacity 0.3s;
    }

    .cat-card:hover {
        border-color: var(--purple-200);
        transform: translateY(-6px);
        box-shadow: 0 20px 40px rgba(124, 58, 237, 0.12);
    }

    .cat-card:hover::before { opacity: 1; }

    .cat-icon {
        position: relative;
        z-index: 1;
        font-size: 44px;
        line-height: 1;
        margin-bottom: 16px;
        display: block;
        transition: transform 0.3s;
    }

    .cat-card:hover .cat-icon { transform: scale(1.12); }

    .cat-card h3 {
        position: relative;
        z-index: 1;
        font-size: 16px;
        font-weight: 600;
        color: var(--gray-900);
        margin: 0 0 6px;
    }

    .cat-card p {
        position: relative;
        z-index: 1;
        font-size: 13px;
        color: var(--gray-400);
        margin: 0;
        line-height: 1.5;
    }

    /* ─── FEATURED PRODUCTS ──────────────────────────────── */
    .products-section {
        padding: 80px 0;
        background: var(--gray-50);
    }

    .products-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        margin-bottom: 48px;
    }

    .view-all-link {
        font-size: 13px;
        font-weight: 600;
        color: var(--purple-600);
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 6px;
        letter-spacing: 0.3px;
        transition: gap 0.2s;
    }

    .view-all-link:hover { gap: 10px; color: var(--purple-700); }

    .products-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 24px;
    }

    @media (max-width: 1024px) { .products-grid { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 520px)  { .products-grid { grid-template-columns: 1fr; } }

    .product-card {
        background: #fff;
        border-radius: 20px;
        overflow: hidden;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.22, 1, 0.36, 1);
        border: 1.5px solid var(--gray-100);
        position: relative;
    }

    .product-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 24px 48px rgba(0,0,0,0.09);
        border-color: var(--purple-200);
    }

    .product-badge {
        position: absolute;
        top: 14px;
        left: 14px;
        background: var(--purple-600);
        color: #fff;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 1px;
        text-transform: uppercase;
        padding: 4px 10px;
        border-radius: 100px;
        z-index: 2;
    }

    .product-img-wrap {
        background: var(--gray-100);
        height: 230px;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        position: relative;
    }

    .product-img-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.4s ease;
    }

    .product-card:hover .product-img-wrap img { transform: scale(1.06); }

    .product-no-img {
        color: var(--gray-400);
        font-size: 13px;
    }

    .product-body {
        padding: 18px 20px 20px;
    }

    .product-body h3 {
        font-size: 15px;
        font-weight: 600;
        color: var(--gray-900);
        margin: 0 0 6px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .product-body p {
        font-size: 12.5px;
        color: var(--gray-400);
        margin: 0 0 16px;
        line-height: 1.5;
    }

    .product-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 8px;
    }

    .product-price {
        font-family: 'Playfair Display', serif;
        font-size: 22px;
        font-weight: 700;
        color: var(--purple-600);
    }

    .add-cart-btn {
        background: var(--purple-600);
        color: #fff;
        border: none;
        padding: 9px 18px;
        border-radius: 100px;
        font-size: 12.5px;
        font-weight: 600;
        font-family: 'DM Sans', sans-serif;
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        gap: 6px;
        white-space: nowrap;
    }

    .add-cart-btn:hover {
        background: var(--purple-700);
        transform: scale(1.04);
    }

    /* ─── EMPTY STATE ────────────────────────────────────── */
    .empty-products {
        grid-column: 1 / -1;
        text-align: center;
        padding: 64px 0;
    }

    .empty-products svg { color: var(--gray-200); width: 80px; height: 80px; margin-bottom: 16px; }
    .empty-products p:first-of-type { font-size: 17px; color: var(--gray-600); margin: 0 0 6px; font-weight: 500; }
    .empty-products p:last-of-type  { font-size: 14px; color: var(--gray-400); margin: 0; }

    /* ─── NEWSLETTER ─────────────────────────────────────── */
    .newsletter-section {
        padding: 90px 0;
        background: linear-gradient(135deg, #5b21b6 0%, #7c3aed 50%, #8b5cf6 100%);
        position: relative;
        overflow: hidden;
    }

    /* decorative circles */
    .newsletter-section::before,
    .newsletter-section::after {
        content: '';
        position: absolute;
        border-radius: 50%;
        background: rgba(255,255,255,0.05);
    }

    .newsletter-section::before {
        width: 400px; height: 400px;
        top: -150px; right: -80px;
    }

    .newsletter-section::after {
        width: 260px; height: 260px;
        bottom: -100px; left: -60px;
    }

    .newsletter-inner {
        position: relative;
        z-index: 1;
        text-align: center;
        max-width: 560px;
        margin: 0 auto;
        padding: 0 24px;
    }

    .newsletter-tag {
        display: inline-block;
        background: rgba(255,255,255,0.15);
        border: 1px solid rgba(255,255,255,0.25);
        color: rgba(255,255,255,0.9);
        font-size: 10.5px;
        font-weight: 700;
        letter-spacing: 2px;
        text-transform: uppercase;
        padding: 5px 14px;
        border-radius: 100px;
        margin-bottom: 18px;
        backdrop-filter: blur(6px);
    }

    .newsletter-inner h2 {
        font-family: 'Playfair Display', serif;
        font-size: clamp(28px, 4vw, 42px);
        font-weight: 700;
        color: #fff;
        margin: 0 0 10px;
        line-height: 1.15;
    }

    .newsletter-inner p {
        font-size: 15px;
        color: rgba(255,255,255,0.75);
        margin: 0 0 36px;
        line-height: 1.6;
    }

    .newsletter-form {
        display: flex;
        background: rgba(255,255,255,0.12);
        border: 1.5px solid rgba(255,255,255,0.25);
        border-radius: 100px;
        overflow: hidden;
        backdrop-filter: blur(10px);
        transition: border-color 0.2s;
    }

    .newsletter-form:focus-within {
        border-color: rgba(255,255,255,0.6);
    }

    .newsletter-form input {
        flex: 1;
        background: transparent;
        border: none;
        outline: none;
        padding: 14px 22px;
        color: #fff;
        font-family: 'DM Sans', sans-serif;
        font-size: 14px;
    }

    .newsletter-form input::placeholder { color: rgba(255,255,255,0.55); }

    .newsletter-form button {
        background: #fff;
        color: var(--purple-700);
        border: none;
        padding: 12px 28px;
        font-family: 'DM Sans', sans-serif;
        font-size: 13.5px;
        font-weight: 700;
        border-radius: 100px;
        margin: 5px;
        cursor: pointer;
        transition: all 0.2s;
        white-space: nowrap;
    }

    .newsletter-form button:hover {
        background: var(--purple-100);
        transform: scale(1.03);
    }

    /* ─── CONTAINER ──────────────────────────────────────── */
    .container-main {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 24px;
    }

    /* ─── ANIMATIONS ─────────────────────────────────────── */
    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(24px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    .banner-content-overlay > * {
        animation: fadeUp 0.65s cubic-bezier(0.22, 1, 0.36, 1) both;
    }

    .banner-content-overlay .banner-eyebrow  { animation-delay: 0.1s; }
    .banner-content-overlay .banner-headline  { animation-delay: 0.22s; }
    .banner-content-overlay .banner-sub       { animation-delay: 0.34s; }
    .banner-content-overlay .banner-cta       { animation-delay: 0.46s; }
    .categories-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
    margin-top: 40px;
}

.cat-card {
    position: relative;
    border-radius: 10px;
    overflow: hidden;
    cursor: pointer;
    aspect-ratio: 3 / 4;
}

.cat-card img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
    transition: transform 0.4s ease;
}

.cat-card:hover img {
    transform: scale(1.05);
}

/* Dark gradient overlay at bottom */
.cat-card::after {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(
        to top,
        rgba(0, 0, 0, 0.65) 0%,
        rgba(0, 0, 0, 0.2) 50%,
        rgba(0, 0, 0, 0) 100%
    );
}

.cat-overlay {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    padding: 24px 20px;
    z-index: 2;
}

.cat-overlay h3 {
    color: #ffffff;
    font-size: 1.6rem;
    font-weight: 700;
    margin: 0 0 8px 0;
    line-height: 1.2;
}

.cat-shop-link {
    color: #f0b800; /* golden yellow like in the image */
    font-weight: 600;
    font-size: 0.95rem;
    text-decoration: none;
    letter-spacing: 0.3px;
    transition: color 0.2s ease;
}

.cat-shop-link:hover {
    color: #ffcc00;
}

/* Responsive */
@media (max-width: 768px) {
    .categories-grid {
        grid-template-columns: 1fr;
        gap: 16px;
    }

    .cat-card {
        aspect-ratio: 4 / 3;
    }
}
</style>

<!-- ═══════════════════════════════════════════════
     HERO / SLIDER
════════════════════════════════════════════════ -->
<div class="banner-area-two">
    <div class="banner-slider owl-carousel owl-theme">

        <div class="banner-item"
             style="background-image: url('{{ asset('storage/slider/eye.webp') }}');">
            <div class="banner-content-overlay">
                <span class="banner-eyebrow">New Collection 2025</span>
                <h1 class="banner-headline">See the World<br>in Style</h1>
                <p class="banner-sub">Handcrafted frames designed for comfort,<br>durability, and effortless elegance.</p>
                <a href="{{ route('frontend.shop') }}" class="banner-cta">
                    Shop Now
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M5 12h14M12 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
        </div>

        <!-- Duplicate / add more slides here -->

    </div>
</div>

<!-- ═══════════════════════════════════════════════
     TRUST BAR
════════════════════════════════════════════════ -->
<!-- <div class="trust-bar">
    <div class="trust-bar-inner">
        <div class="trust-item">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M5 12l5 5L20 7"/>
            </svg>
            Free Shipping Over $50
        </div>
        <div class="trust-item">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/>
            </svg>
            30-Day Easy Returns
        </div>
        <div class="trust-item">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
            </svg>
            UV400 Protection
        </div>
        <div class="trust-item">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M22 16.92v3a2 2 0 01-2.18 2 19.8 19.8 0 01-8.63-3.07A19.5 19.5 0 013.07 9.81 19.8 19.8 0 01.04 1.18 2 2 0 012 .02h3a2 2 0 012 1.72 12.84 12.84 0 00.7 2.81 2 2 0 01-.45 2.11L6.09 7.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45 12.84 12.84 0 002.81.7A2 2 0 0122 14.92z"/>
            </svg>
            Expert Support
        </div>
    </div>
</div> -->

<!-- ═══════════════════════════════════════════════
     CATEGORIES
════════════════════════════════════════════════ -->
<section class="categories-section">
    <div class="container-main">
        <div style="text-align:center;">
            <span class="section-eyebrow">Browse</span>
            <h2 class="section-title">Shop by Category</h2>
            <div class="section-divider" style="margin:14px auto 0;"></div>
        </div>

        <div class="categories-grid">
            <div class="cat-card">
                 <img src="{{ asset('storage/images/women.webp') }}" alt="Women's Eyewear">
                <div class="cat-overlay">
                    <h3>Women's Eyewear</h3>
                    <a href="#" class="cat-shop-link">Shop Now &rsaquo;</a>
                </div>
            </div>
            <div class="cat-card">
                <img src="{{ asset('storage/images/men-eyeglass.webp') }}" alt="Men's Eyewear">
                <div class="cat-overlay">
                    <h3>Men's Eyewear</h3>
                    <a href="#" class="cat-shop-link">Shop Now &rsaquo;</a>
                </div>
            </div>
            <div class="cat-card">
                 <img src="{{ asset('storage/images/kids.jpg') }}"" alt="kids Glasses">
                <div class="cat-overlay">
                    <h3>Kids Glasses</h3>
                    <a href="#" class="cat-shop-link">Shop Now &rsaquo;</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════
     FEATURED PRODUCTS
════════════════════════════════════════════════ -->
<section class="products-section">
    <div class="container-main">
        <div class="products-header">
            <div>
                <span class="section-eyebrow">Handpicked</span>
                <h2 class="section-title" style="margin:0;">Featured Products</h2>
            </div>
            <a href="{{ route('frontend.shop') }}" class="view-all-link">
                View All
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M5 12h14M12 5l7 7-7 7"/>
                </svg>
            </a>
        </div>

        <div class="products-grid">
            @forelse($products as $product)
            <div class="product-card"
                 onclick="window.location='{{ route('shop.show', $product->slug) }}'">

                <span class="product-badge">New</span>

                <div class="product-img-wrap">
                    @if($product->images && $product->images->isNotEmpty())
                        <img src="{{ asset('storage/' . $product->images->first()->image_path) }}"
                             alt="{{ $product->name }}">
                    @elseif($product->images)
                        <img src="{{ asset('storage/' . $product->images) }}"
                             alt="{{ $product->name }}">
                    @else
                        <div class="product-no-img">No Image</div>
                    @endif
                </div>

                <!-- <div class="product-body">
                    <h3>{{ $product->name }}</h3>
                    <p>{{ Str::limit($product->short_description, 55) }}</p>
                    <div class="product-footer">
                        <span class="product-price">৳{{ number_format($product->price, 0) }}</span>
                        <button class="add-cart-btn" onclick="event.stopPropagation()">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/>
                                <path d="M1 1h4l2.68 13.39a2 2 0 002 1.61h9.72a2 2 0 002-1.61L23 6H6"/>
                            </svg>
                            Add to Cart
                        </button>
                    </div>
                </div> -->
                <!-- <form action="{{ route('cart.store') }}" method="POST" onclick="event.stopPropagation()">
    @csrf
    <input type="hidden" name="product_id" value="{{ $product->id }}">
    <input type="hidden" name="quantity" value="1">
    <button type="submit" class="add-cart-btn">
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/>
            <path d="M1 1h4l2.68 13.39a2 2 0 002 1.61h9.72a2 2 0 002-1.61L23 6H6"/>
        </svg>
        Add to Cart
    </button>
</form> -->
<div class="product-card"
     onclick="window.location='{{ route('shop.show', $product->slug) }}'">

    <span class="product-badge">New</span>

    <!-- <div class="product-img-wrap">
        @if($product->images && $product->images->isNotEmpty())
            <img src="{{ asset('storage/' . $product->images->first()->image_path) }}"
                 alt="{{ $product->name }}">
        @elseif($product->images)
            <img src="{{ asset('storage/' . $product->images) }}"
                 alt="{{ $product->name }}">
        @else
            <div class="product-no-img">No Image</div>
        @endif
    </div> -->

    <div class="product-body">
        <h3>{{ $product->name }}</h3>
        <p>{{ Str::limit($product->short_description, 55) }}</p>
        <div class="product-footer">
            <span class="product-price">৳{{ number_format($product->price, 0) }}</span>
            <form action="{{ route('cart.store') }}" method="POST" onclick="event.stopPropagation()">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input type="hidden" name="quantity" value="1">
                <button type="submit" class="add-cart-btn">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/>
                        <path d="M1 1h4l2.68 13.39a2 2 0 002 1.61h9.72a2 2 0 002-1.61L23 6H6"/>
                    </svg>
                    Add to Cart
                </button>
            </form>
        </div>
    </div>

</div>
            </div>

            @empty
            <div class="empty-products">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                </svg>
                <p>No products available at the moment</p>
                <p>Check back soon for new arrivals!</p>
            </div>
            @endforelse
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════
     NEWSLETTER
════════════════════════════════════════════════ -->
<section class="newsletter-section">
    <div class="newsletter-inner">
        <span class="newsletter-tag">Exclusive Offer</span>
        <h2>Get 20% Off Your First Order</h2>
        <p>Join our community and be the first to hear about new arrivals, limited drops, and member-only deals.</p>
        <div class="newsletter-form">
            <input type="email" placeholder="Enter your email address">
            <button type="button">Subscribe</button>
        </div>
    </div>
</section>

@endsection