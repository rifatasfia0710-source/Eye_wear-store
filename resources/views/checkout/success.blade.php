@extends('layouts.home')

@section('content')

<style>
@import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600&family=Jost:wght@300;400;500;600;700&display=swap');

:root {
    --cream: #fdf8f3;
    --warm: #f5ede3;
    --dark: #1a1208;
    --text: #2c2416;
    --muted: #9e9185;
    --border: #e8ddd4;
    --accent: #c8622a;
    --white: #ffffff;
    --green: #2e7d32;
    --green-light: #f0fdf4;
}

* { box-sizing: border-box; }

.confirm-page {
    font-family: 'Jost', sans-serif;
    background: var(--cream);
    min-height: 100vh;
    padding: 60px 0 100px;
    position: relative;
    overflow: hidden;
}

/* Background blobs */
.bg-blob { position: fixed; border-radius: 50%; filter: blur(90px); pointer-events: none; z-index: 0; }
.bg-blob-1 { width: 420px; height: 420px; background: #f5d5b8; opacity: .45; top: -100px; right: -100px; }
.bg-blob-2 { width: 300px; height: 300px; background: #fce8d0; opacity: .4; bottom: 80px; left: -80px; }
.bg-blob-3 { width: 200px; height: 200px; background: #d4edda; opacity: .35; top: 40%; left: 50%; transform: translateX(-50%); }

.confirm-inner {
    position: relative;
    z-index: 1;
    max-width: 620px;
    margin: 0 auto;
    padding: 0 20px;
}

/* Steps */
.steps {
    display: flex;
    align-items: center;
    font-size: 14px;
    color: var(--muted);
    margin-bottom: 44px;
    justify-content: center;
}
.step { font-weight: 400; }
.step.done { color: #16a34a; font-weight: 500; }
.step-line { width: 56px; height: 1px; background: var(--border); margin: 0 12px; }

/* Main card */
.confirm-card {
    background: var(--white);
    border-radius: 24px;
    border: 1px solid var(--border);
    padding: 52px 44px 44px;
    text-align: center;
    box-shadow: 0 8px 48px rgba(26,18,8,.07);
    animation: slideUp 0.5s ease forwards;
}

@keyframes slideUp {
    from { opacity: 0; transform: translateY(24px); }
    to   { opacity: 1; transform: translateY(0); }
}

/* Check circle */
.check-wrap {
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 28px;
}

.check-circle {
    width: 84px;
    height: 84px;
    border-radius: 50%;
    background: var(--green-light);
    border: 2px solid #bbf7d0;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 32px;
    color: #16a34a;
    animation: popIn 0.5s cubic-bezier(0.34, 1.56, 0.64, 1) 0.2s both;
    position: relative;
}

@keyframes popIn {
    from { transform: scale(0); opacity: 0; }
    to   { transform: scale(1); opacity: 1; }
}

.check-circle::after {
    content: '';
    position: absolute;
    inset: -8px;
    border-radius: 50%;
    border: 1.5px solid #bbf7d0;
    animation: ringPulse 1.8s ease-out 0.5s infinite;
}

@keyframes ringPulse {
    0%   { transform: scale(1);   opacity: 0.6; }
    100% { transform: scale(1.5); opacity: 0; }
}

.confirm-title {
    font-family: 'Cormorant Garamond', serif;
    font-size: 2.4rem;
    font-weight: 600;
    color: var(--dark);
    margin-bottom: 10px;
    line-height: 1.1;
}

.confirm-subtitle {
    font-size: 15px;
    color: var(--muted);
    margin-bottom: 36px;
    line-height: 1.6;
}

/* Order meta */
.order-meta {
    background: var(--cream);
    border: 1px solid var(--border);
    border-radius: 14px;
    padding: 20px 24px;
    margin-bottom: 28px;
    text-align: left;
}

.meta-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 9px 0;
    border-bottom: 1px solid var(--border);
    font-size: 14px;
}
.meta-row:last-child { border-bottom: none; padding-bottom: 0; }
.meta-row:first-child { padding-top: 0; }

.meta-label { color: var(--muted); }
.meta-value { font-weight: 600; color: var(--dark); }
.meta-value.green { color: #16a34a; }
.meta-value.accent { color: var(--accent); }

/* Payment badge */
.pay-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: #fff7ed;
    border: 1px solid #fed7aa;
    color: var(--accent);
    font-size: 13px;
    font-weight: 600;
    padding: 4px 12px;
    border-radius: 20px;
}

/* Divider */
.divider {
    display: flex;
    align-items: center;
    gap: 14px;
    margin-bottom: 28px;
}
.divider-line { flex: 1; height: 1px; background: var(--border); }
.divider-text { font-size: 12px; color: var(--muted); letter-spacing: 1px; text-transform: uppercase; white-space: nowrap; }

/* Action buttons */
.actions {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.btn-primary-action {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    width: 100%;
    padding: 16px;
    background: var(--dark);
    color: white;
    border: none;
    border-radius: 12px;
    font-family: 'Jost', sans-serif;
    font-size: 15px;
    font-weight: 600;
    text-decoration: none;
    cursor: pointer;
    transition: background 0.2s, transform 0.2s, box-shadow 0.2s;
    letter-spacing: 0.3px;
}
.btn-primary-action:hover {
    background: #2d2416;
    transform: translateY(-1px);
    box-shadow: 0 8px 24px rgba(26,18,8,.2);
    color: white;
}

.btn-secondary-action {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    width: 100%;
    padding: 14px;
    background: transparent;
    color: var(--muted);
    border: 1.5px solid var(--border);
    border-radius: 12px;
    font-family: 'Jost', sans-serif;
    font-size: 14px;
    font-weight: 500;
    text-decoration: none;
    transition: border-color 0.2s, color 0.2s;
}
.btn-secondary-action:hover {
    border-color: var(--accent);
    color: var(--accent);
}

/* Bottom note */
.confirm-note {
    margin-top: 28px;
    font-size: 12px;
    color: var(--muted);
    line-height: 1.6;
}
.confirm-note a { color: var(--accent); text-decoration: none; }
.confirm-note a:hover { text-decoration: underline; }
</style>

<div class="confirm-page">
    <div class="bg-blob bg-blob-1"></div>
    <div class="bg-blob bg-blob-2"></div>
    <div class="bg-blob bg-blob-3"></div>

    <div class="confirm-inner">

        {{-- Steps --}}
        <div class="steps">
            <div class="step done"><i class="fas fa-check" style="font-size:11px;margin-right:4px"></i>1. Cart</div>
            <div class="step-line"></div>
            <div class="step done"><i class="fas fa-check" style="font-size:11px;margin-right:4px"></i>2. Checkout</div>
            <div class="step-line"></div>
            <div class="step done"><i class="fas fa-check" style="font-size:11px;margin-right:4px"></i>3. Confirmed</div>
        </div>

        {{-- Main Card --}}
        <div class="confirm-card">

            <div class="check-wrap">
                <div class="check-circle">
                    <i class="fas fa-check"></i>
                </div>
            </div>

            <div class="confirm-title">Order Confirmed!</div>
            <div class="confirm-subtitle">
                Thank you for your purchase. Your order has been placed<br>
                successfully and is now being processed.
            </div>

            {{-- Order Details --}}
            <div class="order-meta">
                <div class="meta-row">
                    <span class="meta-label">Order Number</span>
                    <span class="meta-value">#{{ $order->order_number ?? 'ORD-' . str_pad($order->id ?? 1, 5, '0', STR_PAD_LEFT) }}</span>
                </div>
                <div class="meta-row">
                    <span class="meta-label">Order Date</span>
                    <span class="meta-value">{{ now()->format('d M, Y') }}</span>
                </div>
                <div class="meta-row">
                    <span class="meta-label">Total Amount</span>
                    <span class="meta-value">৳{{ number_format($order->total_amount ?? 0, 2) }}</span>
                </div>
                <div class="meta-row">
                    <span class="meta-label">Payment Method</span>
                    <span class="meta-value">
                        <span class="pay-badge">
                            @if(($order->payment_method ?? 'cod') === 'cod')
                                <i class="fas fa-money-bill-wave"></i> Cash on Delivery
                            @elseif($order->payment_method === 'bkash')
                                <i class="fas fa-mobile-alt"></i> bKash
                            @elseif($order->payment_method === 'nagad')
                                <i class="fas fa-mobile-alt"></i> Nagad
                            @else
                                <i class="fas fa-credit-card"></i> Card
                            @endif
                        </span>
                    </span>
                </div>
                <div class="meta-row">
                    <span class="meta-label">Status</span>
                    <span class="meta-value green"><i class="fas fa-circle" style="font-size:8px;margin-right:5px"></i>Processing</span>
                </div>
            </div>

            <div class="divider">
                <div class="divider-line"></div>
                <div class="divider-text">What's next?</div>
                <div class="divider-line"></div>
            </div>

            <div class="actions">
                <a href="{{ route('frontend.shop') }}" class="btn-primary-action">
                    <i class="fas fa-store"></i>
                    Continue Shopping
                </a>
                @auth
                <a href="{{ route('admin.orders.index')}}" class="btn-secondary-action">
                    <i class="fas fa-list-ul"></i>
                    View My Orders
                </a>
                @endauth
            </div>

            <p class="confirm-note">
                A confirmation will be sent to your email. Questions?
                <a href="#">Contact Support</a>
            </p>

        </div>

    </div>
</div>

@endsection