@extends('layouts.admin')

@section('title', 'Add New Product')

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
    --purple: #6f42c1;
    --orange: #fd7e14;
    --bg:     #f1f3f6;
  }

  * { box-sizing: border-box; margin: 0; padding: 0; }

  .apm-overlay {
    position: fixed; inset: 0;
    background: rgba(10,10,12,.55);
    backdrop-filter: blur(5px);
    -webkit-backdrop-filter: blur(5px);
    z-index: 9999;
    display: flex; align-items: center; justify-content: center;
    padding: 16px;
    animation: apmFadeIn .25s ease both;
  }
  @keyframes apmFadeIn { from { opacity:0; } to { opacity:1; } }

  .apm-modal {
    background: var(--white);
    border-radius: 10px;
    width: 100%; max-width: 860px; max-height: 94vh;
    display: flex; flex-direction: column;
    overflow: hidden;
    box-shadow: 0 32px 80px rgba(0,0,0,.25);
    animation: apmSlideIn .32s cubic-bezier(.22,.68,0,1.15) both;
    font-family: 'DM Sans', sans-serif;
  }
  @keyframes apmSlideIn {
    from { opacity:0; transform: translateY(28px) scale(.96); }
    to   { opacity:1; transform: none; }
  }

  /* ── Header ── */
  .apm-header {
    display: flex; align-items: center; justify-content: space-between;
    padding: 18px 24px; border-bottom: 1px solid var(--border);
    flex-shrink: 0; background: var(--white);
  }
  .apm-header-left { display: flex; flex-direction: column; gap: 2px; }
  .apm-title { font-size: 17px; font-weight: 600; color: var(--ink); display: flex; align-items: center; gap: 8px; }
  .apm-subtitle { font-size: 12px; color: var(--muted); }
  .apm-close {
    width: 32px; height: 32px; border-radius: 50%;
    border: 1px solid var(--border); background: var(--white); color: var(--muted);
    font-size: 14px; cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    text-decoration: none; transition: all .2s; flex-shrink: 0; margin-left: 12px;
  }
  .apm-close:hover { border-color: var(--ink); color: var(--ink); }

  /* ── Tabs ── */
  .apm-tabs {
    display: flex; border-bottom: 1px solid var(--border);
    background: #fafafa; flex-shrink: 0; overflow-x: auto; padding: 0 24px;
  }
  .apm-tabs::-webkit-scrollbar { display: none; }
  .apm-tab {
    padding: 12px 18px; font-size: 12px; font-weight: 600;
    letter-spacing: .04em; color: var(--muted); cursor: pointer;
    border-bottom: 2px solid transparent; white-space: nowrap;
    transition: all .2s; user-select: none; display: flex; align-items: center; gap: 6px;
  }
  .apm-tab:hover { color: var(--ink); }
  .apm-tab.active { color: var(--blue); border-bottom-color: var(--blue); }
  .apm-tab.completed { color: var(--green); border-bottom-color: var(--green); }
  .apm-tab .tab-check { display: none; }
  .apm-tab.completed .tab-check { display: inline; }
  .apm-tab.completed .tab-icon { display: none; }

  /* ── Body ── */
  .apm-body { overflow-y: auto; flex: 1; padding: 24px; background: var(--bg); }

  .apm-panel { display: none; }
  .apm-panel.active {
    display: block;
    animation: panelIn .2s ease both;
  }
  @keyframes panelIn {
    from { opacity:0; transform: translateY(6px); }
    to   { opacity:1; transform: none; }
  }

  /* ── Cards ── */
  .apm-card {
    background: var(--white); border-radius: 8px;
    border: 1px solid #eee; overflow: hidden; margin-bottom: 16px;
  }
  .apm-card-header {
    padding: 13px 18px; border-bottom: 1px solid #f0f0f0; background: #f8f9fa;
    font-size: 12px; font-weight: 600; color: #444;
    display: flex; align-items: center; gap: 7px;
    text-transform: uppercase; letter-spacing: .05em;
  }
  .apm-card-body { padding: 20px 18px; }

  /* ── Form Controls ── */
  .apm-row   { display: grid; grid-template-columns: repeat(2, 1fr); gap: 14px; }
  .apm-row-3 { grid-template-columns: repeat(3, 1fr); }
  .apm-group { margin-bottom: 14px; }
  .apm-group:last-child { margin-bottom: 0; }
  .apm-label {
    display: block; margin-bottom: 5px;
    font-size: 11px; font-weight: 600; color: #555;
    text-transform: uppercase; letter-spacing: .05em;
  }
  .apm-label .req { color: var(--red); }
  .apm-input, .apm-select, .apm-textarea {
    width: 100%; padding: 9px 12px; border: 1px solid #ddd; border-radius: 5px;
    font-family: 'DM Sans', sans-serif; font-size: 13px; color: var(--ink);
    background: var(--white); transition: border-color .2s, box-shadow .2s; outline: none;
  }
  .apm-input:focus, .apm-select:focus, .apm-textarea:focus {
    border-color: var(--blue); box-shadow: 0 0 0 3px rgba(0,123,255,.08);
  }
  .apm-input.is-invalid, .apm-select.is-invalid { border-color: var(--red); box-shadow: 0 0 0 3px rgba(220,53,69,.08); }
  .apm-textarea { resize: vertical; min-height: 80px; }
  .apm-select {
    appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath d='M1 1l5 5 5-5' stroke='%236b6560' stroke-width='1.5' fill='none' stroke-linecap='round'/%3E%3C/svg%3E");
    background-repeat: no-repeat; background-position: right 12px center;
    padding-right: 32px; cursor: pointer;
  }
  .apm-hint  { display: block; margin-top: 4px; font-size: 11px; color: var(--muted); }

  /* ── Measurements ── */
  .apm-meas-grid { display: grid; grid-template-columns: repeat(5, 1fr); gap: 10px; }
  .apm-meas-grid .apm-group { margin-bottom: 0; }
  .apm-meas-grid .apm-label { font-size: 10px; }

  /* ── Image Upload ── */
  .apm-upload { border: 2px dashed #ddd; border-radius: 6px; transition: border-color .2s; }
  .apm-upload:hover { border-color: var(--blue); }
  .apm-upload-label {
    display: flex; flex-direction: column; align-items: center;
    padding: 28px 16px; cursor: pointer; color: var(--muted); text-align: center;
  }
  .apm-upload-label i    { font-size: 28px; margin-bottom: 8px; color: #adb5bd; }
  .apm-upload-label p    { font-weight: 600; font-size: 13px; margin: 0 0 2px; color: #333; }
  .apm-upload-label small { font-size: 11px; }
  .apm-preview-grid {
    display: grid; grid-template-columns: repeat(auto-fill, minmax(90px, 1fr));
    gap: 10px; margin-top: 12px;
  }
  .apm-preview-item {
    position: relative; aspect-ratio: 1;
    border: 2px solid #ddd; border-radius: 6px; overflow: hidden;
  }
  .apm-preview-item img { width:100%; height:100%; object-fit:cover; display:block; }
  .apm-primary-img-badge {
    position: absolute; top: 5px; left: 5px;
    background: var(--blue); color: #fff;
    font-size: 9px; font-weight: 700; padding: 2px 6px; border-radius: 8px;
  }

  /* ── Review Panel ── */
  .apm-review-summary {
    display: grid; grid-template-columns: repeat(2, 1fr); gap: 12px;
    margin-bottom: 16px;
  }
  .apm-review-card {
    background: var(--white); border-radius: 8px;
    border: 1px solid #eee; padding: 14px 16px;
  }
  .apm-review-card-title {
    font-size: 10px; font-weight: 600; color: var(--muted);
    text-transform: uppercase; letter-spacing: .05em;
    margin-bottom: 10px; display: flex; align-items: center; gap: 6px;
  }
  .apm-review-row {
    display: flex; justify-content: space-between; align-items: center;
    padding: 5px 0; border-bottom: 1px solid #f5f5f5; font-size: 13px;
  }
  .apm-review-row:last-child { border-bottom: none; }
  .apm-review-key   { color: var(--muted); font-size: 12px; }
  .apm-review-val   { font-weight: 600; color: var(--ink); }
  .apm-review-empty { color: #ccc; font-style: italic; font-weight: 400; }

  .apm-status-badge {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 3px 10px; border-radius: 12px; font-size: 11px; font-weight: 700;
  }
  .apm-status-active   { background: #d4edda; color: #155724; }
  .apm-status-inactive { background: #fff3cd; color: #856404; }

  /* ── Alert ── */
  .apm-alert {
    display: flex; align-items: flex-start; gap: 10px;
    padding: 12px 16px; border-radius: 6px; margin-bottom: 16px;
    border-left: 4px solid; font-size: 13px;
  }
  .apm-alert-info   { background: #e8f4fd; border-color: var(--blue);  color: #0c5460; }
  .apm-alert-danger { background: #f8d7da; border-color: var(--red);   color: #721c24; }
  .apm-alert i { font-size: 16px; flex-shrink: 0; margin-top: 1px; }
  .apm-alert ul { margin: 4px 0 0; padding-left: 16px; font-size: 12px; }

  /* ── Footer ── */
  .apm-footer {
    padding: 16px 24px; border-top: 1px solid var(--border);
    display: flex; justify-content: space-between; align-items: center;
    flex-shrink: 0; background: var(--white); gap: 10px;
  }
  .apm-footer-right { display: flex; align-items: center; gap: 8px; margin-left: auto; }

  .apm-btn {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 9px 20px; border-radius: 5px; border: none;
    font-family: 'DM Sans', sans-serif; font-size: 13px; font-weight: 600;
    cursor: pointer; text-decoration: none; transition: all .2s; letter-spacing: .02em;
  }
  .apm-btn-primary { background: var(--blue);  color: #fff; }
  .apm-btn-primary:hover { background: #0056b3; }
  .apm-btn-success { background: var(--green); color: #fff; }
  .apm-btn-success:hover { background: #1e7e34; }
  .apm-btn-ghost { background: none; color: var(--muted); border: 1px solid var(--border); }
  .apm-btn-ghost:hover { border-color: var(--ink); color: var(--ink); }

  /* ── Step Progress Dots ── */
  .apm-step-dots {
    display: flex; align-items: center; gap: 6px;
  }
  .apm-dot {
    width: 7px; height: 7px; border-radius: 50%;
    background: #ddd; transition: all .3s;
  }
  .apm-dot.active   { background: var(--blue); transform: scale(1.3); }
  .apm-dot.done     { background: var(--green); }

  @media (max-width: 640px) {
    .apm-overlay { padding: 0; align-items: flex-end; }
    .apm-modal   { max-height: 97vh; border-radius: 12px 12px 0 0; }
    .apm-row     { grid-template-columns: 1fr; }
    .apm-row-3   { grid-template-columns: 1fr 1fr; }
    .apm-meas-grid { grid-template-columns: repeat(2, 1fr); }
    .apm-review-summary { grid-template-columns: 1fr; }
  }
</style>

<div style="position:fixed;inset:0;background:#eef0f4;z-index:-1;"></div>

<div class="apm-overlay">
  <div class="apm-modal">

    {{-- Header --}}
    <div class="apm-header">
      <div class="apm-header-left">
        <div class="apm-title">
          <i class="fas fa-plus-circle" style="color:var(--blue);font-size:14px;"></i>
          Add New Product
        </div>
        <div class="apm-subtitle">Fill in the details below to create a new product listing</div>
      </div>
      <div style="display:flex;align-items:center;gap:10px;">
        <div class="apm-step-dots" id="stepDots">
          <div class="apm-dot active" id="dot-1"></div>
          <div class="apm-dot" id="dot-2"></div>
          <div class="apm-dot" id="dot-3"></div>
          <div class="apm-dot" id="dot-4"></div>
        </div>
        <a href="{{ route('admin.products.index') }}" class="apm-close" title="Close">✕</a>
      </div>
    </div>

    {{-- Tabs --}}
    <div class="apm-tabs" id="apmTabs">
      <div class="apm-tab active" data-tab="basic" onclick="switchTab('basic', 1)">
        <i class="fas fa-info-circle tab-icon"></i>
        <i class="fas fa-check-circle tab-check"></i>
        Basic Info
      </div>
      <div class="apm-tab" data-tab="specs" onclick="switchTab('specs', 2)">
        <i class="fas fa-glasses tab-icon"></i>
        <i class="fas fa-check-circle tab-check"></i>
        Specifications
      </div>
      <div class="apm-tab" data-tab="pricing" onclick="switchTab('pricing', 3)">
        <i class="fas fa-tag tab-icon"></i>
        <i class="fas fa-check-circle tab-check"></i>
        Pricing & Images
      </div>
      <div class="apm-tab" data-tab="review" onclick="switchTab('review', 4)">
        <i class="fas fa-clipboard-check tab-icon"></i>
        Review
      </div>
    </div>

    {{-- Form --}}
    <form action="{{ route('admin.products.store') }}" method="POST"
          enctype="multipart/form-data" id="apmForm">
      @csrf

      <div class="apm-body">

        @if($errors->any())
        <div class="apm-alert apm-alert-danger">
          <i class="fas fa-exclamation-circle"></i>
          <div>
            <strong>Please fix the following errors:</strong>
            <ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
          </div>
        </div>
        @endif

        {{-- TAB: BASIC INFO --}}
        <div class="apm-panel active" id="tab-basic">
          <div class="apm-card">
            <div class="apm-card-header">
              <i class="fas fa-tag" style="color:var(--blue);"></i> Product Details
            </div>
            <div class="apm-card-body">
              <div class="apm-group">
                <label class="apm-label">Product Name <span class="req">*</span></label>
                <input type="text" id="apmName" name="name"
                       class="apm-input @error('name') is-invalid @enderror"
                       value="{{ old('name') }}" placeholder="Enter product name" required>
              </div>
              <div class="apm-row">
                <div class="apm-group">
                  <label class="apm-label">Category <span class="req">*</span></label>
                  <select id="apmCategory" name="category_id" class="apm-select" required>
                    <option value="">-- Select Category --</option>
                    @foreach($categories as $category)
                      <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                      </option>
                    @endforeach
                  </select>
                </div>
                <div class="apm-group">
                  <label class="apm-label">Brand <span class="req">*</span></label>
                  <select id="apmBrand" name="brand_id" class="apm-select" required>
                    <option value="">-- Select Brand --</option>
                    @foreach($brands as $brand)
                      <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>
                        {{ $brand->name }}
                      </option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="apm-row">
                <div class="apm-group">
                  <label class="apm-label">SKU <span class="req">*</span></label>
                  <input type="text" id="apmSku" name="sku" class="apm-input"
                         value="{{ old('sku') }}" placeholder="Auto-generated" required>
                  <span class="apm-hint">Auto-generated from product name</span>
                </div>
                <div class="apm-group">
                  <label class="apm-label">URL Slug <span class="req">*</span></label>
                  <input type="text" id="apmSlug" name="slug" class="apm-input"
                         value="{{ old('slug') }}" placeholder="Auto-generated" required>
                  <span class="apm-hint">Auto-generated from product name</span>
                </div>
              </div>
              <div class="apm-group">
                <label class="apm-label">Short Description</label>
                <textarea name="short_description" class="apm-textarea" rows="2"
                          placeholder="Brief description (max 500 characters)">{{ old('short_description') }}</textarea>
              </div>
              <div class="apm-group" style="margin-bottom:0;">
                <label class="apm-label">Full Description</label>
                <textarea name="description" class="apm-textarea" rows="4"
                          placeholder="Detailed product description">{{ old('description') }}</textarea>
              </div>
            </div>
          </div>
        </div>

        {{-- TAB: SPECS --}}
        <div class="apm-panel" id="tab-specs">
          <div class="apm-card">
            <div class="apm-card-header">
              <i class="fas fa-glasses" style="color:var(--purple);"></i> Frame & Lens
            </div>
            <div class="apm-card-body">
              <div class="apm-row apm-row-3">
                <div class="apm-group">
                  <label class="apm-label">Frame Shape</label>
                  <select name="frame_shape" class="apm-select">
                    <option value="">-- Select --</option>
                    @foreach(['Round','Square','Rectangle','Cat-Eye','Aviator','Wayfarer','Oval'] as $s)
                      <option value="{{ $s }}" {{ old('frame_shape') == $s ? 'selected' : '' }}>{{ $s }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="apm-group">
                  <label class="apm-label">Frame Material</label>
                  <select name="frame_material" class="apm-select">
                    <option value="">-- Select --</option>
                    @foreach(['Acetate','Metal','Plastic','Titanium','Wood'] as $m)
                      <option value="{{ $m }}" {{ old('frame_material') == $m ? 'selected' : '' }}>{{ $m }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="apm-group">
                  <label class="apm-label">Frame Color</label>
                  <input type="text" name="frame_color" class="apm-input"
                         value="{{ old('frame_color') }}" placeholder="e.g. Black, Tortoise">
                </div>
                <div class="apm-group">
                  <label class="apm-label">Rim Type</label>
                  <select name="frame_type" class="apm-select">
                    <option value="">-- Select --</option>
                    @foreach(['Full-rim','Semi-rimless','Rimless'] as $r)
                      <option value="{{ $r }}" {{ old('frame_type') == $r ? 'selected' : '' }}>{{ $r }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="apm-group">
                  <label class="apm-label">Lens Type</label>
                  <select name="lens_type" class="apm-select">
                    <option value="">-- Select --</option>
                    @foreach(['Single Vision','Bifocal','Progressive','Reading','Sunglasses','Blue Light'] as $l)
                      <option value="{{ $l }}" {{ old('lens_type') == $l ? 'selected' : '' }}>{{ $l }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="apm-group">
                  <label class="apm-label">Gender <span class="req">*</span></label>
                  <select name="gender" id="apmGender" class="apm-select" required>
                    @foreach(['Unisex','Men','Women','Kids'] as $g)
                      <option value="{{ $g }}" {{ old('gender', 'Unisex') == $g ? 'selected' : '' }}>{{ $g }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
            </div>
          </div>
          <div class="apm-card">
            <div class="apm-card-header">
              <i class="fas fa-ruler-combined" style="color:var(--purple);"></i> Measurements (mm)
            </div>
            <div class="apm-card-body">
              <div class="apm-meas-grid">
                @foreach(['lens_width'=>'Lens Width','bridge_width'=>'Bridge Width','temple_length'=>'Temple Length','lens_height'=>'Lens Height','frame_width'=>'Frame Width'] as $field => $label)
                <div class="apm-group">
                  <label class="apm-label">{{ $label }}</label>
                  <input type="number" name="{{ $field }}" class="apm-input"
                         value="{{ old($field) }}" placeholder="mm">
                </div>
                @endforeach
              </div>
            </div>
          </div>
        </div>

        {{-- TAB: PRICING & IMAGES --}}
        <div class="apm-panel" id="tab-pricing">
          <div class="apm-card">
            <div class="apm-card-header">
              <i class="fas fa-dollar-sign" style="color:var(--green);"></i> Pricing
            </div>
            <div class="apm-card-body">
              <div class="apm-row apm-row-3">
                <div class="apm-group">
                  <label class="apm-label">Regular Price (৳) <span class="req">*</span></label>
                  <input type="number" id="apmPrice" name="price" class="apm-input"
                         step="0.01" min="0" value="{{ old('price') }}" placeholder="৳ 0.00" required>
                </div>
                <div class="apm-group">
                  <label class="apm-label">Sale Price (৳)</label>
                  <input type="number" id="apmSalePrice" name="sale_price" class="apm-input"
                         step="0.01" min="0" value="{{ old('sale_price') }}" placeholder="৳ 0.00">
                  <span class="apm-hint">Must be less than regular price</span>
                </div>
                <div class="apm-group">
                  <label class="apm-label">Stock Quantity <span class="req">*</span></label>
                  <input type="number" id="apmStock" name="stock_quantity" class="apm-input"
                         min="0" value="{{ old('stock_quantity', 0) }}" required>
                </div>
              </div>
            </div>
          </div>
          <div class="apm-card">
            <div class="apm-card-header">
              <i class="fas fa-images" style="color:var(--purple);"></i> Product Images
              <span style="margin-left:auto;font-size:11px;color:var(--muted);font-weight:400;text-transform:none;">
                Optional — PNG, JPG, WEBP up to 2MB — max 5 images
              </span>
            </div>
            <div class="apm-card-body">
              <div class="apm-upload" id="apmUploadArea">
                <input type="file" id="apmImages" name="images[]" style="display:none;" multiple accept="image/*">
                <label for="apmImages" class="apm-upload-label">
                  <i class="fas fa-cloud-upload-alt"></i>
                  <p>Click or drag to upload</p>
                  <small>First image will be set as primary</small>
                </label>
              </div>
              <div id="apmPreview" class="apm-preview-grid"></div>
            </div>
          </div>
        </div>

        {{-- TAB: REVIEW --}}
        <div class="apm-panel" id="tab-review">

          <div class="apm-alert apm-alert-info">
            <i class="fas fa-info-circle"></i>
            <div style="font-size:13px;">
              Review all details before creating the product. You can go back to any tab to make changes.
            </div>
          </div>

          <div class="apm-review-summary">
            <div class="apm-review-card">
              <div class="apm-review-card-title">
                <i class="fas fa-tag" style="color:var(--blue);"></i> Basic Info
              </div>
              <div class="apm-review-row">
                <span class="apm-review-key">Name</span>
                <span class="apm-review-val" id="rv-name">—</span>
              </div>
              <div class="apm-review-row">
                <span class="apm-review-key">Category</span>
                <span class="apm-review-val" id="rv-category">—</span>
              </div>
              <div class="apm-review-row">
                <span class="apm-review-key">Brand</span>
                <span class="apm-review-val" id="rv-brand">—</span>
              </div>
              <div class="apm-review-row">
                <span class="apm-review-key">SKU</span>
                <span class="apm-review-val" id="rv-sku">—</span>
              </div>
            </div>
            <div class="apm-review-card">
              <div class="apm-review-card-title">
                <i class="fas fa-dollar-sign" style="color:var(--green);"></i> Pricing & Stock
              </div>
              <div class="apm-review-row">
                <span class="apm-review-key">Regular Price</span>
                <span class="apm-review-val" id="rv-price">—</span>
              </div>
              <div class="apm-review-row">
                <span class="apm-review-key">Sale Price</span>
                <span class="apm-review-val" id="rv-sale">—</span>
              </div>
              <div class="apm-review-row">
                <span class="apm-review-key">Stock</span>
                <span class="apm-review-val" id="rv-stock">—</span>
              </div>
              <div class="apm-review-row">
                <span class="apm-review-key">Images</span>
                <span class="apm-review-val" id="rv-images">—</span>
              </div>
            </div>
            <div class="apm-review-card">
              <div class="apm-review-card-title">
                <i class="fas fa-glasses" style="color:var(--purple);"></i> Specifications
              </div>
              <div class="apm-review-row">
                <span class="apm-review-key">Frame Shape</span>
                <span class="apm-review-val" id="rv-shape">—</span>
              </div>
              <div class="apm-review-row">
                <span class="apm-review-key">Frame Material</span>
                <span class="apm-review-val" id="rv-material">—</span>
              </div>
              <div class="apm-review-row">
                <span class="apm-review-key">Lens Type</span>
                <span class="apm-review-val" id="rv-lens">—</span>
              </div>
              <div class="apm-review-row">
                <span class="apm-review-key">Gender</span>
                <span class="apm-review-val" id="rv-gender">—</span>
              </div>
            </div>
            <div class="apm-review-card">
              <div class="apm-review-card-title">
                <i class="fas fa-cog" style="color:var(--orange);"></i> Status
              </div>
              <div class="apm-group" style="margin-bottom:0;">
                <label class="apm-label">Product Status <span class="req">*</span></label>
                <select name="status" id="apmStatus" class="apm-select" required>
                  <option value="active"       {{ old('status') == 'active'       ? 'selected' : '' }}>Active</option>
                  <option value="inactive"     {{ old('status') == 'inactive'     ? 'selected' : '' }}>Inactive</option>
                  <option value="out_of_stock" {{ old('status') == 'out_of_stock' ? 'selected' : '' }}>Out of Stock</option>
                </select>
              </div>
            </div>
          </div>

        </div>

      </div>{{-- /apm-body --}}

      {{-- Footer --}}
      <div class="apm-footer">
        <button type="button" id="apmPrevBtn" class="apm-btn apm-btn-ghost" style="display:none;"
                onclick="navigate(-1)">
          <i class="fas fa-arrow-left"></i> Previous
        </button>
        <div class="apm-footer-right">
          <a href="{{ route('admin.products.index') }}" class="apm-btn apm-btn-ghost">
            <i class="fas fa-times"></i> Cancel
          </a>
          <button type="button" id="apmNextBtn" class="apm-btn apm-btn-primary"
                  onclick="navigate(1)">
            Next <i class="fas fa-arrow-right"></i>
          </button>
          <button type="submit" id="apmSubmitBtn" class="apm-btn apm-btn-success" style="display:none;">
            <i class="fas fa-save"></i> Create Product
          </button>
        </div>
      </div>

    </form>
  </div>
</div>

<script>
  const tabOrder = ['basic', 'specs', 'pricing', 'review'];
  let currentTabIndex = 0;

  // ── Auto-generate slug & SKU ──
  document.getElementById('apmName').addEventListener('input', function() {
    const val = this.value;
    const slug = val.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-+|-+$/g, '');
    const sku  = 'SKU-' + val.toUpperCase().replace(/[^A-Z0-9]/g, '-').substring(0, 15);
    document.getElementById('apmSlug').value = slug;
    document.getElementById('apmSku').value  = sku;
  });

  // ── Tab switching ──
  function switchTab(name, dotIndex) {
    tabOrder.forEach((t, i) => {
      const tabEl = document.querySelector(`.apm-tab[data-tab="${t}"]`);
      const panelEl = document.getElementById('tab-' + t);
      const dotEl = document.getElementById('dot-' + (i + 1));

      tabEl.classList.remove('active', 'completed');
      panelEl.classList.remove('active');

      const idx = tabOrder.indexOf(name);
      if (i < idx) tabEl.classList.add('completed');
      if (t === name) { tabEl.classList.add('active'); panelEl.classList.add('active'); }

      if (dotEl) {
        dotEl.classList.remove('active', 'done');
        if (i < idx)  dotEl.classList.add('done');
        if (i === idx) dotEl.classList.add('active');
      }
    });

    currentTabIndex = tabOrder.indexOf(name);
    document.getElementById('apmPrevBtn').style.display   = currentTabIndex === 0 ? 'none' : 'inline-flex';
    document.getElementById('apmNextBtn').style.display   = currentTabIndex === tabOrder.length - 1 ? 'none' : 'inline-flex';
    document.getElementById('apmSubmitBtn').style.display = currentTabIndex === tabOrder.length - 1 ? 'inline-flex' : 'none';

    if (name === 'review') populateReview();
  }

  // ── Navigate next/prev ──
  function navigate(dir) {
    if (dir === 1 && !validateCurrentTab()) return;
    const newIndex = currentTabIndex + dir;
    if (newIndex < 0 || newIndex >= tabOrder.length) return;
    switchTab(tabOrder[newIndex], newIndex + 1);
  }

  // ── Validation ──
  function validateCurrentTab() {
    const panelId = 'tab-' + tabOrder[currentTabIndex];
    const panel   = document.getElementById(panelId);
    let valid = true;

    panel.querySelectorAll('[required]').forEach(field => {
      field.classList.remove('is-invalid');
      if (!field.value.trim()) {
        field.classList.add('is-invalid');
        if (valid) field.focus();
        valid = false;
      }
    });

    if (!valid) showToast('Please fill in all required fields ✱', 'red');
    return valid;
  }

  // ── Populate Review ──
  function populateReview() {
    const val = (id) => {
      const el = document.getElementById(id);
      if (!el) return null;
      if (el.tagName === 'SELECT') return el.options[el.selectedIndex]?.text || '';
      return el.value || '';
    };

    const setReview = (id, text, fallback = '—') => {
      const el = document.getElementById(id);
      if (el) {
        el.textContent = text || fallback;
        el.className = 'apm-review-val' + (text ? '' : ' apm-review-empty');
      }
    };

    setReview('rv-name',     val('apmName'));
    setReview('rv-category', document.getElementById('apmCategory')?.options[document.getElementById('apmCategory').selectedIndex]?.text);
    setReview('rv-brand',    document.getElementById('apmBrand')?.options[document.getElementById('apmBrand').selectedIndex]?.text);
    setReview('rv-sku',      val('apmSku'));

    const price = parseFloat(document.getElementById('apmPrice')?.value || 0);
    const sale  = parseFloat(document.getElementById('apmSalePrice')?.value || 0);
    setReview('rv-price',    price > 0 ? '৳' + price.toFixed(2) : null);
    setReview('rv-sale',     sale  > 0 ? '৳' + sale.toFixed(2)  : 'No sale');
    setReview('rv-stock',    val('apmStock') + ' units');

    const imgCount = document.getElementById('apmImages')?.files?.length || 0;
    setReview('rv-images', imgCount > 0 ? imgCount + ' image(s) selected' : 'No images');

    // Specs from selects (no IDs — query by name)
    const byName = (name) => {
      const el = document.querySelector(`[name="${name}"]`);
      if (!el) return '';
      if (el.tagName === 'SELECT') return el.options[el.selectedIndex]?.text || '';
      return el.value || '';
    };
    setReview('rv-shape',    byName('frame_shape'));
    setReview('rv-material', byName('frame_material'));
    setReview('rv-lens',     byName('lens_type'));
    setReview('rv-gender',   byName('gender'));
  }

  // ── Image upload preview ──
  document.getElementById('apmImages').addEventListener('change', function() {
    const preview = document.getElementById('apmPreview');
    preview.innerHTML = '';
    const files = Array.from(this.files);
    if (files.length > 5) { alert('Maximum 5 images allowed'); this.value = ''; return; }
    files.forEach((file, index) => {
      if (!file.type.startsWith('image/')) return;
      if (file.size > 2 * 1024 * 1024) { alert(file.name + ' exceeds 2MB'); return; }
      const r = new FileReader();
      r.onload = e => {
        const d = document.createElement('div');
        d.className = 'apm-preview-item';
        d.innerHTML = `
          <img src="${e.target.result}" alt="Preview">
          ${index === 0 ? '<span class="apm-primary-img-badge">Primary</span>' : ''}
        `;
        preview.appendChild(d);
      };
      r.readAsDataURL(file);
    });
  });

  // ── Drag & drop ──
  const ua = document.getElementById('apmUploadArea');
  ua.addEventListener('dragover', e => { e.preventDefault(); ua.style.borderColor = '#007bff'; });
  ua.addEventListener('dragleave', () => { ua.style.borderColor = '#ddd'; });
  ua.addEventListener('drop', e => {
    e.preventDefault(); ua.style.borderColor = '#ddd';
    document.getElementById('apmImages').files = e.dataTransfer.files;
    document.getElementById('apmImages').dispatchEvent(new Event('change'));
  });

  // ── Sale price validation ──
  document.getElementById('apmSalePrice').addEventListener('input', function() {
    const price = parseFloat(document.getElementById('apmPrice').value) || 0;
    const sale  = parseFloat(this.value) || 0;
    if (sale > 0 && sale >= price) {
      showToast('Sale price must be less than regular price', 'red');
      this.value = '';
    }
  });

  // ── Submit state ──
  document.getElementById('apmForm').addEventListener('submit', function() {
    const btn = document.getElementById('apmSubmitBtn');
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Creating...';
  });

  // ── ESC → back ──
  document.addEventListener('keydown', e => {
    if (e.key === 'Escape') window.location.href = '{{ route("admin.products.index") }}';
  });

  // ── Toast ──
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

  // ── Toast animation ──
  const style = document.createElement('style');
  style.textContent = '@keyframes toastIn { from { opacity:0; transform:translateY(8px); } to { opacity:1; transform:none; } }';
  document.head.appendChild(style);

  // ── Open correct tab on validation errors from server ──
  @if($errors->any())
    @if($errors->has('name') || $errors->has('category_id') || $errors->has('brand_id') || $errors->has('sku') || $errors->has('slug'))
      switchTab('basic', 1);
    @elseif($errors->has('price') || $errors->has('stock_quantity'))
      switchTab('pricing', 3);
    @elseif($errors->has('gender'))
      switchTab('specs', 2);
    @endif
  @endif
</script>

@endsection