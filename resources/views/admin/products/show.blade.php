{{-- resources/views/products/show.blade.php --}}

@extends('layouts.home')

@section('title', $product->name . ' – Premium Eyewear')

@section('content')

<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,400&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">

<style>
  :root {
    --ink:    #0f0e0d;
    --cream:  #f7f4ef;
    --gold:   #b8955a;
    --gold2:  #d4af7a;
    --muted:  #6b6560;
    --border: #e2ddd6;
    --white:  #ffffff;
    --red:    #c0392b;
    --green:  #2d6a4f;
  }

  * { box-sizing: border-box; margin: 0; padding: 0; }

  /* ── Overlay ── */
  .pdm-overlay {
    position: fixed;
    inset: 0;
    background: rgba(15,14,13,.6);
    backdrop-filter: blur(6px);
    -webkit-backdrop-filter: blur(6px);
    z-index: 9999;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
    animation: overlayIn .25s ease both;
  }

  @keyframes overlayIn {
    from { opacity: 0; }
    to   { opacity: 1; }
  }

  /* ── Modal ── */
  .pdm-modal {
    background: var(--white);
    border-radius: 8px;
    width: 100%;
    max-width: 960px;
    max-height: 92vh;
    display: grid;
    grid-template-columns: 1fr 1fr;
    overflow: hidden;
    position: relative;
    box-shadow: 0 40px 100px rgba(0,0,0,.28);
    animation: modalIn .35s cubic-bezier(.22,.68,0,1.15) both;
  }

  @keyframes modalIn {
    from { opacity: 0; transform: translateY(30px) scale(.96); }
    to   { opacity: 1; transform: none; }
  }

  /* ── Close Button ── */
  .pdm-close {
    position: absolute;
    top: 14px; right: 14px;
    width: 34px; height: 34px;
    border-radius: 50%;
    border: 1px solid var(--border);
    background: var(--white);
    color: var(--muted);
    font-size: 16px;
    cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    z-index: 10;
    transition: all .2s;
    text-decoration: none;
    line-height: 1;
  }
  .pdm-close:hover { border-color: var(--ink); color: var(--ink); }

  /* ── Left: Gallery ── */
  .pdm-gallery {
    background: var(--cream);
    display: flex;
    flex-direction: column;
    padding: 36px 28px 24px;
    gap: 16px;
    border-right: 1px solid var(--border);
  }

  .pdm-main-img {
    flex: 1;
    background: var(--white);
    border-radius: 4px;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    position: relative;
    min-height: 280px;
  }

  .pdm-main-img img {
    width: 100%; height: 100%;
    object-fit: contain;
    padding: 28px;
    transition: transform .55s cubic-bezier(.25,.46,.45,.94);
  }
  .pdm-main-img:hover img { transform: scale(1.05); }

  .pdm-badges {
    position: absolute;
    top: 12px; left: 12px;
    display: flex; flex-direction: column; gap: 5px;
  }
  .pdm-badge {
    padding: 3px 9px;
    font-size: 9px; font-weight: 700;
    letter-spacing: .1em; text-transform: uppercase; border-radius: 2px;
  }
  .pdm-badge-new        { background: var(--ink); color: var(--white); }
  .pdm-badge-sale       { background: var(--gold); color: var(--white); }
  .pdm-badge-bestseller { background: #1a1a2e; color: #e8c97e; }

  .pdm-thumbs {
    display: flex; gap: 8px; overflow-x: auto; padding-bottom: 2px;
  }
  .pdm-thumbs::-webkit-scrollbar { height: 3px; }
  .pdm-thumbs::-webkit-scrollbar-thumb { background: var(--gold); border-radius: 2px; }

  .pdm-thumb {
    width: 62px; height: 62px; flex-shrink: 0;
    border: 2px solid transparent; border-radius: 3px;
    cursor: pointer; overflow: hidden; background: var(--white);
    transition: border-color .2s;
  }
  .pdm-thumb img { width: 100%; height: 100%; object-fit: contain; padding: 5px; }
  .pdm-thumb.active, .pdm-thumb:hover { border-color: var(--gold); }

  /* ── Right: Info ── */
  .pdm-info {
    padding: 36px 32px 28px;
    overflow-y: auto;
    display: flex; flex-direction: column;
    font-family: 'DM Sans', sans-serif;
  }

  .pdm-brand {
    font-size: 10px; font-weight: 600;
    letter-spacing: .18em; text-transform: uppercase;
    color: var(--gold); margin-bottom: 6px;
  }

  .pdm-name {
    font-family: 'Cormorant Garamond', serif;
    font-size: 30px; font-weight: 300; line-height: 1.2;
    color: var(--ink); margin-bottom: 4px;
  }

  .pdm-sku {
    font-size: 10px; color: var(--muted);
    letter-spacing: .08em; margin-bottom: 16px;
  }

  .pdm-divider { height: 1px; background: var(--border); margin: 16px 0; }

  .pdm-price-row { display: flex; align-items: baseline; gap: 10px; margin-bottom: 8px; }

  .pdm-price {
    font-family: 'Cormorant Garamond', serif;
    font-size: 34px; font-weight: 600; color: var(--ink);
  }
  .pdm-price-old { font-size: 16px; color: var(--muted); text-decoration: line-through; }
  .pdm-discount-tag {
    padding: 2px 8px;
    background: #fef3e2; color: var(--gold);
    font-size: 11px; font-weight: 600;
    border-radius: 2px; border: 1px solid var(--gold2);
  }

  .pdm-stock {
    display: inline-flex; align-items: center; gap: 5px;
    font-size: 12px; font-weight: 500; margin-bottom: 14px;
  }
  .pdm-stock-dot { width: 7px; height: 7px; border-radius: 50%; }
  .pdm-stock.instock  { color: var(--green); }
  .pdm-stock.instock  .pdm-stock-dot { background: var(--green); }
  .pdm-stock.outstock { color: var(--red); }
  .pdm-stock.outstock .pdm-stock-dot { background: var(--red); }

  .pdm-desc { font-size: 13px; color: var(--muted); line-height: 1.8; margin-bottom: 14px; }

  .pdm-specs-grid {
    display: grid; grid-template-columns: 1fr 1fr; gap: 8px 16px; margin-bottom: 14px;
  }
  .pdm-spec { display: flex; flex-direction: column; gap: 1px; }
  .pdm-spec-label { font-size: 9px; text-transform: uppercase; letter-spacing: .08em; color: var(--muted); }
  .pdm-spec-val   { font-size: 13px; font-weight: 500; color: var(--ink); }

  .pdm-colors { display: flex; flex-wrap: wrap; gap: 6px; margin-bottom: 14px; }
  .pdm-color-chip {
    padding: 4px 12px;
    border: 1px solid var(--border); border-radius: 2px;
    font-size: 12px; color: var(--ink); background: var(--cream);
  }

  .pdm-alert { padding: 10px 14px; border-radius: 2px; font-size: 12px; margin-bottom: 12px; }
  .pdm-alert-success { background: #edf7f1; color: var(--green); border: 1px solid #b7dfc8; }
  .pdm-alert-error   { background: #fdf0ef; color: var(--red);   border: 1px solid #f5c2be; }

  .pdm-section-label {
    font-size: 10px; font-weight: 600; letter-spacing: .1em;
    text-transform: uppercase; color: var(--muted); margin-bottom: 6px; display: block;
  }

  .pdm-select {
    width: 100%; padding: 9px 14px;
    border: 1px solid var(--border); border-radius: 2px;
    background: var(--cream);
    font-family: 'DM Sans', sans-serif; font-size: 13px; color: var(--ink);
    appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath d='M1 1l5 5 5-5' stroke='%236b6560' stroke-width='1.5' fill='none' stroke-linecap='round'/%3E%3C/svg%3E");
    background-repeat: no-repeat; background-position: right 12px center;
    cursor: pointer; outline: none; transition: border-color .2s; margin-bottom: 14px;
  }
  .pdm-select:focus { border-color: var(--gold); }

  .pdm-rx-box {
    display: none;
    background: var(--cream); border: 1px solid var(--border);
    border-radius: 3px; padding: 14px; margin-bottom: 14px;
  }
  .pdm-rx-box.visible { display: block; }
  .pdm-rx-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
  .pdm-rx-item { display: flex; flex-direction: column; gap: 4px; }
  .pdm-rx-label { font-size: 10px; color: var(--muted); text-transform: uppercase; letter-spacing: .06em; }
  .pdm-rx-input {
    padding: 8px 10px; border: 1px solid var(--border); border-radius: 2px;
    font-family: 'DM Sans', sans-serif; font-size: 13px; color: var(--ink);
    background: var(--white); outline: none; transition: border-color .2s;
  }
  .pdm-rx-input:focus { border-color: var(--gold); }

  .pdm-cart-row {
    display: flex; gap: 10px; align-items: center; margin-top: auto; padding-top: 16px;
  }

  .pdm-qty {
    display: flex; align-items: center;
    border: 1px solid var(--border); border-radius: 2px; overflow: hidden; background: var(--white);
  }
  .pdm-qty button {
    width: 36px; height: 44px; border: none; background: none;
    font-size: 16px; cursor: pointer; color: var(--ink); transition: background .2s;
  }
  .pdm-qty button:hover { background: var(--cream); }
  .pdm-qty input {
    width: 44px; height: 44px; border: none;
    border-left: 1px solid var(--border); border-right: 1px solid var(--border);
    text-align: center; font-family: 'DM Sans', sans-serif;
    font-size: 14px; font-weight: 500; background: var(--white); color: var(--ink); outline: none;
  }

  .pdm-btn-cart {
    flex: 1; height: 44px;
    background: var(--ink); color: var(--white);
    border: 2px solid var(--ink); border-radius: 2px;
    font-family: 'DM Sans', sans-serif; font-size: 12px; font-weight: 600;
    letter-spacing: .1em; text-transform: uppercase;
    cursor: pointer; transition: all .22s;
  }
  .pdm-btn-cart:hover { background: var(--gold); border-color: var(--gold); }
  .pdm-btn-cart:disabled { opacity: .4; cursor: not-allowed; }

  .pdm-btn-wish {
    width: 44px; height: 44px; flex-shrink: 0;
    border: 1px solid var(--border); background: var(--white); border-radius: 2px;
    cursor: pointer; font-size: 17px; color: var(--muted);
    display: flex; align-items: center; justify-content: center; transition: all .2s;
  }
  .pdm-btn-wish:hover { border-color: var(--red); color: var(--red); }

  .pdm-login-btn {
    display: inline-flex; align-items: center; gap: 6px;
    height: 44px; padding: 0 24px;
    border: 2px solid var(--ink); border-radius: 2px;
    font-family: 'DM Sans', sans-serif; font-size: 12px; font-weight: 600;
    letter-spacing: .1em; text-transform: uppercase;
    color: var(--ink); text-decoration: none; transition: all .22s;
  }
  .pdm-login-btn:hover { background: var(--ink); color: var(--white); }

  /* Responsive */
  @media (max-width: 720px) {
    .pdm-modal { grid-template-columns: 1fr; max-height: 96vh; overflow-y: auto; }
    .pdm-gallery { border-right: none; border-bottom: 1px solid var(--border); padding: 24px 20px 16px; }
    .pdm-main-img { min-height: 220px; }
    .pdm-info { padding: 24px 20px 20px; }
    .pdm-name { font-size: 24px; }
    .pdm-rx-grid { grid-template-columns: 1fr; }
  }
</style>

{{-- Blurred page background --}}
<div style="position:fixed;inset:0;background:var(--cream);z-index:-1;"></div>

<div class="pdm-overlay">
  <div class="pdm-modal">

    {{-- Close → back to shop --}}
    <a href="{{ route('frontend.shop') }}" class="pdm-close" title="Close">✕</a>

    {{-- ── LEFT: Gallery ── --}}
    <div class="pdm-gallery">

      <div class="pdm-main-img">
        <div class="pdm-badges">
          @if(isset($product->is_new) && $product->is_new)
            <span class="pdm-badge pdm-badge-new">New</span>
          @endif
          @if($product->sale_price && $product->sale_price < $product->price)
            <span class="pdm-badge pdm-badge-sale">Sale</span>
          @endif
          @if(isset($product->is_bestseller) && $product->is_bestseller)
            <span class="pdm-badge pdm-badge-bestseller">Bestseller</span>
          @endif
        </div>

        @php
          $primaryImage = $product->images->where('is_primary', true)->first()
                        ?? $product->images->first();
          $mainImgSrc   = $primaryImage
                        ? asset('storage/' . $primaryImage->image_path)
                        : 'https://placehold.co/600x600?text=No+Image';
        @endphp

        <img id="pdmMainImg"
             src="{{ $mainImgSrc }}"
             alt="{{ $product->name }}"
             onerror="this.src='https://placehold.co/600x600?text=No+Image'">
      </div>

      @if($product->images && $product->images->count() > 1)
      <div class="pdm-thumbs">
        @foreach($product->images as $img)
        <div class="pdm-thumb {{ $loop->first ? 'active' : '' }}"
             onclick="pdmSwitch(this,'{{ asset('storage/' . $img->image_path) }}')">
          <img src="{{ asset('storage/' . $img->image_path) }}"
               alt="{{ $img->alt_text ?? $product->name }}"
               onerror="this.src='https://placehold.co/62x62?text=Img'">
        </div>
        @endforeach
      </div>
      @endif
    </div>

    {{-- ── RIGHT: Info ── --}}
    <div class="pdm-info">

      @if($product->brand)
        <p class="pdm-brand">{{ $product->brand->name }}</p>
      @endif

      <h1 class="pdm-name">{{ $product->name }}</h1>

      @if($product->sku)
        <p class="pdm-sku">SKU: {{ $product->sku }}</p>
      @endif

      <div class="pdm-divider"></div>

      {{-- Price --}}
      <div class="pdm-price-row">
        <span class="pdm-price">৳{{ number_format($product->sale_price ?? $product->price, 0) }}</span>
        @if($product->sale_price && $product->sale_price < $product->price)
          <span class="pdm-price-old">৳{{ number_format($product->price, 0) }}</span>
          @php $disc = round((1 - $product->sale_price / $product->price) * 100); @endphp
          <span class="pdm-discount-tag">{{ $disc }}% off</span>
        @endif
      </div>

      {{-- Stock --}}
      @if($product->stock_quantity > 0)
        <div class="pdm-stock instock">
          <span class="pdm-stock-dot"></span>
          In Stock · {{ $product->stock_quantity }} available
        </div>
      @else
        <div class="pdm-stock outstock">
          <span class="pdm-stock-dot"></span>
          Out of Stock
        </div>
      @endif

      {{-- Description --}}
      @if($product->short_description ?? $product->description)
        <p class="pdm-desc">{{ $product->short_description ?? Str::limit($product->description, 140) }}</p>
      @endif

      {{-- Specs --}}
      @php
        $specs = array_filter([
          'Category'       => optional($product->category)->name,
          'Gender'         => $product->gender ?? null,
          'Frame Shape'    => $product->frame_shape ?? null,
          'Frame Material' => $product->frame_material ?? null,
          'Rim Type'       => $product->rim_type ?? null,
          'Lens Type'      => $product->lens_type ?? null,
          'Lens Material'  => $product->lens_material ?? null,
          'Frame Width'    => isset($product->frame_width)   ? $product->frame_width   . ' mm' : null,
          'Lens Width'     => isset($product->lens_width)    ? $product->lens_width    . ' mm' : null,
          'Bridge Width'   => isset($product->bridge_width)  ? $product->bridge_width  . ' mm' : null,
          'Temple Length'  => isset($product->temple_length) ? $product->temple_length . ' mm' : null,
        ]);
      @endphp

      @if(count($specs))
      <div class="pdm-specs-grid">
        @foreach($specs as $label => $val)
          <div class="pdm-spec">
            <span class="pdm-spec-label">{{ $label }}</span>
            <span class="pdm-spec-val">{{ $val }}</span>
          </div>
        @endforeach
      </div>
      @endif

      {{-- Colors --}}
      @if($product->colors && $product->colors->count() > 0)
      <div class="pdm-colors">
        @foreach($product->colors as $color)
          <span class="pdm-color-chip">{{ $color->name }}</span>
        @endforeach
      </div>
      @endif

      {{-- Alerts --}}
      @if(session('success'))
        <div class="pdm-alert pdm-alert-success">✓ &nbsp;{{ session('success') }}</div>
      @endif
      @if(session('error'))
        <div class="pdm-alert pdm-alert-error">✕ &nbsp;{{ session('error') }}</div>
      @endif

      {{-- Add to Cart --}}
      @auth
      <form action="{{ route('cart.store') }}" method="POST">
        @csrf
        <input type="hidden" name="product_id" value="{{ $product->id }}">

        @if($product->frame_colors)
        <div>
          <label class="pdm-section-label">Frame Color</label>
          <select name="frame_color" class="pdm-select">
            @foreach(explode(',', $product->frame_colors) as $color)
              <option value="{{ trim($color) }}">{{ trim($color) }}</option>
            @endforeach
          </select>
        </div>
        @endif

        <div>
          <label class="pdm-section-label">Lens Type</label>
          <select name="lens_type" class="pdm-select" onchange="toggleRx(this.value)">
            <option value="no_power">No Power (Plain)</option>
            <option value="single_vision">Single Vision</option>
            <option value="bifocal">Bifocal</option>
            <option value="progressive">Progressive</option>
          </select>
        </div>

        <div class="pdm-rx-box" id="pdmRxBox">
          <p class="pdm-section-label" style="margin-bottom:10px;">Prescription</p>
          <div class="pdm-rx-grid">
            <div class="pdm-rx-item">
              <label class="pdm-rx-label">SPH Left</label>
              <input type="number" step="0.25" name="sph_left" class="pdm-rx-input" placeholder="-1.50">
            </div>
            <div class="pdm-rx-item">
              <label class="pdm-rx-label">SPH Right</label>
              <input type="number" step="0.25" name="sph_right" class="pdm-rx-input" placeholder="-1.25">
            </div>
            <div class="pdm-rx-item">
              <label class="pdm-rx-label">CYL Left</label>
              <input type="number" step="0.25" name="cyl_left" class="pdm-rx-input" placeholder="-0.50">
            </div>
            <div class="pdm-rx-item">
              <label class="pdm-rx-label">CYL Right</label>
              <input type="number" step="0.25" name="cyl_right" class="pdm-rx-input" placeholder="-0.25">
            </div>
          </div>
        </div>

        <div class="pdm-cart-row">
          <div class="pdm-qty">
            <button type="button" onclick="pdmQty(-1)">−</button>
            <input type="number" name="quantity" id="pdmQtyInput" value="1" min="1" max="{{ $product->stock_quantity }}">
            <button type="button" onclick="pdmQty(1)">+</button>
          </div>
          <button type="submit" class="pdm-btn-cart" {{ $product->stock_quantity <= 0 ? 'disabled' : '' }}>
            🛒 &nbsp;Add to Cart
          </button>
          <button type="button" class="pdm-btn-wish" title="Wishlist">♡</button>
        </div>
      </form>

      @else
        <div class="pdm-cart-row">
          <a href="{{ route('login') }}" class="pdm-login-btn">🔑 &nbsp;Login to Add to Cart</a>
        </div>
      @endauth

    </div>
    {{-- /pdm-info --}}

  </div>
  {{-- /pdm-modal --}}
</div>

<script>
  function pdmSwitch(thumb, src) {
    document.getElementById('pdmMainImg').src = src;
    document.querySelectorAll('.pdm-thumb').forEach(t => t.classList.remove('active'));
    thumb.classList.add('active');
  }

  function pdmQty(d) {
    const inp = document.getElementById('pdmQtyInput');
    const max = parseInt(inp.max) || 999;
    inp.value = Math.min(max, Math.max(1, parseInt(inp.value || 1) + d));
  }

  function toggleRx(val) {
    document.getElementById('pdmRxBox').classList.toggle('visible', val !== 'no_power');
  }

  // ESC → back to shop
  document.addEventListener('keydown', e => {
    if (e.key === 'Escape') window.location.href = '{{ route("frontend.shop") }}';
  });
</script>

@endsection