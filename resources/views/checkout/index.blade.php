{{-- resources/views/checkout/index.blade.php --}}
@extends('layouts.home')

@section('content')

<style>
@import url('https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=DM+Sans:wght@300;400;500;600;700&display=swap');

:root {
    --bg: #f7f6f3;
    --white: #ffffff;
    --dark: #1c1c1e;
    --text: #3a3a3c;
    --muted: #8a8a8e;
    --border: #e5e4e0;
    --accent: #22c55e;
    --accent-dark: #16a34a;
    --danger: #ef4444;
    --radius: 14px;
    --shadow: 0 2px 16px rgba(0,0,0,.07);
}

*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

body { background: var(--bg); }

.co-page {
    font-family: 'DM Sans', sans-serif;
    background: var(--bg);
    min-height: 100vh;
    padding: 40px 24px 80px;
}

.co-container {
    max-width: 1080px;
    margin: 0 auto;
}

/* Back */
.co-back {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 14px;
    font-weight: 500;
    color: var(--muted);
    text-decoration: none;
    margin-bottom: 32px;
    transition: color .2s;
}
.co-back:hover { color: var(--dark); }
.co-back svg { width: 16px; height: 16px; }

/* Grid */
.co-grid {
    display: grid;
    grid-template-columns: 1fr 380px;
    gap: 24px;
    align-items: start;
}
@media (max-width: 860px) {
    .co-grid { grid-template-columns: 1fr; }
}

/* Panel */
.panel {
    background: var(--white);
    border-radius: var(--radius);
    padding: 28px;
    box-shadow: var(--shadow);
}

.panel-title {
    font-family: 'DM Serif Display', serif;
    font-size: 1.45rem;
    color: var(--dark);
    margin-bottom: 20px;
}

/* Cart Table */
.cart-header {
    display: grid;
    grid-template-columns: 2fr 80px 100px 100px 36px;
    gap: 8px;
    padding: 0 0 12px;
    border-bottom: 1px solid var(--border);
    font-size: 12px;
    font-weight: 600;
    letter-spacing: .5px;
    text-transform: uppercase;
    color: var(--muted);
}

.cart-row {
    display: grid;
    grid-template-columns: 2fr 80px 100px 100px 36px;
    gap: 8px;
    align-items: center;
    padding: 16px 0;
    border-bottom: 1px solid var(--border);
}
.cart-row:last-of-type { border-bottom: none; }

.cart-product {
    display: flex;
    align-items: center;
    gap: 14px;
}
.cart-img {
    width: 52px;
    height: 52px;
    border-radius: 10px;
    object-fit: cover;
    background: var(--bg);
    flex-shrink: 0;
}
.cart-name { font-size: 14px; font-weight: 600; color: var(--dark); margin-bottom: 2px; }
.cart-sub  { font-size: 12px; color: var(--muted); }

/* Size Select */
.size-sel {
    appearance: none;
    -webkit-appearance: none;
    background: var(--bg) url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6'%3E%3Cpath d='M0 0l5 6 5-6z' fill='%238a8a8e'/%3E%3C/svg%3E") no-repeat right 8px center;
    border: 1.5px solid var(--border);
    border-radius: 8px;
    padding: 6px 24px 6px 10px;
    font-family: 'DM Sans', sans-serif;
    font-size: 13px;
    font-weight: 500;
    color: var(--dark);
    cursor: pointer;
    transition: border-color .2s;
    width: 72px;
}
.size-sel:focus { outline: none; border-color: var(--dark); }

/* Qty */
.qty-ctrl {
    display: flex;
    align-items: center;
    gap: 6px;
}
.qty-btn {
    width: 26px; height: 26px;
    border: 1.5px solid var(--border);
    border-radius: 6px;
    background: var(--bg);
    cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    font-size: 15px; color: var(--dark); font-weight: 500;
    transition: background .15s, border-color .15s;
    line-height: 1;
}
.qty-btn:hover { background: var(--dark); color: white; border-color: var(--dark); }
.qty-num { font-size: 14px; font-weight: 600; color: var(--dark); min-width: 20px; text-align: center; }

.row-price { font-size: 14px; font-weight: 700; color: var(--dark); }

.remove-btn {
    background: none; border: none; cursor: pointer;
    color: var(--muted); font-size: 16px; padding: 4px;
    line-height: 1; transition: color .2s;
}
.remove-btn:hover { color: var(--danger); }

