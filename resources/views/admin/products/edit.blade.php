@extends('layouts.admin')

@section('title', 'Edit Product')

@section('content')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">

<style>
  :root {
    --ink:    #0f0e0d;
    --cream:  #f7f4ef;
    --gold:   #b8955a;
    --muted:  #6b6560;
    --border: #e2ddd6;
    --white:  #ffffff;
    --red:    #dc3545;
    --blue:   #007bff;
    --green:  #28a745;
    --bg:     #f1f3f6;
  }

  * { box-sizing: border-box; margin: 0; padding: 0; }

  .epm-overlay {
    position: fixed; inset: 0;
    background: rgba(10,10,12,.55);
    backdrop-filter: blur(5px);
    -webkit-backdrop-filter: blur(5px);
    z-index: 9999;
    display: flex; align-items: center; justify-content: center;
    padding: 16px;
    animation: epmFadeIn .25s ease both;
  }
  @keyframes epmFadeIn { from { opacity:0; } to { opacity:1; } }

  .epm-modal {
    background: var(--white);
    border-radius: 10px;
    width: 100%; max-width: 860px; max-height: 94vh;
    display: flex; flex-direction: column;
    overflow: hidden;
    box-shadow: 0 32px 80px rgba(0,0,0,.25);
    animation: epmSlideIn .32s cubic-bezier(.22,.68,0,1.15) both;
    font-family: 'DM Sans', sans-serif;
  }
  @keyframes epmSlideIn {
    from { opacity:0; transform: translateY(28px) scale(.96); }
    to   { opacity:1; transform: none; }
  }

  .epm-header {
    display: flex; align-items: center; justify-content: space-between;
    padding: 18px 24px; border-bottom: 1px solid var(--border);
    flex-shrink: 0; background: var(--white);
  }
  .epm-header-left { display: flex; flex-direction: column; gap: 2px; }
  .epm-title { font-size: 17px; font-weight: 600; color: var(--ink); display: flex; align-items: center; gap: 8px; }
  .epm-subtitle { font-size: 12px; color: var(--muted); }
  .epm-id-badge {
    background: #e8f0fe; color: var(--blue);
    font-size: 11px; font-weight: 600; padding: 4px 10px;
    border-radius: 20px; display: flex; align-items: center; gap: 4px;
  }
  .epm-close {
    width: 32px; height: 32px; border-radius: 50%;
    border: 1px solid var(--border); background: var(--white); color: var(--muted);
    font-size: 14px; cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    text-decoration: none; transition: all .2s; flex-shrink: 0; margin-left: 12px;
  }
  .epm-close:hover { border-color: var(--ink); color: var(--ink); }

  .epm-tabs {
    display: flex; border-bottom: 1px solid var(--border);
    background: #fafafa; flex-shrink: 0; overflow-x: auto; padding: 0 24px;
  }
  .epm-tabs::-webkit-scrollbar { display: none; }
  .epm-tab {
    padding: 12px 18px; font-size: 12px; font-weight: 600;
    letter-spacing: .04em; color: var(--muted); cursor: pointer;
    border-bottom: 2px solid transparent; white-space: nowrap;
    transition: all .2s; user-select: none; display: flex; align-items: center; gap: 6px;
  }
  .epm-tab:hover { color: var(--ink); }
  .epm-tab.active { color: var(--blue); border-bottom-color: var(--blue); }

  .epm-body { overflow-y: auto; flex: 1; padding: 24px; background: var(--bg); }

  .epm-panel { display: none; }
  .epm-panel.active { display: block; }

  .epm-card {
    background: var(--white); border-radius: 8px;
    border: 1px solid #eee; overflow: hidden; margin-bottom: 16px;
  }
  .epm-card-header {
    padding: 13px 18px; border-bottom: 1px solid #f0f0f0; background: #f8f9fa;
    font-size: 12px; font-weight: 600; color: #444;
    display: flex; align-items: center; gap: 7px;
    text-transform: uppercase; letter-spacing: .05em;
  }
  .epm-card-body { padding: 20px 18px; }

  .epm-row { display: grid; grid-template-columns: repeat(2, 1fr); gap: 14px; }
  .epm-row-3 { grid-template-columns: repeat(3, 1fr); }
  .epm-group { margin-bottom: 14px; }
  .epm-group:last-child { margin-bottom: 0; }
  .epm-label {
    display: block; margin-bottom: 5px;
    font-size: 11px; font-weight: 600; color: #555;
    text-transform: uppercase; letter-spacing: .05em;
  }
  .epm-label .req { color: var(--red); }
  .epm-input, .epm-select, .epm-textarea {
    width: 100%; padding: 9px 12px; border: 1px solid #ddd; border-radius: 5px;
    font-family: 'DM Sans', sans-serif; font-size: 13px; color: var(--ink);
    background: var(--white); transition: border-color .2s, box-shadow .2s; outline: none;
  }
  .epm-input:focus, .epm-select:focus, .epm-textarea:focus {
    border-color: var(--blue); box-shadow: 0 0 0 3px rgba(0,123,255,.08);
  }
  .epm-input.is-invalid { border-color: var(--red); }
  .epm-textarea { resize: vertical; min-height: 80px; }
  .epm-select {
    appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath d='M1 1l5 5 5-5' stroke='%236b6560' stroke-width='1.5' fill='none' stroke-linecap='round'/%3E%3C/svg%3E");
    background-repeat: no-repeat; background-position: right 12px center;
    padding-right: 32px; cursor: pointer;
  }
  .epm-hint  { display: block; margin-top: 4px; font-size: 11px; color: var(--muted); }
  .epm-error { display: block; margin-top: 4px; font-size: 11px; color: var(--red); }

  .epm-meas-grid { display: grid; grid-template-columns: repeat(5, 1fr); gap: 10px; }
  .epm-meas-grid .epm-group { margin-bottom: 0; }
  .epm-meas-grid .epm-label { font-size: 10px; }

  .epm-alert {
    display: flex; align-items: flex-start; gap: 10px;
    padding: 12px 16px; border-radius: 6px; margin-bottom: 16px;
    border-left: 4px solid; font-size: 13px;
  }
  .epm-alert-danger { background: #f8d7da; border-color: var(--red); color: #721c24; }
  .epm-alert i { font-size: 16px; flex-shrink: 0; margin-top: 1px; }
  .epm-alert ul { margin: 4px 0 0; padding-left: 16px; font-size: 12px; }

  /* ══ IMAGE GRID ══ */
  .epm-images-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(110px, 1fr));
    gap: 12px;
  }

  .epm-img-card {
    position: relative;
    border-radius: 8px;
    overflow: hidden;
    border: 2.5px solid #eee;
    aspect-ratio: 1;
    background: var(--cream);
    cursor: pointer;
    transition: border-color .2s, box-shadow .2s;
  }
  .epm-img-card img { width:100%; height:100%; object-fit:cover; display:block; }
  .epm-img-card.is-primary { border-color: var(--blue); box-shadow: 0 0 0 3px rgba(0,123,255,.15); }
  .epm-img-card.is-deleted { opacity: .3; pointer-events: none; }

  /* Primary star badge */
  .epm-primary-badge {
    position: absolute; top: 6px; left: 6px;
    background: var(--blue); color: #fff;
    font-size: 9px; font-weight: 700;
    padding: 2px 7px; border-radius: 8px;
    display: flex; align-items: center; gap: 3px;
    pointer-events: none;
  }

  /* Action buttons overlay */
  .epm-img-actions {
    position: absolute; inset: 0;
    background: rgba(0,0,0,.45);
    display: flex; align-items: center; justify-content: center; gap: 8px;
    opacity: 0; transition: opacity .2s;
  }
  .epm-img-card:hover .epm-img-actions { opacity: 1; }

  .epm-img-action-btn {
    width: 32px; height: 32px; border-radius: 50%; border: none;
    cursor: pointer; display: flex; align-items: center; justify-content: center;
    font-size: 13px; font-weight: 700; transition: transform .15s;
  }
  .epm-img-action-btn:hover { transform: scale(1.12); }
  .epm-img-btn-primary { background: var(--blue); color: #fff; }
  .epm-img-btn-delete  { background: var(--red);  color: #fff; }

  /* Tooltip */
  .epm-img-action-btn[title]:hover::after {
    content: attr(title);
    position: absolute; bottom: -24px;
    background: #333; color: #fff;
    font-size: 10px; padding: 3px 7px; border-radius: 4px;
    white-space: nowrap; pointer-events: none;
  }

  /* Bottom label */
  .epm-img-label {
    position: absolute; bottom: 0; left: 0; right: 0;
    background: rgba(0,0,0,.5);
    color: #fff; font-size: 10px; text-align: center;
    padding: 3px 4px;
    opacity: 0; transition: opacity .2s;
  }
  .epm-img-card:hover .epm-img-label { opacity: 1; }
  .epm-img-card.is-primary .epm-img-label { opacity: 1; background: rgba(0,123,255,.7); }

  /* ── Upload ── */
  .epm-upload { border: 2px dashed #ddd; border-radius: 6px; transition: border-color .2s; }
  .epm-upload:hover { border-color: var(--blue); }
  .epm-upload-label {
    display: flex; flex-direction: column; align-items: center;
    padding: 28px 16px; cursor: pointer; color: var(--muted); text-align: center;
  }
  .epm-upload-label i    { font-size: 28px; margin-bottom: 8px; color: #adb5bd; }
  .epm-upload-label p    { font-weight: 600; font-size: 13px; margin: 0 0 2px; color: #333; }
  .epm-upload-label small { font-size: 11px; }
  .epm-preview-grid {
    display: grid; grid-template-columns: repeat(auto-fill, minmax(80px, 1fr));
    gap: 10px; margin-top: 12px;
  }
  .epm-preview-item {
    position: relative; aspect-ratio: 1;
    border: 2px solid #ddd; border-radius: 6px; overflow: hidden;
  }
  .epm-preview-item img { width:100%; height:100%; object-fit:cover; display:block; }
  .epm-new-badge {
    position: absolute; top: 5px; left: 5px;
    background: var(--green); color: #fff;
    font-size: 9px; font-weight: 700; padding: 2px 6px; border-radius: 8px;
  }

  /* ── Footer ── */
  .epm-footer {
    padding: 16px 24px; border-top: 1px solid var(--border);
    display: flex; justify-content: space-between; align-items: center;
    flex-shrink: 0; background: var(--white); gap: 10px;
  }
  .epm-footer-left { display: flex; align-items: center; gap: 8px; }
  .epm-btn {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 9px 20px; border-radius: 5px; border: none;
    font-family: 'DM Sans', sans-serif; font-size: 13px; font-weight: 600;
    cursor: pointer; text-decoration: none; transition: all .2s; letter-spacing: .02em;
  }
  .epm-btn-primary   { background: var(--blue);  color: #fff; }
  .epm-btn-primary:hover { background: #0056b3; }
  .epm-btn-ghost { background: none; color: var(--muted); border: 1px solid var(--border); }
  .epm-btn-ghost:hover { border-color: var(--ink); color: var(--ink); }

  @media (max-width: 640px) {
    .epm-overlay { padding: 0; align-items: flex-end; }
    .epm-modal   { max-height: 97vh; border-radius: 12px 12px 0 0; }
    .epm-row     { grid-template-columns: 1fr; }
    .epm-row-3   { grid-template-columns: 1fr 1fr; }
    .epm-meas-grid { grid-template-columns: repeat(2, 1fr); }
    .epm-images-grid { grid-template-columns: repeat(3, 1fr); }
  }
</style>

<div style="position:fixed;inset:0;background:#eef0f4;z-index:-1;"></div>

<div class="epm-overlay">
  <div class="epm-modal">

    {{-- Header --}}
    <div class="epm-header">
      <div class="epm-header-left">
        <div class="epm-title">
          <i class="fas fa-pen" style="color:var(--blue);font-size:14px;"></i>
          Edit Product
        </div>
        <div class="epm-subtitle">{{ $product->name }}</div>
      </div>
      <div style="display:flex;align-items:center;gap:10px;">
        <div class="epm-id-badge"><i class="fas fa-hashtag"></i> ID: {{ $product->id }}</div>
        <a href="{{ route('admin.products.index') }}" class="epm-close" title="Close">✕</a>
      </div>
    </div>

    {{-- Tabs --}}
    <div class="epm-tabs">
      <div class="epm-tab active" onclick="switchTab('basic')">
        <i class="fas fa-info-circle"></i> Basic Info
      </div>
      <div class="epm-tab" onclick="switchTab('specs')">
        <i class="fas fa-glasses"></i> Specifications
      </div>
      <div class="epm-tab" onclick="switchTab('pricing')">
        <i class="fas fa-tag"></i> Pricing & Stock
      </div>
      <div class="epm-tab" onclick="switchTab('images')">
        <i class="fas fa-images"></i> Images
        @if($product->images->count() > 0)
          <span id="imgCountBadge" style="background:#e8f0fe;color:var(--blue);border-radius:10px;padding:1px 7px;font-size:10px;">{{ $product->images->count() }}</span>
        @endif
      </div>
    </div>

    {{-- Form --}}
    <form action="{{ route('admin.products.update', $product) }}" method="POST"
          enctype="multipart/form-data" id="epmForm">
      @csrf
      @method('PUT')

      {{-- Hidden: primary image id (updated by JS) --}}
      <input type="hidden" name="primary_image_id" id="primaryImageInput"
             value="{{ $product->images->where('is_primary', true)->first()?->id ?? $product->images->first()?->id }}">

      <div class="epm-body">

        @if($errors->any())
        <div class="epm-alert epm-alert-danger">
          <i class="fas fa-exclamation-circle"></i>
          <div>
            <strong>Please fix the following errors:</strong>
            <ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
          </div>
        </div>
        @endif

        {{-- TAB: BASIC --}}
        <div class="epm-panel active" id="tab-basic">
          <div class="epm-card">
            <div class="epm-card-header">
              <i class="fas fa-tag" style="color:var(--blue);"></i> Product Details
            </div>
            <div class="epm-card-body">
              <div class="epm-group">
                <label class="epm-label">Product Name <span class="req">*</span></label>
                <input type="text" id="epmName" name="name"
                       class="epm-input @error('name') is-invalid @enderror"
                       value="{{ old('name', $product->name) }}" required>
                @error('name')<span class="epm-error">{{ $message }}</span>@enderror
              </div>
              <div class="epm-row">
                <div class="epm-group">
                  <label class="epm-label">Category <span class="req">*</span></label>
                  <select name="category_id" class="epm-select" required>
                    @foreach($categories as $cat)
                      <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="epm-group">
                  <label class="epm-label">Brand</label>
                  <select name="brand_id" class="epm-select">
                    <option value="">-- Optional --</option>
                    @foreach($brands ?? [] as $brand)
                      <option value="{{ $brand->id }}" {{ old('brand_id', $product->brand_id) == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="epm-row">
                <div class="epm-group">
                  <label class="epm-label">SKU <span class="req">*</span></label>
                  <input type="text" name="sku" class="epm-input" value="{{ old('sku', $product->sku) }}" required>
                </div>
                <div class="epm-group">
                  <label class="epm-label">URL Slug <span class="req">*</span></label>
                  <input type="text" id="epmSlug" name="slug" class="epm-input" value="{{ old('slug', $product->slug) }}" required>
                </div>
              </div>
              <div class="epm-group">
                <label class="epm-label">Short Description</label>
                <textarea name="short_description" class="epm-textarea" rows="2">{{ old('short_description', $product->short_description) }}</textarea>
              </div>
              <div class="epm-group">
                <label class="epm-label">Full Description</label>
                <textarea name="description" class="epm-textarea" rows="4">{{ old('description', $product->description) }}</textarea>
              </div>
            </div>
          </div>
        </div>

        {{-- TAB: SPECS --}}
        <div class="epm-panel" id="tab-specs">
          <div class="epm-card">
            <div class="epm-card-header"><i class="fas fa-glasses" style="color:#6f42c1;"></i> Frame & Lens</div>
            <div class="epm-card-body">
              <div class="epm-row epm-row-3">
                <div class="epm-group">
                  <label class="epm-label">Frame Shape</label>
                  <select name="frame_shape" class="epm-select">
                    <option value="">-- Select --</option>
                    @foreach(['Round','Square','Rectangle','Cat-Eye','Aviator','Wayfarer','Oval'] as $s)
                      <option value="{{ $s }}" {{ old('frame_shape', $product->frame_shape) == $s ? 'selected' : '' }}>{{ $s }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="epm-group">
                  <label class="epm-label">Frame Material</label>
                  <select name="frame_material" class="epm-select">
                    <option value="">-- Select --</option>
                    @foreach(['Acetate','Metal','Plastic','Titanium','Wood','Stainless Steel'] as $m)
                      <option value="{{ $m }}" {{ old('frame_material', $product->frame_material) == $m ? 'selected' : '' }}>{{ $m }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="epm-group">
                  <label class="epm-label">Frame Color</label>
                  <input type="text" name="frame_color" class="epm-input" value="{{ old('frame_color', $product->frame_color) }}" placeholder="e.g. Black, Tortoise">
                </div>
                <div class="epm-group">
                  <label class="epm-label">Rim Type</label>
                  <select name="rim_type" class="epm-select">
                    <option value="">-- Select --</option>
                    @foreach(['Full-rim','Semi-rimless','Rimless'] as $r)
                      <option value="{{ $r }}" {{ old('rim_type', $product->rim_type) == $r ? 'selected' : '' }}>{{ $r }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="epm-group">
                  <label class="epm-label">Lens Type</label>
                  <select name="lens_type" class="epm-select">
                    <option value="">-- Select --</option>
                    @foreach(['Single Vision','Bifocal','Progressive','Reading','Sunglasses','Blue Light'] as $l)
                      <option value="{{ $l }}" {{ old('lens_type', $product->lens_type) == $l ? 'selected' : '' }}>{{ $l }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="epm-group">
                  <label class="epm-label">Gender <span class="req">*</span></label>
                  <select name="gender" class="epm-select" required>
                    @foreach(['Unisex','Men','Women','Kids'] as $g)
                      <option value="{{ $g }}" {{ old('gender', $product->gender) == $g ? 'selected' : '' }}>{{ $g }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
            </div>
          </div>
          <div class="epm-card">
            <div class="epm-card-header"><i class="fas fa-ruler-combined" style="color:#6f42c1;"></i> Measurements (mm)</div>
            <div class="epm-card-body">
              <div class="epm-meas-grid">
                @foreach(['lens_width'=>'Lens Width','bridge_width'=>'Bridge Width','temple_length'=>'Temple Length','lens_height'=>'Lens Height','frame_width'=>'Frame Width'] as $field => $label)
                <div class="epm-group">
                  <label class="epm-label">{{ $label }}</label>
                  <input type="number" name="{{ $field }}" class="epm-input" value="{{ old($field, $product->$field) }}" placeholder="mm">
                </div>
                @endforeach
              </div>
            </div>
          </div>
        </div>

        {{-- TAB: PRICING --}}
        <div class="epm-panel" id="tab-pricing">
          <div class="epm-card">
            <div class="epm-card-header"><i class="fas fa-dollar-sign" style="color:var(--green);"></i> Pricing</div>
            <div class="epm-card-body">
              <div class="epm-row epm-row-3">
                <div class="epm-group">
                  <label class="epm-label">Regular Price <span class="req">*</span></label>
                  <input type="number" id="epmPrice" name="price" class="epm-input" value="{{ old('price', $product->price) }}" step="0.01" min="0" required>
                </div>
                <div class="epm-group">
                  <label class="epm-label">Sale Price</label>
                  <input type="number" id="epmSalePrice" name="sale_price" class="epm-input" value="{{ old('sale_price', $product->sale_price) }}" step="0.01" min="0">
                  <span class="epm-hint">Must be less than regular price</span>
                </div>
                <div class="epm-group">
                  <label class="epm-label">Cost Price</label>
                  <input type="number" name="cost_price" class="epm-input" value="{{ old('cost_price', $product->cost_price) }}" step="0.01" min="0">
                </div>
              </div>
            </div>
          </div>
          <div class="epm-card">
            <div class="epm-card-header"><i class="fas fa-boxes" style="color:#fd7e14;"></i> Inventory</div>
            <div class="epm-card-body">
              <div class="epm-row">
                <div class="epm-group">
                  <label class="epm-label">Stock Quantity <span class="req">*</span></label>
                  <input type="number" name="stock_quantity" class="epm-input" value="{{ old('stock_quantity', $product->stock_quantity) }}" min="0" required>
                </div>
                <div class="epm-group">
                  <label class="epm-label">Low Stock Alert</label>
                  <input type="number" name="low_stock_threshold" class="epm-input" value="{{ old('low_stock_threshold', $product->low_stock_threshold) }}" min="0">
                  <span class="epm-hint">Notify when stock drops below this</span>
                </div>
              </div>
            </div>
          </div>
        </div>

        {{-- TAB: IMAGES --}}
        <div class="epm-panel" id="tab-images">

          @if($product->images->count() > 0)
          <div class="epm-card">
            <div class="epm-card-header">
              <i class="fas fa-photo-video" style="color:#6f42c1;"></i>
              Current Images
              <span style="margin-left:auto;font-size:11px;color:var(--muted);font-weight:400;text-transform:none;">
                Hover image → ⭐ set primary &nbsp;|&nbsp; 🗑 delete
              </span>
            </div>
            <div class="epm-card-body">
              <div class="epm-images-grid" id="imagesGrid">
                @foreach($product->images as $image)
                @php $isPrimary = $image->is_primary; @endphp
                <div class="epm-img-card {{ $isPrimary ? 'is-primary' : '' }}"
                     id="img-card-{{ $image->id }}"
                     data-id="{{ $image->id }}">

                  <img src="{{ asset('storage/' . $image->image_path) }}" alt="Product image">

                  @if($isPrimary)
                  <div class="epm-primary-badge">
                    <i class="fas fa-star" style="font-size:8px;"></i> Primary
                  </div>
                  @endif

                  <div class="epm-img-actions">
                    <button type="button"
                            class="epm-img-action-btn epm-img-btn-primary"
                            title="Set as Primary"
                            onclick="setPrimary({{ $image->id }}, this)">
                      <i class="fas fa-star"></i>
                    </button>
                    <button type="button"
                            class="epm-img-action-btn epm-img-btn-delete"
                            title="Delete Image"
                            onclick="deleteImage({{ $image->id }}, this)">
                      <i class="fas fa-trash"></i>
                    </button>
                  </div>

                  <div class="epm-img-label">
                    {{ $isPrimary ? '⭐ Primary' : 'Click ⭐ to set primary' }}
                  </div>
                </div>
                @endforeach
              </div>
            </div>
          </div>
          @endif

          <div class="epm-card">
            <div class="epm-card-header"><i class="fas fa-upload" style="color:var(--blue);"></i> Upload New Images</div>
            <div class="epm-card-body">
              <div class="epm-upload" id="epmUploadArea">
                <input type="file" id="epmImages" name="images[]" style="display:none;" multiple accept="image/*">
                <label for="epmImages" class="epm-upload-label">
                  <i class="fas fa-cloud-upload-alt"></i>
                  <p>Click or drag to upload</p>
                  <small>PNG, JPG, WEBP up to 2MB — max 5 images</small>
                </label>
              </div>
              <div id="epmPreview" class="epm-preview-grid"></div>
            </div>
          </div>

        </div>

      </div>{{-- /epm-body --}}

      {{-- Footer --}}
      <div class="epm-footer">
        <a href="{{ route('admin.products.index') }}" class="epm-btn epm-btn-ghost">
          <i class="fas fa-times"></i> Cancel
        </a>
        <button type="submit" class="epm-btn epm-btn-primary" id="epmSubmit">
          <i class="fas fa-save"></i> Update Product
        </button>
      </div>

    </form>
  </div>
</div>

<script>
  // ── Tabs ──
  function switchTab(name) {
    const tabs = ['basic','specs','pricing','images'];
    document.querySelectorAll('.epm-tab').forEach((t, i) => t.classList.toggle('active', tabs[i] === name));
    document.querySelectorAll('.epm-panel').forEach(p => p.classList.remove('active'));
    document.getElementById('tab-' + name).classList.add('active');
  }

  // ── Slug from name ──
  document.getElementById('epmName').addEventListener('input', function() {
    const sf  = document.getElementById('epmSlug');
    const auto = this.value.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-+|-+$/g, '');
    if (!sf.value || sf.value === auto.substring(0, sf.value.length)) sf.value = auto;
  });

  // ── Set Primary Image ──
  function setPrimary(id, btn) {
    // Update hidden input
    document.getElementById('primaryImageInput').value = id;

    // Update UI: remove primary from all cards
    document.querySelectorAll('.epm-img-card').forEach(card => {
      card.classList.remove('is-primary');

      // Remove existing primary badge
      const badge = card.querySelector('.epm-primary-badge');
      if (badge) badge.remove();

      // Update label
      const label = card.querySelector('.epm-img-label');
      if (label) label.textContent = 'Click ⭐ to set primary';
    });

    // Mark selected card as primary
    const card = document.getElementById('img-card-' + id);
    if (card) {
      card.classList.add('is-primary');

      const badge = document.createElement('div');
      badge.className = 'epm-primary-badge';
      badge.innerHTML = '<i class="fas fa-star" style="font-size:8px;"></i> Primary';
      card.appendChild(badge);

      const label = card.querySelector('.epm-img-label');
      if (label) label.textContent = '⭐ Primary';
    }

    showToast('Primary image updated — save to apply', 'blue');
  }

  // ── Delete Image ──
  function deleteImage(id, btn) {
    if (!confirm('Delete this image?')) return;

    // Add hidden input to mark for deletion
    const existing = document.querySelector(`input[name="delete_images[]"][value="${id}"]`);
    if (!existing) {
      const inp = document.createElement('input');
      inp.type = 'hidden'; inp.name = 'delete_images[]'; inp.value = id;
      document.getElementById('epmForm').appendChild(inp);
    }

    // Mark card visually
    const card = document.getElementById('img-card-' + id);
    if (card) {
      card.classList.add('is-deleted');

      // Add red overlay
      const ov = document.createElement('div');
      ov.style.cssText = 'position:absolute;inset:0;background:rgba(220,53,69,.18);display:flex;align-items:center;justify-content:center;z-index:5;pointer-events:none;';
      ov.innerHTML = '<i class="fas fa-trash" style="color:#dc3545;font-size:20px;"></i>';
      card.appendChild(ov);

      // If deleted card was primary, auto-assign next available
      if (card.classList.contains('is-primary')) {
        const remaining = document.querySelectorAll('.epm-img-card:not(.is-deleted)');
        if (remaining.length > 0) {
          const nextId = remaining[0].dataset.id;
          setPrimary(nextId);
        } else {
          document.getElementById('primaryImageInput').value = '';
        }
      }
    }

    // Update badge count
    const deletedCount = document.querySelectorAll('input[name="delete_images[]"]').length;
    const totalCount   = {{ $product->images->count() }};
    const badge = document.getElementById('imgCountBadge');
    if (badge) badge.textContent = Math.max(0, totalCount - deletedCount);

    showToast('Image marked for deletion — save to apply', 'red');
  }

  // ── Toast notification ──
  function showToast(msg, color) {
    const colors = { blue: '#007bff', red: '#dc3545', green: '#28a745' };
    const t = document.createElement('div');
    t.style.cssText = `
      position:fixed; bottom:24px; right:24px; z-index:99999;
      background:${colors[color] || '#333'}; color:#fff;
      padding:10px 18px; border-radius:6px; font-size:13px;
      font-family:'DM Sans',sans-serif; font-weight:500;
      box-shadow:0 4px 16px rgba(0,0,0,.2);
      animation:toastIn .25s ease both;
    `;
    t.textContent = msg;
    document.body.appendChild(t);
    setTimeout(() => t.remove(), 3000);
  }

  // ── Image upload preview ──
  document.getElementById('epmImages').addEventListener('change', function() {
    const preview = document.getElementById('epmPreview');
    preview.innerHTML = '';
    const files = Array.from(this.files);
    if (files.length > 5) { alert('Maximum 5 images'); this.value = ''; return; }
    files.forEach(file => {
      if (!file.type.startsWith('image/')) return;
      if (file.size > 2 * 1024 * 1024) { alert(file.name + ' exceeds 2MB'); return; }
      const r = new FileReader();
      r.onload = e => {
        const d = document.createElement('div');
        d.className = 'epm-preview-item';
        d.innerHTML = `<img src="${e.target.result}"><span class="epm-new-badge">New</span>`;
        preview.appendChild(d);
      };
      r.readAsDataURL(file);
    });
  });

  // ── Drag & drop ──
  const ua = document.getElementById('epmUploadArea');
  ua.addEventListener('dragover', e => { e.preventDefault(); ua.style.borderColor = '#007bff'; });
  ua.addEventListener('dragleave', () => { ua.style.borderColor = '#ddd'; });
  ua.addEventListener('drop', e => {
    e.preventDefault(); ua.style.borderColor = '#ddd';
    document.getElementById('epmImages').files = e.dataTransfer.files;
    document.getElementById('epmImages').dispatchEvent(new Event('change'));
  });

  // ── Sale price validation ──
  document.getElementById('epmSalePrice').addEventListener('input', function() {
    const price = parseFloat(document.getElementById('epmPrice').value) || 0;
    const sale  = parseFloat(this.value) || 0;
    if (sale > 0 && sale >= price) { alert('Sale price must be less than regular price'); this.value = ''; }
  });

  // ── Submit state ──
  document.getElementById('epmForm').addEventListener('submit', function() {
    const btn = document.getElementById('epmSubmit');
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Updating...';
  });

  // ── ESC → back ──
  document.addEventListener('keydown', e => {
    if (e.key === 'Escape') window.location.href = '{{ route("admin.products.index") }}';
  });

  // ── Open correct tab on validation errors ──
  @if($errors->any())
    @if($errors->has('name') || $errors->has('category_id') || $errors->has('sku') || $errors->has('slug'))
      switchTab('basic');
    @elseif($errors->has('price') || $errors->has('stock_quantity'))
      switchTab('pricing');
    @elseif($errors->has('gender'))
      switchTab('specs');
    @endif
  @endif

  // ── Toast animation ──
  const style = document.createElement('style');
  style.textContent = '@keyframes toastIn { from { opacity:0; transform:translateY(8px); } to { opacity:1; transform:none; } }';
  document.head.appendChild(style);
</script>

@endsection