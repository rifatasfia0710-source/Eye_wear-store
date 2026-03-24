@extends('layouts.admin')

@section('title', 'Order #' . $order->id . ' Details')

@section('content')

<main class="dashboard-content">

    {{-- Page Header --}}
    <div class="page-header">
        <div class="header-left">
            <a href="{{ route('admin.orders.index') }}" class="back-btn">
                <i class="fas fa-arrow-left"></i> Back to Orders
            </a>
            <h1><i class="fas fa-file-invoice"></i> Order <span>#{{ $order->id }}</span></h1>
            <p>Placed on {{ $order->created_at->format('d M Y, h:i A') }}</p>
        </div>
        <div class="header-right">
            <span class="status-pill status-{{ $order->status }}">
                <i class="fas fa-circle"></i> {{ ucfirst($order->status) }}
            </span>
            <button onclick="window.print()" class="btn-print">
                <i class="fas fa-print"></i> Print Invoice
            </button>
        </div>
    </div>

    {{-- Alerts --}}
    @if(session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">
            <i class="fas fa-times-circle"></i> {{ session('error') }}
        </div>
    @endif

    <div class="order-grid">

        {{-- LEFT COLUMN --}}
        <div class="col-left">

            {{-- Ordered Items --}}
            <div class="card">
                <div class="card-header">
                    <h2><i class="fas fa-shopping-bag"></i> Ordered Items</h2>
                    <span class="badge">{{ $order->items->count() }} item(s)</span>
                </div>
                <div class="card-body no-pad">
                    <table class="items-table">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Qty</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($order->items as $item)
                            <tr>
                                <td>
                                    <div class="product-cell">
                                        @if(isset($item->product->images) && $item->product->images->first())
                                            <img src="{{ asset('storage/' . $item->product->images->first()->image_path) }}" 
                                                 alt="{{ $item->product->name ?? $item->product_name }}"
                                                 class="product-thumb">
                                        @else
                                            <div class="product-thumb-placeholder">
                                                <i class="fas fa-box"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <strong>{{ $item->product->name ?? $item->product_name ?? 'N/A' }}</strong>
                                            @if(isset($item->variant))
                                                <small>{{ $item->variant }}</small>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>${{ number_format($item->price, 2) }}</td>
                                <td>
                                    <span class="qty-badge">{{ $item->quantity }}</span>
                                </td>
                                <td>
                                    <strong>${{ number_format($item->price * $item->quantity, 2) }}</strong>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="empty-row">
                                    <i class="fas fa-inbox"></i> No items found
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Order Summary --}}
                <div class="order-summary">
                    <div class="summary-row">
                        <span>Subtotal</span>
                        <span>${{ number_format($order->items->sum(fn($i) => $i->price * $i->quantity), 2) }}</span>
                    </div>
                    @if(isset($order->shipping_charge))
                    <div class="summary-row">
                        <span>Shipping</span>
                        <span>${{ number_format($order->shipping_charge, 2) }}</span>
                    </div>
                    @endif
                    @if(isset($order->discount))
                    <div class="summary-row discount">
                        <span>Discount</span>
                        <span>-${{ number_format($order->discount, 2) }}</span>
                    </div>
                    @endif
                    <div class="summary-row total">
                        <span>Total</span>
                        <span>${{ number_format($order->total_amount, 2) }}</span>
                    </div>
                </div>
            </div>

            {{-- Update Order Status --}}
            <div class="card">
                <div class="card-header">
                    <h2><i class="fas fa-sync-alt"></i> Update Status</h2>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.orders.status', $order->id) }}" method="POST">
                        @csrf
                        <div class="status-steps">
                            @foreach(['pending','confirmed','processing','shipped','delivered','cancelled'] as $step)
                            <label class="step-label {{ $order->status === $step ? 'active' : '' }} {{ in_array($order->status, ['delivered','cancelled']) && $order->status !== $step ? 'passed' : '' }}">
                                <input type="radio" name="status" value="{{ $step }}" 
                                       {{ $order->status === $step ? 'checked' : '' }}>
                                <span class="step-dot"></span>
                                <span class="step-name">{{ ucfirst($step) }}</span>
                            </label>
                            @endforeach
                        </div>

                        {{-- Cancel Reason --}}
                        <div id="cancelReasonBox" style="{{ $order->status === 'cancelled' ? '' : 'display:none' }}">
                            <label class="form-label">Cancel Reason</label>
                            <textarea name="cancel_reason" class="form-input" rows="3" 
                                      placeholder="Reason for cancellation...">{{ $order->cancel_reason }}</textarea>
                        </div>

                        <button type="submit" class="btn-update">
                            <i class="fas fa-save"></i> Update Status
                        </button>
                    </form>
                </div>
            </div>

        </div>

        {{-- RIGHT COLUMN --}}
        <div class="col-right">

            {{-- Customer Info --}}
            <div class="card">
                <div class="card-header">
                    <h2><i class="fas fa-user"></i> Customer</h2>
                </div>
                <div class="card-body">
                    <div class="customer-profile">
                        <div class="customer-avatar">
                            {{ strtoupper(substr($order->user->name ?? 'G', 0, 1)) }}
                        </div>
                        <div>
                            <strong>{{ $order->user->name ?? 'Guest' }}</strong>
                            <p>{{ $order->user->email ?? 'N/A' }}</p>
                            @if($order->user)
                                <a href="mailto:{{ $order->user->email }}" class="contact-link">
                                    <i class="fas fa-envelope"></i> Send Email
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- Payment Info --}}
            <div class="card">
                <div class="card-header">
                    <h2><i class="fas fa-credit-card"></i> Payment</h2>
                </div>
                <div class="card-body">
                    <div class="info-rows">
                        <div class="info-row">
                            <span class="info-label">Method</span>
                            <span class="info-value">{{ ucfirst($order->payment_method ?? 'N/A') }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Status</span>
                            <span class="payment-badge payment-{{ $order->payment_status }}">
                                {{ ucfirst($order->payment_status ?? 'Unpaid') }}
                            </span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Amount</span>
                            <span class="info-value total-amount">${{ number_format($order->total_amount, 2) }}</span>
                        </div>
                    </div>

                    {{-- Update Payment --}}
                    <form action="{{ route('admin.orders.payment', $order->id) }}" method="POST" class="payment-form">
                        @csrf
                        <select name="payment_status" class="form-select">
                            <option value="unpaid" {{ $order->payment_status === 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                            <option value="paid" {{ $order->payment_status === 'paid' ? 'selected' : '' }}>Paid</option>
                        </select>
                        <button type="submit" class="btn-update-sm">
                            <i class="fas fa-check"></i> Update
                        </button>
                    </form>
                </div>
            </div>

            {{-- Shipping Address --}}
            <div class="card">
                <div class="card-header">
                    <h2><i class="fas fa-map-marker-alt"></i> Shipping Address</h2>
                </div>
                <div class="card-body">
                    @if($order->address)
                        <div class="address-box">
                            <i class="fas fa-home"></i>
                            <p>{{ $order->address }}</p>
                        </div>
                    @else
                        <p class="text-muted">No address provided.</p>
                    @endif
                </div>
            </div>

            {{-- Cancel Reason (if cancelled) --}}
            @if($order->status === 'cancelled' && $order->cancel_reason)
            <div class="card card-danger">
                <div class="card-header">
                    <h2><i class="fas fa-ban"></i> Cancel Reason</h2>
                </div>
                <div class="card-body">
                    <p>{{ $order->cancel_reason }}</p>
                </div>
            </div>
            @endif

        </div>
    </div>

</main>

{{-- ===== STYLES ===== --}}
<style>
/* Layout */
.page-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 28px;
    flex-wrap: wrap;
    gap: 16px;
}
.header-left .back-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    color: #667eea;
    font-size: 14px;
    text-decoration: none;
    margin-bottom: 10px;
    font-weight: 600;
    transition: gap 0.2s;
}
.header-left .back-btn:hover { gap: 12px; }
.header-left h1 {
    font-size: 28px;
    color: #2d3748;
    margin: 0 0 4px;
    display: flex;
    align-items: center;
    gap: 10px;
}
.header-left h1 i { color: #667eea; }
.header-left h1 span { color: #667eea; }
.header-left p { color: #718096; font-size: 14px; margin: 0; }
.header-right {
    display: flex;
    align-items: center;
    gap: 12px;
    flex-wrap: wrap;
}
.btn-print {
    padding: 10px 20px;
    background: #edf2f7;
    color: #4a5568;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    font-size: 14px;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 8px;
    transition: all 0.2s;
}
.btn-print:hover { background: #e2e8f0; }

/* Status Pill */
.status-pill {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 8px 16px;
    border-radius: 20px;
    font-size: 13px;
    font-weight: 700;
    text-transform: capitalize;
}
.status-pill i { font-size: 8px; }
.status-pending    { background: #fefcbf; color: #744210; }
.status-confirmed  { background: #bee3f8; color: #2a4365; }
.status-processing { background: #e9d8fd; color: #44337a; }
.status-shipped    { background: #c6f6d5; color: #1c4532; }
.status-delivered  { background: #c6f6d5; color: #1c4532; }
.status-cancelled  { background: #fed7d7; color: #742a2a; }

/* Alerts */
.alert {
    padding: 14px 18px;
    border-radius: 10px;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 14px;
    font-weight: 500;
}
.alert-success { background: #c6f6d5; color: #22543d; }
.alert-danger  { background: #fed7d7; color: #742a2a; }

/* Grid */
.order-grid {
    display: grid;
    grid-template-columns: 1fr 380px;
    gap: 24px;
    align-items: start;
}
@media (max-width: 1024px) {
    .order-grid { grid-template-columns: 1fr; }
}

/* Cards */
.card {
    background: #fff;
    border-radius: 14px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.07);
    margin-bottom: 24px;
    overflow: hidden;
    border: 1px solid #f0f0f0;
}
.card-danger { border-left: 4px solid #fc8181; }
.card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 18px 22px;
    border-bottom: 1px solid #f0f4f8;
    background: #fafbfc;
}
.card-header h2 {
    font-size: 16px;
    font-weight: 700;
    color: #2d3748;
    display: flex;
    align-items: center;
    gap: 8px;
    margin: 0;
}
.card-header h2 i { color: #667eea; }
.card-header .badge {
    background: #ebf4ff;
    color: #3182ce;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
}
.card-body { padding: 22px; }
.no-pad { padding: 0; }

/* Items Table */
.items-table {
    width: 100%;
    border-collapse: collapse;
}
.items-table th {
    padding: 12px 16px;
    text-align: left;
    font-size: 12px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: #718096;
    background: #f7fafc;
    border-bottom: 1px solid #e2e8f0;
}
.items-table td {
    padding: 16px;
    border-bottom: 1px solid #f0f4f8;
    font-size: 14px;
    color: #2d3748;
    vertical-align: middle;
}
.items-table tbody tr:last-child td { border-bottom: none; }
.items-table tbody tr:hover { background: #fafbff; }

.product-cell {
    display: flex;
    align-items: center;
    gap: 12px;
}
.product-thumb {
    width: 52px;
    height: 52px;
    border-radius: 8px;
    object-fit: cover;
    border: 1px solid #e2e8f0;
}
.product-thumb-placeholder {
    width: 52px;
    height: 52px;
    border-radius: 8px;
    background: #edf2f7;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #a0aec0;
    font-size: 18px;
    flex-shrink: 0;
}
.product-cell strong { display: block; font-size: 14px; color: #2d3748; }
.product-cell small  { display: block; font-size: 12px; color: #718096; margin-top: 2px; }

.qty-badge {
    display: inline-block;
    width: 32px;
    height: 32px;
    line-height: 32px;
    text-align: center;
    border-radius: 8px;
    background: #edf2f7;
    font-weight: 700;
    font-size: 14px;
    color: #4a5568;
}
.empty-row {
    text-align: center;
    padding: 40px !important;
    color: #a0aec0;
}

/* Order Summary */
.order-summary {
    padding: 16px 22px;
    background: #fafbfc;
    border-top: 1px solid #e2e8f0;
}
.summary-row {
    display: flex;
    justify-content: space-between;
    padding: 8px 0;
    font-size: 14px;
    color: #4a5568;
    border-bottom: 1px dashed #e2e8f0;
}
.summary-row:last-child { border-bottom: none; }
.summary-row.discount span:last-child { color: #48bb78; font-weight: 600; }
.summary-row.total {
    font-size: 17px;
    font-weight: 800;
    color: #2d3748;
    padding-top: 14px;
    margin-top: 4px;
    border-top: 2px solid #e2e8f0;
    border-bottom: none;
}

/* Status Steps */
.status-steps {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 10px;
    margin-bottom: 20px;
}
.step-label {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 6px;
    cursor: pointer;
    padding: 12px 8px;
    border-radius: 10px;
    border: 2px solid #e2e8f0;
    transition: all 0.2s;
    background: #fff;
}
.step-label:hover { border-color: #667eea; background: #f0f4ff; }
.step-label input[type="radio"] { display: none; }
.step-dot {
    width: 14px;
    height: 14px;
    border-radius: 50%;
    border: 2px solid #cbd5e0;
    background: #fff;
    transition: all 0.2s;
}
.step-name { font-size: 12px; font-weight: 600; color: #718096; text-transform: capitalize; }
.step-label.active {
    border-color: #667eea;
    background: #f0f4ff;
}
.step-label.active .step-dot {
    background: #667eea;
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102,126,234,0.2);
}
.step-label.active .step-name { color: #667eea; }

/* Cancel Reason Box */
#cancelReasonBox { margin-bottom: 16px; }
.form-label { display: block; font-size: 13px; font-weight: 600; color: #4a5568; margin-bottom: 8px; }
.form-input {
    width: 100%;
    padding: 10px 14px;
    border: 2px solid #e2e8f0;
    border-radius: 8px;
    font-size: 14px;
    resize: vertical;
    transition: border-color 0.2s;
    box-sizing: border-box;
}
.form-input:focus { outline: none; border-color: #667eea; }
.form-select {
    flex: 1;
    padding: 10px 14px;
    border: 2px solid #e2e8f0;
    border-radius: 8px;
    font-size: 14px;
    cursor: pointer;
    background: #fff;
}
.form-select:focus { outline: none; border-color: #667eea; }

/* Buttons */
.btn-update {
    width: 100%;
    padding: 12px;
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: #fff;
    border: none;
    border-radius: 10px;
    font-weight: 700;
    font-size: 15px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    transition: opacity 0.2s, transform 0.2s;
}
.btn-update:hover { opacity: 0.92; transform: translateY(-1px); }

/* Customer Profile */
.customer-profile {
    display: flex;
    align-items: flex-start;
    gap: 16px;
}
.customer-avatar {
    width: 52px;
    height: 52px;
    border-radius: 50%;
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: #fff;
    font-size: 22px;
    font-weight: 800;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
.customer-profile strong { display: block; font-size: 16px; color: #2d3748; margin-bottom: 4px; }
.customer-profile p { font-size: 13px; color: #718096; margin: 0 0 6px; }
.contact-link {
    font-size: 13px;
    color: #667eea;
    text-decoration: none;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}
.contact-link:hover { text-decoration: underline; }

/* Info Rows */
.info-rows { margin-bottom: 16px; }
.info-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 0;
    border-bottom: 1px solid #f0f4f8;
    font-size: 14px;
}
.info-row:last-child { border-bottom: none; }
.info-label { color: #718096; font-weight: 500; }
.info-value { color: #2d3748; font-weight: 600; }
.total-amount { color: #667eea; font-size: 17px; font-weight: 800; }

/* Payment Badge */
.payment-badge {
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 700;
    text-transform: capitalize;
}
.payment-paid   { background: #c6f6d5; color: #22543d; }
.payment-unpaid { background: #fed7d7; color: #742a2a; }

/* Payment Form */
.payment-form {
    display: flex;
    gap: 10px;
    align-items: center;
    margin-top: 4px;
}
.btn-update-sm {
    padding: 10px 18px;
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: #fff;
    border: none;
    border-radius: 8px;
    font-weight: 700;
    font-size: 13px;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 6px;
    white-space: nowrap;
    transition: opacity 0.2s;
}
.btn-update-sm:hover { opacity: 0.88; }

/* Address Box */
.address-box {
    display: flex;
    gap: 14px;
    align-items: flex-start;
}
.address-box i { color: #667eea; font-size: 18px; margin-top: 2px; flex-shrink: 0; }
.address-box p { margin: 0; font-size: 14px; color: #4a5568; line-height: 1.6; }
.text-muted { color: #a0aec0; font-size: 14px; }

/* Print */
@media print {
    .btn-print, .btn-update, .btn-update-sm, .payment-form, .back-btn { display: none !important; }
    .card { box-shadow: none; border: 1px solid #ddd; }
}
</style>

{{-- ===== SCRIPT ===== --}}
<script>
document.addEventListener('DOMContentLoaded', function () {

    // Show cancel reason box when "cancelled" is selected
    const radios = document.querySelectorAll('input[name="status"]');
    const cancelBox = document.getElementById('cancelReasonBox');

    radios.forEach(radio => {
        radio.addEventListener('change', function () {
            cancelBox.style.display = this.value === 'cancelled' ? 'block' : 'none';
        });

        // Trigger active style on load
        if (radio.checked) {
            radio.closest('.step-label').classList.add('active');
        }

        radio.addEventListener('change', function () {
            document.querySelectorAll('.step-label').forEach(l => l.classList.remove('active'));
            this.closest('.step-label').classList.add('active');
        });
    });
});
</script>

@endsection