/* Cart Footer */
.cart-footer {
    display: flex;
    justify-content: flex-end;
    padding-top: 18px;
    flex-direction: column;
    align-items: flex-end;
    gap: 8px;
}
.cart-row-sum {
    display: flex;
    justify-content: space-between;
    width: 100%;
    max-width: 260px;
    font-size: 14px;
    color: var(--muted);
}
.cart-row-sum span:last-child { font-weight: 500; color: var(--text); }
.cart-row-sum.free span:last-child { color: var(--accent-dark); font-weight: 600; }
.cart-divider { width: 100%; max-width: 260px; border: none; border-top: 1px solid var(--border); margin: 4px 0; }
.cart-total {
    display: flex;
    justify-content: space-between;
    width: 100%;
    max-width: 260px;
}
.cart-total-label { font-size: 15px; font-weight: 700; color: var(--dark); }
.cart-total-amount { font-family: 'DM Serif Display', serif; font-size: 1.4rem; color: var(--dark); }

/* Continue shopping */
.continue-link {
    font-size: 13px;
    font-weight: 500;
    color: var(--muted);
    text-decoration: none;
    margin-left: auto;
    display: block;
    text-align: right;
    margin-bottom: 6px;
    transition: color .2s;
}
.continue-link:hover { color: var(--dark); }

