@extends('layouts.customer')

@section('title', 'My Orders')

@section('content')

<style>
/* ── Google Font ── */
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

/* ── Root Variables ── */
:root {
    --indigo:     #4f46e5;
    --indigo-lt:  #eef2ff;
    --indigo-mid: #c7d2fe;
    --surface:    #ffffff;
    --bg:         #f5f6fa;
    --border:     #e8eaef;
    --text-dark:  #1a1d27;
    --text-mid:   #4b5563;
    --text-soft:  #9ca3af;
    --radius-lg:  14px;
    --radius-md:  10px;
    --radius-sm:  8px;
    --shadow-sm:  0 2px 8px rgba(0,0,0,.06);
    --shadow-md:  0 6px 20px rgba(0,0,0,.09);
}

* { box-sizing: border-box; }

/* ── Page Wrapper ── */
.orders-page {
    font-family: 'Plus Jakarta Sans', sans-serif;
    background: var(--bg);
    min-height: 100vh;
    margin-left: 280px;
    padding: 2rem 2rem 3rem 2rem;
    overflow-x: hidden;
    /* Fill remaining viewport after sidebar */
    width: calc(100vw - 280px);
}

@media (max-width: 768px) {
    .orders-page { margin-left: 0; padding: 1.5rem 1rem 2rem; width: 100%; }
}

/* ── Page Header ── */
.orders-header {
    margin-bottom: 2rem;
}

.orders-header h1 {
    font-size: 1.65rem;
    font-weight: 800;
    color: var(--text-dark);
    margin: 0 0 .25rem;
    display: flex;
    align-items: center;
    gap: .45rem;
}

.orders-header p {
    margin: 0;
    color: var(--text-soft);
    font-size: .9rem;
}

/* ── Stats Strip ── */
.stats-strip {
    display: flex;
    gap: 1rem;
    margin-bottom: 1.75rem;
    flex-wrap: wrap;
    width: 100%;
}

.stat-card {
    flex: 1 1 0;          /* equal width, no shrink floor */
    min-width: 120px;
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--radius-lg);
    padding: .9rem 1.2rem;
    display: flex;
    flex-direction: column;
    gap: .2rem;
}

.stat-card .stat-label {
    font-size: .72rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .06em;
    color: var(--text-soft);
}

.stat-card .stat-val {
    font-size: 1.35rem;
    font-weight: 800;
    color: var(--text-dark);
}

.stat-card.accent { background: var(--indigo); border-color: var(--indigo); }
.stat-card.accent .stat-label,
.stat-card.accent .stat-val { color: #fff; }

/* ── Card Wrapper ── */
.orders-card {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--radius-lg);
    overflow: hidden;
    box-shadow: var(--shadow-sm);
    width: 100%;
}

/* ── Table ── */
.table-scroll {
    overflow-x: auto;
    width: 100%;
}

.order-table {
    width: 100%;
    border-collapse: collapse;
    min-width: 700px;
}

/* Header */
.order-table thead tr {
    background: #f8f9fc;
    border-bottom: 1px solid var(--border);
}

.order-table thead th {
    padding: .85rem 1.2rem;
    text-align: left;
    font-size: .72rem;
    font-weight: 700;
    color: var(--text-soft);
    text-transform: uppercase;
    letter-spacing: .07em;
    white-space: nowrap;
}

/* Body rows */
.order-table tbody tr {
    border-bottom: 1px solid var(--border);
    transition: background .15s;
}

.order-table tbody tr:last-child { border-bottom: none; }

