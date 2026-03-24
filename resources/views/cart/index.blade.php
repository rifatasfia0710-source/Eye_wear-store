{{-- resources/views/cart/index.blade.php --}}
@extends('layouts.home')

@section('content')

<style>
@import url('https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700;1,9..40,400&display=swap');

* { box-sizing: border-box; }

.cart-page {
    font-family: 'DM Sans', sans-serif;
    background: #f0f0f0;
    min-height: 100vh;
    padding: 50px 0 100px;
}

.cart-inner {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 32px;
}

/* Flash */
.flash {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 14px 20px;
    border-radius: 8px;
    font-size: 15px;
    font-weight: 500;
    margin-bottom: 24px;
}
.flash-success { background: #dcfce7; color: #166534; }
.flash-error   { background: #fee2e2; color: #991b1b; }

/* Page Title */
.cart-title {
    font-size: 28px;
    font-weight: 700;
    color: #111;
    margin-bottom: 32px;
    display: flex;
    align-items: center;
    gap: 10px;
    justify-content: center;
}
.cart-title i { font-size: 24px; }

/* Layout */
.cart-layout {
    display: grid;
    grid-template-columns: 1fr 380px;
    gap: 28px;
    align-items: start;
}
@media(max-width: 960px) {
    .cart-layout { grid-template-columns: 1fr; }
}

/* ═══════════════════════════════
   LEFT PANEL
═══════════════════════════════ */
.cart-left {
    background: #fff;
    border-radius: 6px;
    border: 1px solid #ddd;
    overflow: hidden;
}

/* Column Headers */
.cart-header-row {
    display: grid;
    grid-template-columns: 1fr 140px 170px 130px;
    padding: 16px 28px;
    border-bottom: 2px solid #e8e8e8;
    font-size: 13px;
    font-weight: 700;
    color: #444;
    text-transform: uppercase;
    letter-spacing: 0.8px;
    background: #fafafa;
}
.col-each, .col-qty  { text-align: center; }
.col-total           { text-align: right; }

/* Cart Item Row */
.cart-item-row {
    display: grid;
    grid-template-columns: 1fr 140px 170px 130px;
    padding: 28px 28px;
    border-bottom: 1px solid #efefef;
    align-items: center;
}
.cart-item-row:last-of-type { border-bottom: none; }

/* Product cell */
.item-cell {
    display: flex;
    align-items: flex-start;
    gap: 18px;
}
.item-img {
    width: 100px;
    height: 120px;
    object-fit: cover;
    border-radius: 6px;
    background: #f5f5f5;
    flex-shrink: 0;
    border: 1px solid #ebebeb;
}
.item-details { padding-top: 4px; }

.item-badge {
    display: inline-block;
    width: 10px;
    height: 10px;
    background: #e53935;
    border-radius: 50%;
    margin-bottom: 8px;
}

.item-name {
    font-size: 16px;
    font-weight: 600;
    color: #111;
    margin-bottom: 5px;
    line-height: 1.35;
}
.item-meta {
    font-size: 13px;
    color: #888;
    margin-bottom: 3px;
}
.item-stock {
    font-size: 13px;
    color: #2e7d32;
    font-weight: 600;
    margin-bottom: 14px;
}
.item-action-links {
    display: flex;
    align-items: center;
    font-size: 13px;
    flex-wrap: wrap;
}
.item-action-links a,
.item-action-links button {
    color: #555;
    text-decoration: none;
    background: none;
    border: none;
    cursor: pointer;
    font-size: 13px;
    font-family: 'DM Sans', sans-serif;
    padding: 0 10px;
    transition: color 0.15s;
    line-height: 1;
}
.item-action-links > *:first-child { padding-left: 0; }
.item-action-links a:hover { color: #111; text-decoration: underline; }
.item-action-links button:hover { color: #e53935; }
.item-action-links .sep {
    color: #ccc;
    font-size: 13px;
    user-select: none;
}

/* Price cell */
.price-cell {
    text-align: center;
    font-size: 17px;
    font-weight: 600;
    color: #111;
}

/* Qty cell */
.qty-cell {
    display: flex;
    justify-content: center;
}
.qty-select-wrap { position: relative; display: inline-block; }
.qty-select {
    appearance: none;
    -webkit-appearance: none;
    background: #fff;
    border: 1.5px solid #bbb;
    border-radius: 6px;
    padding: 10px 36px 10px 18px;
    font-size: 15px;
    font-family: 'DM Sans', sans-serif;
    color: #111;
    cursor: pointer;
    min-width: 80px;
    font-weight: 500;
}
.qty-select:focus { outline: none; border-color: #555; }
.qty-chevron {
    position: absolute;
    right: 12px;
    top: 50%;
    transform: translateY(-50%);
    pointer-events: none;
    font-size: 11px;
    color: #555;
}

/* Total cell */
.total-cell {
    text-align: right;
    font-size: 17px;
    font-weight: 700;
    color: #111;
}

/* Footer row */
.cart-footer-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 18px 28px;
    border-top: 2px solid #e8e8e8;
    background: #fafafa;
    font-size: 16px;
}
.cart-footer-count { font-weight: 600; color: #333; }
.cart-footer-total { font-weight: 700; color: #111; font-size: 18px; }

/* ═══════════════════════════════
   RIGHT PANEL
═══════════════════════════════ */
.cart-right { display: flex; flex-direction: column; gap: 18px; }

/* Promo Card */
.promo-card {
    background: #fff;
    border: 1px solid #ddd;
    border-radius: 6px;
    padding: 24px;
}
.promo-label {
    font-size: 12px;
    font-weight: 700;
    letter-spacing: 1.2px;
    text-transform: uppercase;
    color: #777;
    margin-bottom: 14px;
}
.promo-row { display: flex; gap: 10px; }
.promo-input {
    flex: 1;
    border: 1.5px solid #ccc;
    border-radius: 6px;
    padding: 13px 16px;
    font-size: 15px;
    font-family: 'DM Sans', sans-serif;
    color: #111;
    outline: none;
    transition: border-color 0.15s;
}
.promo-input::placeholder { color: #bbb; }
.promo-input:focus { border-color: #333; }
.promo-btn {
    padding: 13px 24px;
    background: #111;
    color: #fff;
    border: none;
    border-radius: 6px;
    font-family: 'DM Sans', sans-serif;
    font-size: 15px;
    font-weight: 700;
    cursor: pointer;
    transition: background 0.15s;
    white-space: nowrap;
}
.promo-btn:hover { background: #333; }

/* Summary Card */
.summary-card {
    background: #fff;
    border: 1px solid #ddd;
    border-radius: 6px;
    padding: 24px;
}
.summary-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px 0;
    font-size: 15px;
    color: #666;
    border-bottom: 1px solid #f0f0f0;
}
.summary-row:last-of-type { border-bottom: none; }
.summary-row .val { color: #111; font-weight: 500; }
.summary-row .val.tbd { color: #aaa; font-weight: 400; font-style: italic; }
.summary-row .val.discount { color: #e53935; font-weight: 600; }

.summary-divider {
    border: none;
    border-top: 1.5px solid #222;
    margin: 14px 0 12px;
}
.summary-total {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 4px;
}
.summary-total .label { font-size: 16px; font-weight: 700; color: #111; }
.summary-total .amount { font-size: 22px; font-weight: 700; color: #111; }

/* Afterpay */
.afterpay-note {
    font-size: 13px;
    color: #666;
    margin-top: 14px;
    display: flex;
    align-items: center;
    gap: 7px;
    flex-wrap: wrap;
    line-height: 1.6;
}
.afterpay-badge {
    background: #b2fce4;
    color: #000;
    font-weight: 700;
    font-size: 12px;
    padding: 3px 9px;
    border-radius: 4px;
    display: inline-flex;
    align-items: center;
    gap: 3px;
}
.info-icon {
    width: 17px; height: 17px;
    border-radius: 50%;
    border: 1.5px solid #aaa;
    color: #aaa;
    font-size: 10px;
    font-weight: 700;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    flex-shrink: 0;
}

/* Shipping progress */
.shipping-progress {
    background: #fff9e6;
    border: 1px solid #ffe082;
    border-radius: 6px;
    padding: 16px 20px;
    font-size: 14px;
    color: #555;
    line-height: 1.5;
}
.shipping-progress .highlight { color: #e53935; font-weight: 700; }
.progress-bar-wrap {
    background: #e0e0e0;
    border-radius: 99px;
    height: 6px;
    margin-top: 10px;
    overflow: hidden;
}
.progress-bar-fill {
    background: #e53935;
    height: 6px;
    border-radius: 99px;
    width: 80%;
}

/* Checkout btn */
.btn-checkout {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    width: 100%;
    padding: 18px;
    background: #96298dad;
    color: #111;
    border: none;
    border-radius: 6px;
    font-family: 'DM Sans', sans-serif;
    font-size: 17px;
    font-weight: 700;
    text-align: center;
    text-decoration: none;
    cursor: pointer;
    transition: background 0.15s, transform 0.15s;
    letter-spacing: 0.2px;
}
.btn-checkout:hover { background: #e6bb00; transform: translateY(-1px); color: #111; }

/* Clear Cart */
.btn-clear-cart {
    width: 100%;
    background: none;
    border: 1.5px solid #ddd;
    border-radius: 6px;
    padding: 13px;
    font-family: 'DM Sans', sans-serif;
    font-size: 14px;
    color: #888;
    cursor: pointer;
    transition: all 0.15s;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}
.btn-clear-cart:hover { border-color: #e53935; color: #e53935; }

/* Help Bubble */
.help-bubble {
    position: fixed;
    bottom: 32px;
    right: 32px;
    background: #43a047;
    color: white;
    border-radius: 50px;
    padding: 13px 22px;
    font-size: 15px;
    font-weight: 700;
    cursor: pointer;
    box-shadow: 0 6px 20px rgba(0,0,0,0.2);
    display: flex;
    align-items: center;
    gap: 8px;
    z-index: 999;
    transition: transform 0.15s, box-shadow 0.15s;
    font-family: 'DM Sans', sans-serif;
    border: none;
}
.help-bubble:hover { transform: translateY(-2px); box-shadow: 0 10px 28px rgba(0,0,0,0.25); }

/* Empty */
.empty-wrap {
    background: #fff;
    border-radius: 6px;
    border: 1px solid #ddd;
    padding: 100px 40px;
    text-align: center;
    grid-column: 1 / -1;
}
.empty-wrap h3 { font-size: 26px; font-weight: 700; color: #111; margin-bottom: 10px; }
.empty-wrap p { color: #888; margin-bottom: 28px; font-size: 16px; }
.btn-browse {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 14px 32px;
    background: #111;
    color: white;
    border-radius: 6px;
    text-decoration: none;
    font-size: 15px;
    font-weight: 600;
    transition: background 0.15s;
}
.btn-browse:hover { background: #333; color: white; }
</style>

<div class="cart-page">
    <div class="cart-inner">

        @if(session('success'))
            <div class="flash flash-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="flash flash-error"><i class="fas fa-exclamation-circle"></i> {{ session('error') }}</div>
        @endif

        <div class="cart-title">
            <i class="fas fa-shopping-bag"></i> My Cart
        </div>

        @if($cartItems->isEmpty())
        <div class="cart-layout">
            <div class="empty-wrap">
                <h3>Your cart is empty</h3>
                <p>Add some products and come back here.</p>
                <a href="{{ route('frontend.shop') }}" class="btn-browse">
                    <i class="fas fa-store"></i> Browse Products
                </a>
            </div>
        </div>

        @else

        <div class="cart-layout">

            {{-- ── LEFT: Items Table ── --}}
            <div class="cart-left">

                {{-- Column Headers --}}
                <div class="cart-header-row">
                    <div class="col-item">Item</div>
                    <div class="col-each">Each</div>
                    <div class="col-qty">Quantity</div>
                    <div class="col-total">Total</div>
                </div>

                {{-- Items --}}
                @foreach($cartItems as $item)
                @php $lineTotal = $item->product->price * $item->quantity; @endphp
                <div class="cart-item-row">

                    {{-- Product Info --}}
                    <div class="item-cell">
                        <img src="{{ asset('storage/' . $item->product->primary_image) }}"
                             class="item-img"
                             alt="{{ $item->product->name }}">
                        <div class="item-details">
                            <div class="item-badge"></div>
                            <div class="item-name">{{ $item->product->name }}</div>
                            @if($item->frame_color)
                                <div class="item-meta">Color: {{ $item->frame_color }}</div>
                            @endif
                            @if($item->lens_type)
                                <div class="item-meta">Lens: {{ $item->lens_type }}</div>
                            @endif
                            <div class="item-stock">In Stock</div>
                            <!-- <div class="item-action-links">
                                <a href="#">Edit</a>
                                <span class="sep">&nbsp;|&nbsp;</span>
                                <form action="{{ route('cart.destroy', $item->id) }}" method="POST" style="display:contents">
                                    @csrf @method('DELETE')
                                    <button type="submit" onclick="return confirm('Remove this item?')">Remove</button>
                                </form>
                                <span class="sep">&nbsp;|&nbsp;</span>
                                <a href="#">Move to Wishlist</a>
                                <span class="sep">&nbsp;|&nbsp;</span>
                                <a href="#">Save for Later</a>
                            </div> -->
                        </div>
                    </div>

                    {{-- Unit Price --}}
                    <div class="price-cell">৳{{ number_format($item->product->price, 2) }}</div>

                    {{-- Quantity Dropdown --}}
                    <div class="qty-cell">
                        <form action="{{ route('cart.update', $item->id) }}" method="POST" id="qtyform-{{ $item->id }}">
                            @csrf @method('PATCH')
                            <div class="qty-select-wrap">
                                <select name="quantity" class="qty-select"
                                        onchange="document.getElementById('qtyform-{{ $item->id }}').submit()">
                                    @for($q = 1; $q <= min($item->product->stock_quantity, 10); $q++)
                                        <option value="{{ $q }}" {{ $item->quantity == $q ? 'selected' : '' }}>{{ $q }}</option>
                                    @endfor
                                </select>
                                <span class="qty-chevron">▼</span>
                            </div>
                        </form>
                    </div>

                    {{-- Line Total --}}
                    <div class="total-cell">৳{{ number_format($lineTotal, 2) }}</div>

                </div>
                @endforeach

                {{-- Footer --}}
                <div class="cart-footer-row">
                    <span class="cart-footer-count">{{ $cartItems->count() }} {{ Str::plural('Item', $cartItems->count()) }}</span>
                    <span class="cart-footer-total">৳{{ number_format($total, 2) }}</span>
                </div>

            </div>

            {{-- ── RIGHT PANEL ── --}}
            <div class="cart-right">

                {{-- Promo Code --}}
                <!-- <div class="promo-card">
                    <div class="promo-label">Enter Promo Code</div>
                    <div class="promo-row">
                        <input type="text" class="promo-input" placeholder="Promo Code">
                        <button class="promo-btn">Submit</button>
                    </div>
                </div> -->

                {{-- Order Summary --}}
                <div class="summary-card">
                    <div class="summary-row">
                        <span>Shipping cost</span>
                        <span class="val tbd">BDT</span>
                    </div>
                    <div class="summary-row">
                        <span>Discount</span>
                        <span class="val discount">- ৳0</span>
                    </div>
                    <div class="summary-row">
                        <span>Tax</span>
                        <span class="val tbd"> BDT</span>
                    </div>

                    <hr class="summary-divider">

                    <div class="summary-total">
                        <span class="label">Estimated Total</span>
                        <span class="amount">৳{{ number_format($total, 2) }}</span>
                    </div>

                    <!-- <div class="afterpay-note">
                        or 4 interest-free payments of ৳{{ number_format($total / 4, 2) }} with
                        <span class="afterpay-badge">afterpay ›</span>
                        <span class="info-icon">i</span>
                    </div> -->
                </div>

                {{-- Free Shipping Progress --}}
                <!-- <div class="shipping-progress">
                    You're <span class="highlight">৳10.01</span> away from free shipping!
                    <div class="progress-bar-wrap">
                        <div class="progress-bar-fill"></div>
                    </div>
                </div> -->

                {{-- Checkout Button --}}
                <a href="{{ route('checkout.index') }}" class="btn-checkout">
                    <i class="fas fa-lock"></i> Checkout
                </a>

                {{-- Clear Cart --}}
                <form action="{{ route('cart.clear') }}" method="POST">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn-clear-cart"
                            onclick="return confirm('Clear entire cart?')">
                        <i class="fas fa-trash"></i> Clear Cart
                    </button>
                </form>

            </div>

        </div>
        @endif

    </div>
</div>


@endsection