/* Flash */
.flash {
    display: flex; align-items: center; gap: 10px;
    padding: 13px 18px; border-radius: 10px;
    font-size: 14px; font-weight: 500; margin-bottom: 20px;
}
.flash-error { background: #fee2e2; color: #991b1b; }

/* ── Right Panel ── */
.pay-panel-title {
    font-family: 'DM Serif Display', serif;
    font-size: 1.45rem;
    color: var(--dark);
    margin-bottom: 20px;
}

/* Shipping fields */
.fg { margin-bottom: 14px; }
.fg:last-child { margin-bottom: 0; }
.flbl {
    display: block;
    font-size: 11px; font-weight: 700;
    letter-spacing: .8px; text-transform: uppercase;
    color: var(--muted); margin-bottom: 6px;
}
.finp {
    width: 100%; padding: 11px 14px;
    border: 1.5px solid var(--border); border-radius: 10px;
    background: var(--bg);
    font-family: 'DM Sans', sans-serif; font-size: 14px; color: var(--dark);
    outline: none; transition: border-color .2s, box-shadow .2s, background .2s;
}
.finp:focus {
    border-color: var(--dark);
    box-shadow: 0 0 0 3px rgba(28,28,30,.08);
    background: var(--white);
}
.finp::placeholder { color: var(--muted); }
textarea.finp { resize: vertical; min-height: 80px; }
.ferr { font-size: 12px; color: var(--danger); margin-top: 4px; }
.fr2 { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
@media (max-width: 420px) { .fr2 { grid-template-columns: 1fr; } }

.section-sep {
    border: none; border-top: 1px solid var(--border);
    margin: 22px 0;
}

/* Payment Method */
.pm-label {
    font-size: 13px; font-weight: 700;
    letter-spacing: .5px; text-transform: uppercase;
    color: var(--muted); margin-bottom: 12px;
    display: block;
}

.pm-grid { display: flex; flex-direction: column; gap: 10px; margin-bottom: 16px; }

.popt input[type="radio"] { display: none; }

.plbl {
    display: flex; align-items: center; gap: 13px;
    padding: 13px 15px;
    border: 1.5px solid var(--border); border-radius: 12px;
    cursor: pointer; background: var(--bg);
    transition: all .2s;
}
.plbl:hover { border-color: var(--dark); background: var(--white); }
.popt input:checked + .plbl {
    border-color: var(--dark); background: var(--white);
    box-shadow: 0 0 0 3px rgba(28,28,30,.08);
}

/* Radio circle */
.popt input:checked + .plbl .pradio { border-color: var(--dark); }
.popt input:checked + .plbl .pradio::after { opacity: 1; }
.pradio {
    width: 18px; height: 18px; border-radius: 50%;
    border: 2px solid var(--border);
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0; transition: border-color .2s;
    position: relative;
}
.pradio::after {
    content: '';
    width: 8px; height: 8px;
    border-radius: 50%;
    background: var(--dark);
    opacity: 0;
    transition: opacity .2s;
}

.pico {
    width: 34px; height: 34px; border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
    font-size: 16px; flex-shrink: 0;
}
.ic-cod   { background: #f0fdf4; color: #16a34a; }
.ic-ssl   { background: #eff6ff; color: #2563eb; }

.pname { font-size: 14px; font-weight: 600; color: var(--dark); }
.psub  { font-size: 11px; color: var(--muted); margin-top: 1px; }

/* Extra fields */
.pextra {
    display: none;
    background: #f9fafb;
    border: 1.5px solid var(--border);
    border-radius: 12px;
    padding: 16px;
    margin-bottom: 4px;
    animation: sd .2s ease;
}
.pextra.show { display: block; }
@keyframes sd {
    from { opacity: 0; transform: translateY(-6px); }
    to   { opacity: 1; transform: translateY(0); }
}

/* Card fields styled like reference */
.card-fields { display: flex; flex-direction: column; gap: 12px; }
.card-row { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }

/* Checkout button */
.btn-checkout {
    display: flex; align-items: center; justify-content: center;
    width: 100%; padding: 15px 22px;
    background: #6c15c9;
    color: white;
    border: none; border-radius: 12px;
    font-family: 'DM Sans', sans-serif; font-size: 15px; font-weight: 700;
    cursor: pointer; transition: background .2s, transform .2s, box-shadow .2s;
    margin-top: 18px; letter-spacing: .2px;
}
.btn-checkout:hover {
    background: var(--accent-dark);
    transform: translateY(-1px);
    box-shadow: 0 8px 24px rgba(34,197,94,.3);
}

@media (max-width: 860px) {
    .cart-header { display: none; }
    .cart-row {
        grid-template-columns: auto 1fr;
        grid-template-rows: auto auto;
    }
}
</style>

<div class="co-page">
    <div class="co-container">

        <a href="{{ route('cart.index') }}" class="co-back">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
            Back
        </a>

        @if($errors->any())
            <div class="flash flash-error"><i class="fas fa-exclamation-circle"></i> Please fix the errors below.</div>
        @endif
        @if(session('error'))
            <div class="flash flash-error"><i class="fas fa-exclamation-circle"></i> {{ session('error') }}</div>
        @endif

        <form action="{{ route('checkout.place') }}" method="POST">
        @csrf

        <div class="co-grid">

            {{-- ── LEFT: Shopping Cart ── --}}
            <div class="panel">
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
                    <div class="panel-title" style="margin-bottom:0">Shopping Cart</div>
                    <a href="#" class="continue-link" style="margin-bottom:0">Continue shopping &rsaquo;</a>
                </div>

                <div class="cart-header">
                    <div>Product</div>
                    <!-- <div>Size</div> -->
                    <div>Quantity</div>
                    <div>Total Price</div>
                    <div></div>
                </div>

                @isset($cartItems)
                    @foreach($cartItems as $item)
                    <div class="cart-row">
                        <div class="cart-product">
                            <img src="{{ asset('storage/' . $item->product->primary_image) }}"
                                 class="cart-img" alt="{{ $item->product->name }}">
                            <div>
                                <div class="cart-name">{{ $item->product->name }}</div>
                               <div class="cart-sub">
    @if($item->product->brand)
        {{ is_object($item->product->brand) ? $item->product->brand->name : $item->product->brand }}
    @endif
</div>
                            </div>
                        </div>
<!-- 
                        <div>
                            <select class="size-sel" name="sizes[]">
                                @foreach(['20L','30L','3SL','40L'] as $s)
                                    <option value="{{ $s }}" {{ ($item->size ?? '3SL') == $s ? 'selected' : '' }}>{{ $s }}</option>
                                @endforeach
                            </select>
                        </div> -->

                        <div class="qty-ctrl">
                            <button type="button" class="qty-btn" onclick="adjustQty(this,-1)">−</button>
                            <span class="qty-num">{{ $item->quantity }}</span>
                            <button type="button" class="qty-btn" onclick="adjustQty(this,1)">+</button>
                        </div>

                        <div class="row-price">৳{{ number_format($item->quantity * $item->product->price, 2) }}</div>

                        <button type="button" class="remove-btn" title="Remove">×</button>
                    </div>
                    @endforeach
                @endisset

                <div class="cart-footer">
                    <div class="cart-row-sum"><span>Subtotal :</span><span>${{ number_format($total, 2) }}</span></div>
                    <div class="cart-row-sum free"><span>Shipping :</span><span>Free</span></div>
                    <hr class="cart-divider">
                    <div class="cart-total">
                        <span class="cart-total-label">Total :</span>
                        <span class="cart-total-amount">৳{{ number_format($total, 2) }}</span>
                    </div>
                </div>
            </div>

            {{-- ── RIGHT: Payment ── --}}
            <div class="panel">
                <div class="pay-panel-title">Shopping Card</div>

                {{-- Shipping fields --}}
                <div class="fg">
                    <label class="flbl">Full Name *</label>
                    <input type="text" name="full_name" class="finp"
                           placeholder="Your full name"
                           value="{{ old('full_name', Auth::user()->name ?? '') }}" required>
                    @error('full_name')<div class="ferr">{{ $message }}</div>@enderror
                </div>

                <div class="fr2">
                    <div class="fg">
                        <label class="flbl">Phone *</label>
                        <input type="text" name="phone" class="finp"
                               placeholder="01XXXXXXXXX"
                               value="{{ old('phone') }}" required>
                        @error('phone')<div class="ferr">{{ $message }}</div>@enderror
                    </div>
                    <div class="fg">
                        <label class="flbl">City *</label>
                        <input type="text" name="city" class="finp"
                               placeholder="Dhaka" value="{{ old('city') }}" required>
                        @error('city')<div class="ferr">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="fg">
                    <label class="flbl">Delivery Address *</label>
                    <textarea name="address" class="finp"
                              placeholder="House no, Road, Area, District" required>{{ old('address') }}</textarea>
                    @error('address')<div class="ferr">{{ $message }}</div>@enderror
                </div>

                <hr class="section-sep">

                {{-- Payment Method --}}
                <span class="pm-label">Payment Method :</span>

                <div class="pm-grid">

                    {{-- COD --}}
                    <div class="popt">
                        <input type="radio" name="payment_method" id="pm_cod" value="cod"
                               {{ old('payment_method','cod')=='cod'?'checked':'' }}
                               onchange="showX('cod')">
                        <label for="pm_cod" class="plbl">
                            <div class="pradio"></div>
                            <div class="pico ic-cod"><i class="fas fa-money-bill-wave"></i></div>
                            <div>
                                <div class="pname">Cash on Delivery</div>
                                <div class="psub">Pay when delivered</div>
                            </div>
                        </label>
                    </div>

                    {{-- SSLCommerz / Online --}}
                    <div class="popt">
                        <input type="radio" name="payment_method" id="pm_ssl" value="sslcommerz"
                               {{ old('payment_method')=='sslcommerz'?'checked':'' }}
                               onchange="showX('ssl')">
                        <label for="pm_ssl" class="plbl">
                            <div class="pradio"></div>
                            <div class="pico ic-ssl"><i class="fas fa-credit-card"></i></div>
                            <div>
                                <div class="pname">Credit Card</div>
                                <div class="psub">Card / bKash / Nagad</div>
                            </div>
                        </label>
                    </div>

                </div>

                {{-- SSL / Card extra fields --}}
                <!-- <div class="pextra {{ old('payment_method')=='sslcommerz' ? 'show' : '' }}" id="ex_ssl">
                    <div class="card-fields">
                        <div class="fg" style="margin-bottom:0">
                            <label class="flbl">Name On Card</label>
                            <input type="text" name="card_name" class="finp"
                                   placeholder="Enter name on card"
                                   value="{{ old('card_name') }}">
                        </div>
                        <div class="fg" style="margin-bottom:0">
                            <label class="flbl">Card Number</label>
                            <input type="text" name="card_number" class="finp"
                                   placeholder="Enter card number"
                                   value="{{ old('card_number') }}"
                                   maxlength="19">
                        </div>
                        <div class="card-row">
                            <div class="fg" style="margin-bottom:0">
                                <label class="flbl">Expiration Date</label>
                                <input type="text" name="card_expiry" class="finp"
                                       placeholder="MM / YY"
                                       value="{{ old('card_expiry') }}"
                                       maxlength="7">
                            </div>
                            <div class="fg" style="margin-bottom:0">
                                <label class="flbl">CVV</label>
                                <input type="text" name="card_cvv" class="finp"
                                       placeholder="Enter CVV"
                                       value="{{ old('card_cvv') }}"
                                       maxlength="4">
                            </div>
                        </div>
                    </div>
                </div> -->

                <button type="submit" class="btn-checkout">Check Out</button>
            </div>

        </div>
        </form>
    </div>
</div>

<script>
function showX(m) {
    document.querySelectorAll('.pextra').forEach(el => el.classList.remove('show'));
    const el = document.getElementById('ex_' + m);
    if (el) el.classList.add('show');
}

document.addEventListener('DOMContentLoaded', () => {
    const checked = document.querySelector('input[name="payment_method"]:checked');
    if (checked && checked.value !== 'cod') showX(checked.value === 'sslcommerz' ? 'ssl' : checked.value);

    // Card number formatting
    const cn = document.querySelector('input[name="card_number"]');
    if (cn) cn.addEventListener('input', e => {
        let v = e.target.value.replace(/\D/g,'').substring(0,16);
        e.target.value = v.replace(/(.{4})/g,'$1 ').trim();
    });

    // Expiry formatting
    const ex = document.querySelector('input[name="card_expiry"]');
    if (ex) ex.addEventListener('input', e => {
        let v = e.target.value.replace(/\D/g,'');
        if (v.length >= 2) v = v.substring(0,2) + ' / ' + v.substring(2,4);
        e.target.value = v;
    });
});

function adjustQty(btn, delta) {
    const row = btn.closest('.qty-ctrl');
    const span = row.querySelector('.qty-num');
    let val = parseInt(span.textContent) + delta;
    if (val < 1) val = 1;
    span.textContent = val;
}
</script>

@endsection