.order-table tbody tr:hover { background: #fafbff; }

.order-table tbody td {
    padding: 1rem 1.2rem;
    font-size: .855rem;
    color: var(--text-mid);
    vertical-align: middle;
    white-space: nowrap;
}

/* ── Cell Styles ── */
.order-id {
    font-family: 'Courier New', monospace;
    font-weight: 700;
    font-size: .82rem;
    color: var(--indigo);
    background: var(--indigo-lt);
    padding: .28rem .65rem;
    border-radius: var(--radius-sm);
    display: inline-block;
}

.items-pill {
    background: #f3f4f6;
    color: #64748b;
    padding: .28rem .7rem;
    border-radius: 20px;
    font-size: .77rem;
    font-weight: 600;
}

.amount {
    font-weight: 700;
    color: var(--text-dark);
    font-size: .9rem;
}

.pay-tag {
    background: #f9fafb;
    color: #64748b;
    border: 1px solid var(--border);
    padding: .22rem .55rem;
    border-radius: var(--radius-sm);
    font-size: .77rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: .04em;
}

.date-val {
    color: var(--text-soft);
    font-size: .8rem;
}

/* ── Status Badges ── */
.badge {
    display: inline-flex;
    align-items: center;
    gap: .3rem;
    padding: .3rem .75rem;
    border-radius: 20px;
    font-size: .74rem;
    font-weight: 700;
    white-space: nowrap;
}

.badge .dot {
    width: 6px; height: 6px;
    border-radius: 50%;
    flex-shrink: 0;
}

.badge-pending   { background: #fef3c7; color: #b45309; }
.badge-pending .dot   { background: #b45309; }

.badge-confirmed { background: #dbeafe; color: #2563eb; }
.badge-confirmed .dot { background: #2563eb; }

.badge-processing{ background: #fce7f3; color: #be185d; }
.badge-processing .dot { background: #be185d; }

.badge-shipped   { background: #ede9fe; color: #7c3aed; }
.badge-shipped .dot   { background: #7c3aed; }

.badge-delivered { background: #dcfce7; color: #16a34a; }
.badge-delivered .dot { background: #16a34a; }

.badge-cancelled { background: #fee2e2; color: #dc2626; }
.badge-cancelled .dot { background: #dc2626; }

/* ── View Button ── */
.btn-view {
    display: inline-flex;
    align-items: center;
    gap: .3rem;
    padding: .38rem .85rem;
    background: var(--indigo-lt);
    color: var(--indigo);
    border: 1px solid var(--indigo-mid);
    border-radius: var(--radius-md);
    font-size: .78rem;
    font-weight: 700;
    text-decoration: none;
    transition: background .18s, color .18s, border-color .18s, transform .15s;
}

.btn-view:hover {
    background: var(--indigo);
    color: #fff;
    border-color: var(--indigo);
    transform: translateY(-1px);
}

/* ── Empty State ── */
.empty-state {
    text-align: center;
    padding: 4rem 2rem;
    color: var(--text-soft);
}

.empty-state .empty-icon { font-size: 3rem; display: block; margin-bottom: 1rem; }
.empty-state h3 { font-size: 1.15rem; font-weight: 700; color: var(--text-dark); margin: 0 0 .5rem; }
.empty-state p  { margin: 0 0 1.5rem; font-size: .9rem; }

.btn-shop {
    display: inline-flex;
    align-items: center;
    gap: .4rem;
    padding: .65rem 1.5rem;
    background: var(--indigo);
    color: #fff;
    border-radius: var(--radius-md);
    font-size: .875rem;
    font-weight: 700;
    text-decoration: none;
    transition: opacity .18s;
}

.btn-shop:hover { opacity: .88; }

/* ── Responsive ── */
@media (max-width: 768px) {
    .orders-page { padding: 1.5rem 1rem 2rem; }
    .stats-strip { gap: .75rem; }
    .stat-card   { flex: 1 1 120px; }
}
</style>

<div class="orders-page">

    {{-- Header --}}
    <div class="orders-header">
        <h1>📦 My Orders</h1>
        <p>Track all your purchases in one place</p>
    </div>

    @if(!$order->isEmpty())
    {{-- Stats Strip --}}
    <div class="stats-strip">
        <div class="stat-card accent">
            <span class="stat-label">Total Orders</span>
            <span class="stat-val">{{ $order->count() }}</span>
        </div>
        <div class="stat-card">
            <span class="stat-label">Delivered</span>
            <span class="stat-val">{{ $order->where('status','delivered')->count() }}</span>
        </div>
        <div class="stat-card">
            <span class="stat-label">Pending</span>
            <span class="stat-val">{{ $order->whereIn('status',['pending','processing','confirmed','shipped'])->count() }}</span>
        </div>
        <div class="stat-card">
            <span class="stat-label">Total Spent</span>
            <span class="stat-val">৳{{ number_format($order->sum('total_amount'), 0) }}</span>
        </div>
    </div>
    @endif

    {{-- Table Card --}}
    <div class="orders-card">

        @if($order->isEmpty())
            <div class="empty-state">
                <span class="empty-icon">🛒</span>
                <h3>No Orders Yet</h3>
                <p>You haven't placed any orders. Start shopping now!</p>
                <a href="{{ route('frontend.shop') }}" class="btn-shop">🛍️ Start Shopping</a>
            </div>
        @else
            <div class="table-scroll">
                <table class="order-table">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Items</th>
                            <th>Total</th>
                            <th>Payment</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order as $orderItem)
                        @php
                            $statusMap = [
                                'pending'    => ['label' => 'Pending',    'class' => 'badge-pending'],
                                'confirmed'  => ['label' => 'Confirmed',  'class' => 'badge-confirmed'],
                                'processing' => ['label' => 'Processing', 'class' => 'badge-processing'],
                                'shipped'    => ['label' => 'Shipped',    'class' => 'badge-shipped'],
                                'delivered'  => ['label' => 'Delivered',  'class' => 'badge-delivered'],
                                'cancelled'  => ['label' => 'Cancelled',  'class' => 'badge-cancelled'],
                            ];
                            $s = $statusMap[$orderItem->status] ?? ['label' => ucfirst($orderItem->status), 'class' => 'badge-pending'];
                        @endphp
                        <tr>
                            <td>
                                <span class="order-id">#{{ str_pad($orderItem->id, 5, '0', STR_PAD_LEFT) }}</span>
                            </td>
                            <td>
                                <span class="items-pill">{{ $orderItem->items->count() }} items</span>
                            </td>
                            <td>
                                <span class="amount">৳{{ number_format($orderItem->total_amount, 2) }}</span>
                            </td>
                            <td>
                                <span class="pay-tag">{{ $orderItem->payment_method }}</span>
                            </td>
                            <td>
                                <span class="badge {{ $s['class'] }}">
                                    <span class="dot"></span>
                                    {{ $s['label'] }}
                                </span>
                            </td>
                            <td>
                                <span class="date-val">{{ $orderItem->created_at->format('d M, Y') }}</span>
                            </td>
                            <td>
                                <a href="{{ route('customer.order.details', $orderItem->id) }}" class="btn-view">
                                    🔍 View
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

    </div>{{-- .orders-card --}}

</div>{{-- .orders-page --}}

@endsection