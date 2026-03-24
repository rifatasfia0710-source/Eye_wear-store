@extends('layouts.customer')

@section('title', 'Order Details')

@section('content')

@php
    $statusMap = [
        'pending'   => ['label' => 'Pending',   'class' => 'badge-pending'],
        'confirmed' => ['label' => 'Confirmed', 'class' => 'badge-confirmed'],
        'delivered' => ['label' => 'Delivered', 'class' => 'badge-delivered'],
        'cancelled' => ['label' => 'Cancelled', 'class' => 'badge-cancelled'],
    ];
    $s = $statusMap[$order->status] ?? ['label' => ucfirst($order->status), 'class' => 'badge-pending'];
@endphp

<style>
    * { box-sizing: border-box; }

    .detail-wrapper {
        width: 100%;
        max-width: 960px;
        margin: 0 auto;
        padding: 2rem 1.5rem;
    }

    /* Breadcrumb */
    .breadcrumb {
        display: flex; align-items: center; gap: 0.5rem;
        margin-bottom: 1.25rem; font-size: 0.82rem; color: #94a3b8;
    }
    .breadcrumb a { color: #94a3b8; text-decoration: none; }
    .breadcrumb a:hover { color: #6366f1; }
    .breadcrumb .sep { color: #cbd5e1; }
    .breadcrumb .current { color: #475569; font-weight: 600; }

    /* Page Header */
    .page-header {
        display: flex; justify-content: space-between;
        align-items: flex-start; margin-bottom: 1.75rem;
        flex-wrap: wrap; gap: 1rem;
    }
    .page-header h1 { font-size: 1.4rem; font-weight: 700; color: #1e293b; margin: 0 0 0.2rem; }
    .page-header .sub { color: #94a3b8; font-size: 0.82rem; }
    .header-right { display: flex; align-items: center; gap: 0.75rem; flex-wrap: wrap; }

    /* Badges */
    .badge {
        display: inline-flex; align-items: center; gap: 0.3rem;
        padding: 0.3rem 0.85rem; border-radius: 20px;
        font-size: 0.75rem; font-weight: 700;
    }
    .badge::before {
        content: ''; width: 6px; height: 6px;
        border-radius: 50%; background: currentColor; flex-shrink: 0;
    }
    .badge-pending   { background: #fffbeb; color: #d97706; }
    .badge-confirmed { background: #eff6ff; color: #2563eb; }
    .badge-delivered { background: #f0fdf4; color: #16a34a; }
    .badge-cancelled { background: #fef2f2; color: #dc2626; }

    .btn-back {
        display: inline-flex; align-items: center; gap: 0.4rem;
        padding: 0.45rem 1rem; background: #f1f5f9; color: #475569;
        border: 1px solid #e2e8f0; border-radius: 8px;
        font-size: 0.8rem; font-weight: 600; text-decoration: none; transition: all 0.2s;
    }
    .btn-back:hover { background: #e2e8f0; color: #1e293b; }

    /* Grid */
    .detail-grid {
        display: grid;
        grid-template-columns: 1fr 320px;
        gap: 1.25rem;
        align-items: start;
    }

    /* Card */
    .card {
        background: #fff; border-radius: 14px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        overflow: hidden; margin-bottom: 1.25rem;
    }
    .card:last-child { margin-bottom: 0; }
    .card-header {
        padding: 1rem 1.25rem; border-bottom: 1px solid #f1f5f9;
        display: flex; align-items: center; gap: 0.5rem;
        background: #f8fafc;
    }
    .card-header h3 { font-size: 0.88rem; font-weight: 700; color: #1e293b; margin: 0; }
    .card-body { padding: 1.25rem; }

    /* Order Items */
    .order-item {
        display: flex; align-items: center; gap: 1rem;
        padding: 0.9rem 0; border-bottom: 1px solid #f1f5f9;
    }
    .order-item:first-child { padding-top: 0; }
    .order-item:last-child { border-bottom: none; padding-bottom: 0; }

    .item-img {
        width: 52px; height: 52px; border-radius: 10px;
        background: #f1f5f9; flex-shrink: 0;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.4rem; overflow: hidden;
    }
    .item-img img { width: 100%; height: 100%; object-fit: cover; }
    .item-info { flex: 1; min-width: 0; }
    .item-name { font-size: 0.875rem; font-weight: 600; color: #1e293b; margin-bottom: 0.2rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .item-meta { font-size: 0.78rem; color: #94a3b8; }
    .item-price { text-align: right; flex-shrink: 0; }
    .unit-price { font-size: 0.75rem; color: #94a3b8; }
    .total-price { font-size: 0.92rem; font-weight: 700; color: #1e293b; }

    /* Summary */
    .summary-section { margin-top: 1.25rem; padding-top: 1rem; border-top: 1px solid #f1f5f9; }
    .summary-row {
        display: flex; justify-content: space-between;
        font-size: 0.82rem; color: #64748b; padding: 0.4rem 0;
    }
    .summary-total {
        display: flex; justify-content: space-between;
        font-size: 1rem; font-weight: 700; color: #1e293b;
        padding: 0.75rem 0 0; margin-top: 0.5rem;
        border-top: 2px solid #e2e8f0;
    }
    .summary-total .total-amount { color: #6366f1; }
    .free-tag { color: #16a34a; font-weight: 600; }

    /* Address */
    .address-box {
        background: #f8fafc; border-radius: 10px;
        padding: 0.9rem 1rem; font-size: 0.875rem;
        color: #334155; line-height: 1.6;
        border: 1px solid #e2e8f0;
    }

    /* Info Rows */
    .info-row {
        display: flex; justify-content: space-between;
        align-items: center; padding: 0.65rem 0;
        border-bottom: 1px solid #f8fafc; gap: 1rem;
    }
    .info-row:first-child { padding-top: 0; }
    .info-row:last-child { border-bottom: none; padding-bottom: 0; }
    .info-label { font-size: 0.8rem; color: #94a3b8; font-weight: 500; white-space: nowrap; }
    .info-value { font-size: 0.85rem; color: #334155; font-weight: 600; text-align: right; }
    .info-value.highlight { color: #6366f1; font-family: monospace; }
    .info-value.amount { color: #6366f1; font-weight: 700; }

    /* Timeline */
    .timeline { padding: 0.25rem 0; }
    .timeline-item {
        display: flex; gap: 1rem;
        padding-bottom: 1.25rem; position: relative;
    }
    .timeline-item:last-child { padding-bottom: 0; }
    .timeline-item::before {
        content: ''; position: absolute;
        left: 15px; top: 30px; bottom: 0;
        width: 2px; background: #f1f5f9;
    }
    .timeline-item:last-child::before { display: none; }
    .timeline-dot {
        width: 32px; height: 32px; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: 0.8rem; flex-shrink: 0; z-index: 1;
    }
    .timeline-dot.done    { background: #f0fdf4; color: #16a34a; border: 2px solid #bbf7d0; }
    .timeline-dot.current { background: #eff6ff; color: #2563eb; border: 2px solid #bfdbfe; }
    .timeline-dot.pending { background: #f8fafc; color: #cbd5e1; border: 2px solid #e2e8f0; }
    .tl-title { font-size: 0.85rem; font-weight: 600; color: #1e293b; margin-bottom: 0.15rem; }
    .tl-desc  { font-size: 0.75rem; color: #94a3b8; }

    @media (max-width: 860px) {
        .detail-grid { grid-template-columns: 1fr; }
    }
    @media (max-width: 576px) {
        .detail-wrapper { padding: 1rem; }
        .page-header { flex-direction: column; }
    }
</style>

<div class="detail-wrapper">

    <!-- Breadcrumb -->
    <div class="breadcrumb">
        <a href="{{ route('customer.order') }}">📦 Orders</a>
        <span class="sep">›</span>
        <span class="current">#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</span>
    </div>

    <!-- Header -->
    <div class="page-header">
        <div>
            <h1>Order #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</h1>
            <div class="sub">Placed on {{ $order->created_at->format('d M Y, h:i A') }}</div>
        </div>
        <div class="header-right">
            <span class="badge {{ $s['class'] }}">{{ $s['label'] }}</span>
            <a href="{{ route('customer.order') }}" class="btn-back">← Back to Orders</a>
        </div>
    </div>

    <div class="detail-grid">

        <!-- Left Column -->
        <div>
            <!-- Ordered Items -->
            <div class="card">
                <div class="card-header">
                    <span>🛒</span>
                    <h3>Ordered Items</h3>
                </div>
                <div class="card-body">
                    @foreach($order->items as $item)
                    <div class="order-item">
                        <div class="item-img">
                            @if($item->product && $item->product->image)
                                <img src="{{ asset('storage/'.$item->product->image) }}" alt="{{ $item->product->name }}">
                            @else
                                📦
                            @endif
                        </div>
                        <div class="item-info">
                            <div class="item-name">
                                {{ $item->product ? $item->product->name : 'Product not found' }}
                            </div>
                            <div class="item-meta">
                                Qty: {{ $item->quantity }} &nbsp;×&nbsp; ৳{{ number_format($item->price, 2) }}
                            </div>
                        </div>
                        <div class="item-price">
                            <div class="unit-price">৳{{ number_format($item->price, 2) }} each</div>
                            <div class="total-price">৳{{ number_format($item->price * $item->quantity, 2) }}</div>
                        </div>
                    </div>
                    @endforeach

                    <div class="summary-section">
                        <div class="summary-row">
                            <span>Subtotal</span>
                            <span>৳{{ number_format($order->total_amount, 2) }}</span>
                        </div>
                        <div class="summary-row">
                            <span>Delivery Charge</span>
                            <span class="free-tag">Free</span>
                        </div>
                        <div class="summary-total">
                            <span>Total Paid</span>
                            <span class="total-amount">৳{{ number_format($order->total_amount, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Delivery Address -->
            <div class="card">
                <div class="card-header">
                    <span>📍</span>
                    <h3>Delivery Address</h3>
                </div>
                <div class="card-body">
                    <div class="address-box">{{ $order->address }}</div>
                </div>
            </div>
        </div>

        <!-- Right Column -->
        <div>
            <!-- Order Info -->
            <div class="card">
                <div class="card-header">
                    <span>📋</span>
                    <h3>Order Info</h3>
                </div>
                <div class="card-body">
                    <div class="info-row">
                        <span class="info-label">Order ID</span>
                        <span class="info-value highlight">#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Order Date</span>
                        <span class="info-value">{{ $order->created_at->format('d M, Y') }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Payment Method</span>
                        <span class="info-value">{{ $order->payment_method }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Total Items</span>
                        <span class="info-value">{{ $order->items->count() }} items</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Total Amount</span>
                        <span class="info-value amount">৳{{ number_format($order->total_amount, 2) }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Status</span>
                        <span class="badge {{ $s['class'] }}">{{ $s['label'] }}</span>
                    </div>
                </div>
            </div>

            <!-- Order Tracking -->
            <div class="card">
                <div class="card-header">
                    <span>📊</span>
                    <h3>Order Tracking</h3>
                </div>
                <div class="card-body">
                    <div class="timeline">

                        <div class="timeline-item">
                            <div class="timeline-dot done">✓</div>
                            <div class="timeline-info">
                                <div class="tl-title">Order Placed</div>
                                <div class="tl-desc">{{ $order->created_at->format('d M, Y h:i A') }}</div>
                            </div>
                        </div>

                        <div class="timeline-item">
                            @if(in_array($order->status, ['confirmed','delivered']))
                                <div class="timeline-dot done">✓</div>
                            @elseif($order->status == 'pending')
                                <div class="timeline-dot current">⏳</div>
                            @else
                                <div class="timeline-dot pending">○</div>
                            @endif
                            <div class="timeline-info">
                                <div class="tl-title">Order Confirmed</div>
                                <div class="tl-desc">
                                    @if(in_array($order->status, ['confirmed','delivered'])) Confirmed
                                    @else Awaiting confirmation
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="timeline-item">
                            @if($order->status == 'delivered')
                                <div class="timeline-dot done">✓</div>
                            @elseif($order->status == 'confirmed')
                                <div class="timeline-dot current">🚚</div>
                            @else
                                <div class="timeline-dot pending">○</div>
                            @endif
                            <div class="timeline-info">
                                <div class="tl-title">Out for Delivery</div>
                                <div class="tl-desc">
                                    @if($order->status == 'delivered') Completed
                                    @elseif($order->status == 'confirmed') On the way
                                    @else Pending
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="timeline-item">
                            @if($order->status == 'delivered')
                                <div class="timeline-dot done">✓</div>
                            @else
                                <div class="timeline-dot pending">○</div>
                            @endif
                            <div class="timeline-info">
                                <div class="tl-title">Delivered</div>
                                <div class="tl-desc">
                                    @if($order->status == 'delivered') Package delivered ✅
                                    @else Pending
                                    @endif
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection