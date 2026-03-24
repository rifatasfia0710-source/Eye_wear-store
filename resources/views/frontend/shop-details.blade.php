@extends('layouts.home')

@section('title', $product->name . ' – Premium Eyewear')

@section('content')

<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;1,400&family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>
  :root {
    --ink:     #1a1814;
    --bg:      #f9f7f4;
    --white:   #ffffff;
    --gold:    #c9973f;
    --gold2:   #e8c070;
    --muted:   #8a847c;
    --border:  #e8e3db;
    --red:     #d94f4f;
    --green:   #3a7d5c;
    --accent:  #2b2926;
    --purple:  #923bb5;
  }

  * { box-sizing: border-box; margin: 0; padding: 0; }
  body { background: var(--bg); font-family: 'Outfit', sans-serif; color: var(--ink); }

  @keyframes fadeUp {
    from { opacity: 0; transform: translateY(16px); }
    to   { opacity: 1; transform: none; }
  }

  /* ── Breadcrumb ── */
  .pd-breadcrumb {
    padding: 12px 40px;
    font-size: 11.5px;
    letter-spacing: .07em;
    text-transform: uppercase;
    color: var(--muted);
    background: var(--white);
    border-bottom: 1px solid var(--border);
    display: flex;
    align-items: center;
    gap: 6px;
  }
  .pd-breadcrumb a { color: var(--muted); text-decoration: none; transition: color .2s; }
  .pd-breadcrumb a:hover { color: var(--gold); }
  .pd-breadcrumb .sep { opacity: .4; }
  .pd-breadcrumb .current { color: var(--ink); font-weight: 500; }

  /* ── Page wrapper ── */
  .pd-wrap {
    max-width: 2200px;
    margin: 0 auto;
    padding: 40px 40px 80px;
    animation: fadeUp .5s ease both;
  }

  /* ── TOP SECTION: 2-col grid ── */
  .pd-top {
    display: grid;
    grid-template-columns: 55% 1fr;
    gap: 56px;
    background: var(--white);
    border-radius: 24px;
    padding: 48px 52px;
    box-shadow: 0 4px 32px rgba(0,0,0,.06);
    margin-bottom: 36px;
    align-items: start;
  }

  /* ── LEFT: Image panel ── */
  .pd-img-panel { display: flex; flex-direction: column; gap: 24px; }

  .pd-main-img-wrap {
    position: relative;
    background: var(--bg);
    border-radius: 20px;
    overflow: hidden;
    aspect-ratio: 4 / 3;
    display: flex; align-items: center; justify-content: center;
    min-height: 420px;
  }
  .pd-main-img-wrap img {
    max-width: 85%; max-height: 85%;
    object-fit: contain;
    transition: transform .6s cubic-bezier(.25,.46,.45,.94);
  }
  .pd-main-img-wrap:hover img { transform: scale(1.06); }

  .pd-badge-strip {
    position: absolute; top: 16px; left: 16px;
    display: flex; flex-direction: column; gap: 6px;
  }
  .pd-badge {
    padding: 4px 12px; font-size: 10px; font-weight: 700;
    letter-spacing: .1em; text-transform: uppercase;
    border-radius: 20px; display: inline-block;
  }
  .pd-badge-new        { background: var(--ink); color: var(--white); }
  .pd-badge-sale       { background: var(--gold); color: var(--white); }
  .pd-badge-bestseller { background: #1a1a2e; color: #e8c97e; }

  /* Discount circle badge like reference image */
  .pd-discount-circle {
    position: absolute; top: 16px; right: 16px;
    width: 60px; height: 60px;
    background: var(--red);
    border-radius: 50%;
    display: flex; flex-direction: column;
    align-items: center; justify-content: center;
    color: #fff;
    font-weight: 700;
    box-shadow: 0 4px 12px rgba(217,79,79,.4);
    z-index: 2;
  }
  .pd-discount-circle .disc-pct  { font-size: 18px; line-height: 1; }
  .pd-discount-circle .disc-label{ font-size: 9px; letter-spacing: .05em; opacity: .9; }

  /* Thumbnails row */
  .pd-thumbs-row {
    display: flex; gap: 10px; flex-wrap: wrap;
  }
  .pd-thumb {
    width: 96px; height: 96px;
    border: 2px solid var(--border);
    border-radius: 12px;
    cursor: pointer;
    overflow: hidden;
    background: var(--bg);
    transition: border-color .2s, transform .2s, box-shadow .2s;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
  }
  .pd-thumb img { width: 100%; height: 100%; object-fit: contain; padding: 10px; }
  .pd-thumb:hover, .pd-thumb.active {
    border-color: var(--gold);
    box-shadow: 0 2px 10px rgba(201,151,63,.25);
    transform: scale(1.04);
  }

  /* Dot indicators (like reference) */
  .pd-img-dots {
    display: flex; gap: 6px; justify-content: center; margin-top: -8px;
  }
  .pd-img-dot {
    width: 8px; height: 8px; border-radius: 50%;
    background: var(--border); cursor: pointer; transition: background .2s;
  }
  .pd-img-dot.active { background: var(--gold); }

  /* ── RIGHT: Info panel ── */
  .pd-info-panel { display: flex; flex-direction: column; gap: 0; }

  .pd-sku-line {
    font-size: 11px; color: var(--muted);
    letter-spacing: .1em; text-transform: uppercase;
    margin-bottom: 8px;
    display: flex; gap: 16px;
  }
  .pd-sku-line span { display: flex; align-items: center; gap: 4px; }

  .pd-name {
    font-family: 'Playfair Display', serif;
    font-size: 42px; font-weight: 600;
    line-height: 1.15; color: var(--ink);
    margin-bottom: 20px;
    text-transform: uppercase;
    letter-spacing: .02em;
  }

  /* Price row */
  .pd-price-row {
    display: flex; align-items: baseline; gap: 14px;
    flex-wrap: wrap; margin-bottom: 12px;
  }
  .pd-price-current {
    font-family: 'Playfair Display', serif;
    font-size: 40px; font-weight: 600;
    color: var(--gold);
  }
  .pd-price-old {
    font-size: 24px; color: var(--muted);
    text-decoration: line-through; font-weight: 400;
  }

  /* Star rating */
  .pd-rating-row {
    display: flex; align-items: center; gap: 10px;
    margin-bottom: 22px;
  }
  .pd-stars { color: var(--gold); font-size: 18px; letter-spacing: 2px; }
  .pd-rating-text { font-size: 14px; color: var(--muted); }
  .pd-rating-text strong { color: var(--ink); }

  .pd-divider { height: 1px; background: var(--border); margin: 22px 0; }

  .pd-short-desc {
    font-size: 15px; color: var(--muted);
    line-height: 1.85; margin-bottom: 24px;
  }

  /* Stock */
  .pd-stock {
    display: inline-flex; align-items: center; gap: 8px;
    font-size: 14px; font-weight: 500; margin-bottom: 24px;
    padding: 8px 18px; border-radius: 20px;
  }
  .pd-stock-dot { width: 7px; height: 7px; border-radius: 50%; }
  .pd-stock.instock  { color: var(--green); background: #eef7f2; }
  .pd-stock.instock  .pd-stock-dot { background: var(--green); }
  .pd-stock.outstock { color: var(--red); background: #fdf2f2; }
  .pd-stock.outstock .pd-stock-dot { background: var(--red); }

  /* Colors */
  .pd-section-label {
    font-size: 11px; font-weight: 700;
    letter-spacing: .14em; text-transform: uppercase;
    color: var(--muted); margin-bottom: 10px;
  }
  .pd-color-tags { display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 22px; }
  .pd-color-tag {
    padding: 6px 16px; border: 1.5px solid var(--border);
    border-radius: 20px; font-size: 13px; cursor: pointer;
    transition: all .2s; background: var(--white);
    color: var(--ink); font-weight: 500;
  }
  .pd-color-tag:hover, .pd-color-tag.active {
    border-color: var(--gold); color: var(--gold); background: #fdf8f0;
  }

  /* Size selector like reference image */
  .pd-size-row {
    display: flex; align-items: center; gap: 12px; margin-bottom: 22px;
  }
  .pd-size-select {
    padding: 9px 14px; border: 1.5px solid var(--border);
    border-radius: 8px; font-family: 'Outfit', sans-serif;
    font-size: 13px; color: var(--ink); background: var(--white);
    cursor: pointer; outline: none; transition: border-color .2s;
  }
  .pd-size-select:focus { border-color: var(--gold); }
  .pd-size-guide-link {
    font-size: 12px; color: var(--gold); text-decoration: underline;
    cursor: pointer; letter-spacing: .03em;
  }

  /* Cart block */
  .pd-cart-row {
    display: flex; gap: 10px; align-items: center; margin-bottom: 14px;
  }
  .pd-qty {
    display: flex; align-items: center;
    border: 1.5px solid var(--border); border-radius: 10px;
    overflow: hidden; background: var(--white);
  }
  .pd-qty button {
    width: 46px; height: 54px; border: none;
    background: none; font-size: 22px; cursor: pointer;
    color: var(--ink); transition: background .2s; font-weight: 300;
  }
  .pd-qty button:hover { background: #f0ece5; }
  .pd-qty input {
    width: 54px; height: 54px; border: none;
    border-left: 1.5px solid var(--border);
    border-right: 1.5px solid var(--border);
    text-align: center; font-family: 'Outfit', sans-serif;
    font-size: 17px; font-weight: 600;
    background: var(--white); color: var(--ink); outline: none;
  }
  .pd-btn-cart {
    flex: 1; height: 54px;
    background: var(--purple); color: var(--white);
    border: none; border-radius: 12px;
    font-family: 'Outfit', sans-serif;
    font-size: 14px; font-weight: 700;
    letter-spacing: .12em; text-transform: uppercase;
    cursor: pointer; transition: all .25s;
    display: flex; align-items: center; justify-content: center; gap: 10px;
  }
  .pd-btn-cart:hover:not(:disabled) {
    background: var(--gold); transform: translateY(-1px);
    box-shadow: 0 6px 20px rgba(201,151,63,.35);
  }
  .pd-btn-cart:disabled { opacity: .4; cursor: not-allowed; }
  .pd-btn-wishlist {
    width: 54px; height: 54px;
    border: 1.5px solid var(--border); background: var(--white);
    border-radius: 12px; cursor: pointer; font-size: 22px;
    display: flex; align-items: center; justify-content: center;
    transition: all .2s; color: var(--muted);
  }
  .pd-btn-wishlist:hover { border-color: var(--red); color: var(--red); background: #fdf4f4; }

  /* Delivery estimate like reference */
  .pd-delivery-estimate {
    background: var(--bg); border-radius: 10px;
    padding: 12px 16px; margin-top: 4px;
    font-size: 12.5px; color: var(--muted);
    display: flex; align-items: center; gap: 8px;
  }
  .pd-delivery-estimate strong { color: var(--ink); }
  .pd-terms-link { font-size: 11px; color: var(--gold); text-decoration: underline; margin-top: 6px; display: inline-block; }

  /* ── BOTTOM TABS ── */
  .pd-tabs-section {
    background: var(--white);
    border-radius: 20px;
    box-shadow: 0 2px 20px rgba(0,0,0,.05);
    overflow: hidden;
    margin-bottom: 32px;
  }

  .pd-tab-nav {
    display: flex; border-bottom: 1px solid var(--border);
    background: var(--bg);
  }
  .pd-tab-btn {
    padding: 16px 28px;
    font-size: 19px; font-weight: 700;
    letter-spacing: .1em; text-transform: uppercase;
    color: var(--muted); border: none; background: none;
    cursor: pointer; position: relative;
    transition: color .2s; font-family: 'Outfit', sans-serif;
    border-bottom: 3px solid transparent; margin-bottom: -1px;
  }
  .pd-tab-btn:hover { color: var(--ink); }
  .pd-tab-btn.active { color: var(--gold); border-bottom-color: var(--gold); background: var(--white); }

  .pd-tab-content { display: none; padding: 32px 36px; }
  .pd-tab-content.active { display: block; }

  /* Specs grid like reference */
  .pd-specs-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 0;
  }
  .pd-spec-item {
    display: flex; padding: 12px 16px;
    border-bottom: 1px solid var(--border);
    gap: 16px;
  }
  .pd-spec-item:nth-child(odd) { border-right: 1px solid var(--border); }
  .pd-spec-label {
    font-size: 20px; color: var(--muted);
    text-transform: uppercase; letter-spacing: .08em;
    min-width: 110px; font-weight: 600;
  }
  .pd-spec-val { font-size: 21px; color: var(--ink); font-weight: 500; }

  .pd-desc-text { font-size: 24px; color: var(--muted); line-height: 1.85; }

  /* ── REVIEWS SECTION ── */
  .pd-reviews-section {
    background: var(--white);
    border-radius: 20px;
    padding: 40px 36px;
    box-shadow: 0 2px 20px rgba(0,0,0,.05);
    margin-bottom: 32px;
  }
  .pd-reviews-title {
    font-family: 'Playfair Display', serif;
    font-size: 28px; font-weight: 600;
    color: var(--ink); margin-bottom: 28px;
  }
  .reviews-inner { max-width: 860px; }

  .rating-summary-card {
    display: flex; align-items: center; gap: 32px;
    background: var(--bg); border: 1px solid var(--border);
    border-radius: 16px; padding: 24px 28px; margin-bottom: 28px;
  }
  .rating-big-num {
    font-family: 'Playfair Display', serif;
    font-size: 56px; font-weight: 600;
    color: var(--ink); line-height: 1; min-width: 80px; text-align: center;
  }
  .rating-stars-row { display: flex; gap: 3px; margin: 6px 0; justify-content: center; }
  .rating-total-txt { font-size: 11px; color: var(--muted); text-align: center; }
  .rating-bars { flex: 1; }
  .rating-bar-row { display: flex; align-items: center; gap: 10px; margin-bottom: 7px; }
  .rating-bar-row span { font-size: 12px; color: var(--muted); width: 12px; text-align: right; }
  .rating-bar-track { flex: 1; height: 6px; background: #f0ece5; border-radius: 99px; overflow: hidden; }
  .rating-bar-fill  { height: 100%; background: var(--gold); border-radius: 99px; }
  .rating-bar-count { font-size: 12px; color: var(--muted); width: 24px; }

  .write-review-card {
    background: var(--bg); border: 1px solid var(--border);
    border-radius: 16px; padding: 24px; margin-bottom: 24px;
  }
  .write-review-card h4 {
    font-family: 'Playfair Display', serif;
    font-size: 18px; color: var(--ink); margin-bottom: 18px;
  }
  .star-input { display: flex; flex-direction: row-reverse; justify-content: flex-end; gap: 6px; margin-bottom: 16px; }
  .star-input input { display: none; }
  .star-input label { font-size: 30px; color: #e8e3db; cursor: pointer; transition: color .15s; line-height: 1; }
  .star-input input:checked ~ label,
  .star-input label:hover,
  .star-input label:hover ~ label { color: var(--gold); }

  .review-textarea {
    width: 100%; padding: 12px 14px;
    border: 1.5px solid var(--border); border-radius: 10px;
    font-family: 'Outfit', sans-serif; font-size: 14px;
    color: var(--ink); background: var(--white);
    outline: none; resize: vertical;
    transition: border-color .2s; margin-bottom: 14px;
  }
  .review-textarea:focus { border-color: var(--gold); }
  .review-textarea::placeholder { color: #c4bfb8; }

  .btn-submit-review {
    padding: 11px 24px; background: var(--gold); color: white; border: none;
    border-radius: 10px; font-family: 'Outfit', sans-serif;
    font-size: 12px; font-weight: 700; letter-spacing: .1em;
    text-transform: uppercase; cursor: pointer; transition: all .25s;
    display: inline-flex; align-items: center; gap: 8px;
  }
  .btn-submit-review:hover { background: #b8862e; transform: translateY(-1px); }

  .review-card {
    background: var(--bg); border: 1px solid var(--border);
    border-radius: 12px; padding: 18px 22px; margin-bottom: 12px;
    transition: box-shadow .2s;
  }
  .review-card:hover { box-shadow: 0 4px 20px rgba(0,0,0,.06); }
  .review-card-top { display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px; }
  .reviewer-info   { display: flex; align-items: center; gap: 10px; }
  .reviewer-initial {
    width: 40px; height: 40px; border-radius: 50%;
    background: linear-gradient(135deg, var(--gold), var(--gold2));
    color: white; display: flex; align-items: center; justify-content: center;
    font-weight: 700; font-size: 16px; font-family: 'Playfair Display', serif;
  }
  .reviewer-name { font-size: 13px; font-weight: 600; color: var(--ink); }
  .reviewer-date { font-size: 11px; color: var(--muted); margin-top: 2px; }
  .review-card-stars i { font-size: 12px; }
  .review-card-text { font-size: 13px; color: var(--muted); line-height: 1.75; }

  .btn-delete-review {
    margin-top: 10px; padding: 4px 12px; background: none;
    border: 1px solid var(--border); border-radius: 6px;
    font-size: 12px; color: var(--muted); cursor: pointer;
    transition: all .2s; display: inline-flex; align-items: center; gap: 5px;
    font-family: 'Outfit', sans-serif;
  }
  .btn-delete-review:hover { border-color: var(--red); color: var(--red); }

  .login-to-review {
    background: var(--bg); border: 1px solid var(--border);
    border-radius: 16px; padding: 24px; margin-bottom: 24px; text-align: center;
  }
  .login-to-review p { font-size: 14px; color: var(--muted); }
  .login-to-review a { color: var(--gold); font-weight: 600; text-decoration: none; }

  .review-alert-success {
    background: #eef7f2; border: 1px solid #6ee7b7;
    border-left: 4px solid #10b981; border-radius: 8px;
    padding: 10px 14px; color: #065f46; font-size: 13px;
    margin-bottom: 14px; display: flex; align-items: center; gap: 8px;
  }
  .reviews-empty { text-align: center; padding: 36px 20px; color: var(--muted); }

  /* ── Related Products ── */
  .pd-related {
    background: var(--white); border-radius: 20px;
    padding: 40px 36px; box-shadow: 0 2px 20px rgba(0,0,0,.05);
  }
  .pd-related-header { display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 28px; }
  .pd-related-title { font-family: 'Playfair Display', serif; font-size: 28px; font-weight: 600; color: var(--ink); }
  .pd-related-link { font-size: 12px; letter-spacing: .08em; text-transform: uppercase; color: var(--gold); text-decoration: none; border-bottom: 1px solid var(--gold2); padding-bottom: 2px; }
  .pd-related-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 18px; }
  .pd-rel-card { text-decoration: none; color: inherit; display: block; border-radius: 14px; overflow: hidden; border: 1px solid var(--border); background: var(--white); transition: box-shadow .25s, transform .25s; }
  .pd-rel-card:hover { box-shadow: 0 8px 32px rgba(0,0,0,.1); transform: translateY(-3px); }
  .pd-rel-img { background: var(--bg); aspect-ratio: 1; overflow: hidden; display: flex; align-items: center; justify-content: center; }
  .pd-rel-img img { width: 80%; height: 80%; object-fit: contain; padding: 16px; transition: transform .5s cubic-bezier(.25,.46,.45,.94); }
  .pd-rel-card:hover .pd-rel-img img { transform: scale(1.08); }
  .pd-rel-info  { padding: 14px 16px; }
  .pd-rel-brand { font-size: 10px; font-weight: 700; letter-spacing: .14em; text-transform: uppercase; color: var(--gold); margin-bottom: 4px; }
  .pd-rel-name  { font-family: 'Playfair Display', serif; font-size: 15px; font-weight: 400; color: var(--ink); margin-bottom: 8px; line-height: 1.3; }
  .pd-rel-price { font-size: 14px; font-weight: 700; color: var(--ink); }

  /* ── Responsive ── */
  @media (max-width: 1100px) {
    .pd-top { grid-template-columns: 1fr 1fr; gap: 36px; padding: 36px; }
  }
  @media (max-width: 900px) {
    .pd-top { grid-template-columns: 1fr; gap: 28px; padding: 28px; }
    .pd-related-grid { grid-template-columns: repeat(2, 1fr); }
    .pd-specs-grid { grid-template-columns: 1fr; }
    .pd-spec-item:nth-child(odd) { border-right: none; }
  }
  @media (max-width: 600px) {
    .pd-wrap { padding: 16px 14px 40px; }
    .pd-top  { padding: 20px; }
    .pd-name { font-size: 28px; }
    .pd-price-current { font-size: 28px; }
    .pd-tab-btn { padding: 22px 14px; font-size: 22px; }
    .pd-tab-content { padding: 20px; }
    .pd-related-grid { grid-template-columns: repeat(2, 1fr); gap: 12px; }
    .pd-related, .pd-reviews-section, .pd-tabs-section { border-radius: 14px; }
  }
</style>

{{-- ── Breadcrumb ── --}}
<!-- <nav class="pd-breadcrumb">
  <a href="{{ route('home') }}">Home</a>
  <span class="sep">/</span>
  <a href="{{ route('frontend.shop') }}">Shop</a>
  @if($product->category)
    <span class="sep">/</span>
    <a href="{{ route('frontend.shop', ['categories[]' => $product->category_id]) }}">{{ $product->category->name }}</a>
  @endif
  <span class="sep">/</span>
  <span class="current">{{ $product->name }}</span>
</nav> -->

<div class="pd-wrap">

  {{-- ══════════════════════════════════════
       TOP: Image (left) + Info (right)
  ══════════════════════════════════════ --}}
  <div class="pd-top">

    {{-- LEFT: Image panel --}}
    <div class="pd-img-panel">
      <div class="pd-main-img-wrap">
        <div class="pd-badge-strip">
          @if($product->is_new)
            <span class="pd-badge pd-badge-new">New</span>
          @endif
          @if($product->is_bestseller)
            <span class="pd-badge pd-badge-bestseller">Bestseller</span>
          @endif
        </div>

        {{-- Discount circle badge --}}
        @if($product->sale_price && $product->sale_price < $product->price)
          @php $disc = round((1 - $product->sale_price / $product->price) * 100); @endphp
          <div class="pd-discount-circle">
            <span class="disc-pct">{{ $disc }}%</span>
            <span class="disc-label">OFF</span>
          </div>
        @endif

        <img id="pdMainImg"
             src="{{ asset('storage/' . ($product->images->where('is_primary', true)->first()->image_path ?? $product->images->first()->image_path ?? '')) }}"
             alt="{{ $product->name }}"
             onerror="this.src='https://placehold.co/600x600?text=No+Image'">
      </div>

      {{-- Dot indicators --}}
      @if($product->images && $product->images->count() > 1)
        <div class="pd-img-dots" id="pdDots">
          @foreach($product->images as $img)
            <div class="pd-img-dot {{ $loop->first ? 'active' : '' }}"
                 onclick="switchImgDot(this, '{{ asset('storage/' . $img->image_path) }}', {{ $loop->index }})">
            </div>
          @endforeach
        </div>
      @endif

      {{-- Thumbnails --}}
      @if($product->images && $product->images->count() > 0)
        <div>
          <!-- <p class="pd-section-label" style="margin-bottom:10px;">Other Variations</p> -->
          <!-- <div class="pd-thumbs-row">
            @foreach($product->images as $img)
              <div class="pd-thumb {{ $loop->first ? 'active' : '' }}"
                   onclick="switchImg(this, '{{ asset('storage/' . $img->image_path) }}', {{ $loop->index }})">
                <img src="{{ asset('storage/' . $img->image_path) }}"
                     alt="{{ $product->name }}"
                     onerror="this.src='https://placehold.co/72x72?text=No+Image'">
              </div>
            @endforeach
          </div> -->
        </div>
      @endif
    </div>

    {{-- RIGHT: Info panel --}}
    <div class="pd-info-panel">

      {{-- SKU + Category line --}}
      <div class="pd-sku-line">
        @if($product->category)<span>{{ $product->category->name }}</span>@endif
        @if($product->brand)<span>· {{ $product->brand->name }}</span>@endif
        @if($product->sku)<span>· SKU: {{ $product->sku }}</span>@endif
      </div>

      <h1 class="pd-name">{{ $product->name }}</h1>

      {{-- Price --}}
      <div class="pd-price-row">
        <span class="pd-price-current">
          ৳{{ number_format($product->sale_price ?? $product->price, 0) }}
        </span>
        @if($product->sale_price && $product->sale_price < $product->price)
          <span class="pd-price-old">৳{{ number_format($product->price, 0) }}</span>
        @endif
      </div>

      {{-- Stars --}}
      <div class="pd-rating-row">
        <!-- <span class="pd-stars">
          @for($i = 1; $i <= 5; $i++)
            {{ $i <= round($product->averageRating()) ? '★' : '☆' }}
          @endfor
        </span>
        <span class="pd-rating-text">
          <strong>{{ number_format($product->averageRating(), 1) }}</strong>/5 ·
          {{ $product->reviewCount() }} review{{ $product->reviewCount() != 1 ? 's' : '' }}
        </span> -->
      </div>

      <div class="pd-divider"></div>

      @if($product->short_description)
        <p class="pd-short-desc">{{ $product->short_description }}</p>
      @endif

      {{-- Stock --}}
      @if($product->stock_quantity > 0)
        <div class="pd-stock instock">
          <span class="pd-stock-dot"></span>
          In Stock &nbsp;·&nbsp; {{ $product->stock_quantity }} available
        </div>
      @else
        <div class="pd-stock outstock">
          <span class="pd-stock-dot"></span>
          Out of Stock
        </div>
      @endif

      {{-- Colors --}}
      @if($product->colors && $product->colors->count() > 0)
        <div style="margin-bottom:20px;">
          <p class="pd-section-label">Choose Color</p>
          <div class="pd-color-tags">
            @foreach($product->colors as $color)
              <span class="pd-color-tag {{ $loop->first ? 'active' : '' }}"
                    onclick="selectColor(this)">{{ $color->name }}</span>
            @endforeach
          </div>
        </div>
      @endif

      {{-- Size selector --}}
      @if($product->sizes && $product->sizes->count() > 0)
        <div style="margin-bottom:20px;">
          <p class="pd-section-label">Size</p>
          <div class="pd-size-row">
            <select class="pd-size-select">
              @foreach($product->sizes as $size)
                <option>{{ $size->name }}</option>
              @endforeach
            </select>
            <span class="pd-size-guide-link">Size Guide</span>
          </div>
        </div>
      @endif

      {{-- Cart --}}
      <form action="{{ route('cart.store') }}" method="POST">
        @csrf
        <input type="hidden" name="product_id" value="{{ $product->id }}">
        <div class="pd-cart-row">
          <div class="pd-qty">
            <button type="button" onclick="changeQty(-1)">−</button>
            <input type="number" name="quantity" id="pdQty"
                   value="1" min="1" max="{{ $product->stock_quantity }}">
            <button type="button" onclick="changeQty(1)">+</button>
          </div>
          <button type="submit" class="pd-btn-cart"
                  {{ $product->stock_quantity <= 0 ? 'disabled' : '' }}>
            🛒 Add to Cart
          </button>
          <button type="button" class="pd-btn-wishlist" title="Add to Wishlist">♡</button>
        </div>
      </form>

      {{-- Delivery estimate --}}
      <div class="pd-delivery-estimate">
        📦 <span>Delivered within <strong>2–5 business days</strong></span>
      </div>
      <!-- <a href="#" class="pd-terms-link">Terms &amp; Conditions</a> -->
       <p class="pd-section-label" style="margin-bottom:10px;">Other Variations</p>
<div class="pd-thumbs-row">
            @foreach($product->images as $img)
              <div class="pd-thumb {{ $loop->first ? 'active' : '' }}"
                   onclick="switchImg(this, '{{ asset('storage/' . $img->image_path) }}', {{ $loop->index }})">
                <img src="{{ asset('storage/' . $img->image_path) }}"
                     alt="{{ $product->name }}"
                     onerror="this.src='https://placehold.co/72x72?text=No+Image'">
              </div>
            @endforeach
          </div>
    </div>{{-- /pd-info-panel --}}
  </div>{{-- /pd-top --}}


  {{-- ══════════════════════════════════════
       TABS: Detail / Specs / Return / Delivery
  ══════════════════════════════════════ --}}
  <div class="pd-tabs-section">
    <div class="pd-tab-nav">
      <button class="pd-tab-btn active" onclick="switchTab(this,'tab-detail')">Detail</button>
      <button class="pd-tab-btn" onclick="switchTab(this,'tab-specs')">Specifications</button>
      <button class="pd-tab-btn" onclick="switchTab(this,'tab-return')">Return Policy</button>
      <button class="pd-tab-btn" onclick="switchTab(this,'tab-delivery')">Delivery Info</button>
    </div>

    <div id="tab-detail" class="pd-tab-content active">
      @if($product->description)
        <p class="pd-desc-text">{{ $product->description }}</p>
      @else
        <p class="pd-desc-text" style="color:var(--muted);">No description available.</p>
      @endif
    </div>

    <div id="tab-specs" class="pd-tab-content">
      <div class="pd-specs-grid">
        @if($product->category)     <div class="pd-spec-item"><span class="pd-spec-label">Category</span>      <span class="pd-spec-val">{{ $product->category->name }}</span></div> @endif
        @if($product->gender)       <div class="pd-spec-item"><span class="pd-spec-label">Gender</span>         <span class="pd-spec-val">{{ $product->gender }}</span></div>           @endif
        @if($product->frame_shape)  <div class="pd-spec-item"><span class="pd-spec-label">Frame Shape</span>   <span class="pd-spec-val">{{ $product->frame_shape }}</span></div>       @endif
        @if($product->frame_material)<div class="pd-spec-item"><span class="pd-spec-label">Frame Material</span><span class="pd-spec-val">{{ $product->frame_material }}</span></div>   @endif
        @if($product->rim_type)     <div class="pd-spec-item"><span class="pd-spec-label">Rim Type</span>      <span class="pd-spec-val">{{ $product->rim_type }}</span></div>          @endif
        @if($product->lens_type)    <div class="pd-spec-item"><span class="pd-spec-label">Lens Type</span>     <span class="pd-spec-val">{{ $product->lens_type }}</span></div>         @endif
        @if($product->lens_material)<div class="pd-spec-item"><span class="pd-spec-label">Lens Material</span> <span class="pd-spec-val">{{ $product->lens_material }}</span></div>    @endif
        @if($product->frame_width)  <div class="pd-spec-item"><span class="pd-spec-label">Frame Width</span>   <span class="pd-spec-val">{{ $product->frame_width }} mm</span></div>    @endif
        @if($product->lens_width)   <div class="pd-spec-item"><span class="pd-spec-label">Lens Width</span>    <span class="pd-spec-val">{{ $product->lens_width }} mm</span></div>     @endif
        @if($product->bridge_width) <div class="pd-spec-item"><span class="pd-spec-label">Bridge Width</span>  <span class="pd-spec-val">{{ $product->bridge_width }} mm</span></div>   @endif
        @if($product->temple_length)<div class="pd-spec-item"><span class="pd-spec-label">Temple Length</span> <span class="pd-spec-val">{{ $product->temple_length }} mm</span></div>  @endif
        @if($product->sku)          <div class="pd-spec-item"><span class="pd-spec-label">SKU</span>           <span class="pd-spec-val">{{ $product->sku }}</span></div>               @endif
      </div>
    </div>

    <div id="tab-return" class="pd-tab-content">
      <p class="pd-desc-text">Easy 14-day returns on unused items in original packaging. Items must be unworn and in their original condition with all tags attached. To initiate a return, contact our support team with your order number.</p>
    </div>

    <div id="tab-delivery" class="pd-tab-content">
      <p class="pd-desc-text">Free shipping on orders over ৳1000. Standard delivery 2–5 business days. Express delivery available at checkout. We deliver across Bangladesh. Track your order via the confirmation email sent after purchase.</p>
    </div>
  </div>


  {{-- ══════════════════════════════════════
       REVIEWS
  ══════════════════════════════════════ --}}
  <!-- <section class="pd-reviews-section">
    <h2 class="pd-reviews-title">Customer Reviews</h2>
    <div class="reviews-inner">

      @if($product->reviewCount() > 0)
        <div class="rating-summary-card">
          <div style="text-align:center;">
            <div class="rating-big-num">{{ number_format($product->averageRating(), 1) }}</div>
            <div class="rating-stars-row">
              @for($i = 1; $i <= 5; $i++)
                <i class="fas fa-star" style="color: {{ $i <= round($product->averageRating()) ? '#c9973f' : '#e8e3db' }};"></i>
              @endfor
            </div>
            <div class="rating-total-txt">{{ $product->reviewCount() }} review{{ $product->reviewCount() != 1 ? 's' : '' }}</div>
          </div>
          <div class="rating-bars">
            @foreach([5,4,3,2,1] as $star)
              @php
                $cnt = $product->reviews()->where('rating', $star)->count();
                $pct = $product->reviewCount() > 0 ? round(($cnt / $product->reviewCount()) * 100) : 0;
              @endphp
              <div class="rating-bar-row">
                <span>{{ $star }}</span>
                <i class="fas fa-star" style="font-size:10px;color:var(--gold);"></i>
                <div class="rating-bar-track">
                  <div class="rating-bar-fill" style="width:{{ $pct }}%;"></div>
                </div>
                <span class="rating-bar-count">{{ $cnt }}</span>
              </div>
            @endforeach
          </div>
        </div>
      @endif

      @auth
        @php $userReview = $product->reviews()->where('user_id', auth()->id())->first(); @endphp
        <div class="write-review-card">
          <h4>{{ $userReview ? 'Edit Your Review' : 'Write a Review' }}</h4>
          @if(session('review_success'))
            <div class="review-alert-success">
              <i class="fas fa-check-circle"></i> {{ session('review_success') }}
            </div>
          @endif
          <form method="POST" action="{{ route('reviews.store', $product) }}">
            @csrf
            <p style="font-size:11px;font-weight:700;letter-spacing:.12em;text-transform:uppercase;color:var(--muted);margin-bottom:10px;">Your Rating</p>
            <div class="star-input">
              @for($i = 5; $i >= 1; $i--)
                <input type="radio" name="rating" id="star{{ $i }}" value="{{ $i }}"
                       {{ ($userReview && $userReview->rating == $i) ? 'checked' : '' }}>
                <label for="star{{ $i }}">★</label>
              @endfor
            </div>
            @error('rating')
              <p style="color:var(--red);font-size:12px;margin-bottom:10px;">⚠ {{ $message }}</p>
            @enderror
            <p style="font-size:11px;font-weight:700;letter-spacing:.12em;text-transform:uppercase;color:var(--muted);margin-bottom:8px;">Your Comment</p>
            <textarea name="comment" rows="3" class="review-textarea"
                      placeholder="Share your experience with this product...">{{ $userReview->comment ?? '' }}</textarea>
            <button type="submit" class="btn-submit-review">
              <i class="fas fa-paper-plane"></i>
              {{ $userReview ? 'Update Review' : 'Submit Review' }}
            </button>
          </form>
        </div>
      @else
        <div class="login-to-review">
          <p><a href="{{ route('login') }}">Login</a> to write a review.</p>
        </div>
      @endauth

      @forelse($product->reviews as $review)
        <div class="review-card">
          <div class="review-card-top">
            <div class="reviewer-info">
              <div class="reviewer-initial">{{ strtoupper(substr($review->user->name, 0, 1)) }}</div>
              <div>
                <div class="reviewer-name">{{ $review->user->name }}</div>
                <div class="reviewer-date">{{ $review->created_at->diffForHumans() }}</div>
              </div>
            </div>
            <div class="review-card-stars">
              @for($i = 1; $i <= 5; $i++)
                <i class="fas fa-star" style="color: {{ $i <= $review->rating ? '#c9973f' : '#e8e3db' }};"></i>
              @endfor
            </div>
          </div>
          @if($review->comment)
            <p class="review-card-text">{{ $review->comment }}</p>
          @endif
          @auth
            @if($review->user_id === auth()->id())
              <form method="POST" action="{{ route('reviews.destroy', $review) }}" style="display:inline;">
                @csrf @method('DELETE')
                <button type="submit" class="btn-delete-review">
                  <i class="fas fa-trash"></i> Delete
                </button>
              </form>
            @endif
          @endauth
        </div>
      @empty
        <div class="reviews-empty">
          <p>No reviews yet. Be the first to review!</p>
        </div>
      @endforelse

    </div>
  </section> -->


  {{-- ── Related Products ── --}}
  @if(isset($relatedProducts) && $relatedProducts->count() > 0)
    <section class="pd-related">
      <div class="pd-related-header">
        <h2 class="pd-related-title">You May Also Like</h2>
        <a href="{{ route('frontend.shop') }}" class="pd-related-link">View All</a>
      </div>
      <div class="pd-related-grid">
        @foreach($relatedProducts as $rel)
          <a href="{{ route('shop.show', $rel->slug) }}" class="pd-rel-card">
            <div class="pd-rel-img">
              <img src="{{ asset('storage/' . $rel->primary_image) }}"
                   alt="{{ $rel->name }}"
                   onerror="this.src='https://placehold.co/400x400?text=No+Image'">
            </div>
            <div class="pd-rel-info">
              @if($rel->brand)<p class="pd-rel-brand">{{ $rel->brand->name }}</p>@endif
              <p class="pd-rel-name">{{ $rel->name }}</p>
              <p class="pd-rel-price">৳{{ number_format($rel->sale_price ?? $rel->price, 0) }}</p>
            </div>
          </a>
        @endforeach
      </div>
    </section>
  @endif

</div>{{-- /pd-wrap --}}

<script>
  function switchImg(thumb, src, idx) {
    document.getElementById('pdMainImg').src = src;
    document.querySelectorAll('.pd-thumb').forEach(t => t.classList.remove('active'));
    thumb.classList.add('active');
    // sync dots
    document.querySelectorAll('.pd-img-dot').forEach((d, i) => {
      d.classList.toggle('active', i === idx);
    });
  }

  function switchImgDot(dot, src, idx) {
    document.getElementById('pdMainImg').src = src;
    document.querySelectorAll('.pd-img-dot').forEach(d => d.classList.remove('active'));
    dot.classList.add('active');
    document.querySelectorAll('.pd-thumb').forEach((t, i) => {
      t.classList.toggle('active', i === idx);
    });
  }

  function changeQty(delta) {
    const inp = document.getElementById('pdQty');
    const max = parseInt(inp.max) || 999;
    inp.value = Math.min(max, Math.max(1, parseInt(inp.value || 1) + delta));
  }

  function selectColor(el) {
    document.querySelectorAll('.pd-color-tag').forEach(t => t.classList.remove('active'));
    el.classList.add('active');
  }

  function switchTab(btn, tabId) {
    document.querySelectorAll('.pd-tab-btn').forEach(b => b.classList.remove('active'));
    document.querySelectorAll('.pd-tab-content').forEach(c => c.classList.remove('active'));
    btn.classList.add('active');
    document.getElementById(tabId).classList.add('active');
  }
</script>

@endsection