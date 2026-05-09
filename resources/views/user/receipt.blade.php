@extends('layouts.dashboard')

@section('styles')
    <style>
        .receipt-page {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 2rem 0;
        }

        .receipt-actions {
            display: flex;
            gap: 1rem;
            margin-bottom: 2rem;
            width: 100%;
            max-width: 520px;
        }

        .btn-download {
            flex: 1;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 0.875rem 1.5rem;
            border-radius: 6px;
            font-weight: 700;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            cursor: pointer;
            transition: all 0.25s ease;
            text-decoration: none;
            border: none;
        }

        .btn-download.primary {
            background: linear-gradient(135deg, #a855f7 0%, #7c3aed 100%);
            color: #ffffff;
            box-shadow: 0 4px 15px rgba(168, 85, 247, 0.3);
        }

        .btn-download.primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(168, 85, 247, 0.45);
            color: #ffffff;
        }

        .btn-download.secondary {
            background: transparent;
            color: var(--text-muted);
            border: 1px solid var(--border-color);
        }

        .btn-download.secondary:hover {
            background: rgba(255, 255, 255, 0.05);
            color: var(--text-main);
        }

        .btn-download svg {
            width: 16px;
            height: 16px;
            fill: currentColor;
        }

        /* Receipt Card */
        .receipt-card-container {
            width: 100%;
            max-width: 520px;
            background: linear-gradient(135deg, rgba(21, 17, 28, 1) 0%, rgba(15, 11, 21, 1) 100%);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.4);
            position: relative;
        }

        .receipt-card-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, #a855f7, #06b6d4, #f59e0b);
        }

        .receipt-inner {
            padding: 2.5rem;
        }

        /* Header */
        .receipt-brand {
            text-align: center;
            padding-bottom: 1.5rem;
            border-bottom: 1px dashed rgba(255, 255, 255, 0.1);
            margin-bottom: 1.5rem;
        }

        .receipt-brand-name {
            font-size: 1.5rem;
            font-weight: 900;
            color: var(--purple-light);
            letter-spacing: 3px;
            text-transform: uppercase;
            margin-bottom: 0.25rem;
        }

        .receipt-brand-sub {
            font-size: 0.6rem;
            color: var(--text-muted);
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        .receipt-badge {
            display: inline-block;
            background: rgba(168, 85, 247, 0.15);
            color: var(--purple-light);
            padding: 0.3rem 0.875rem;
            border-radius: 3px;
            font-size: 0.6rem;
            font-weight: 800;
            letter-spacing: 1px;
            text-transform: uppercase;
            margin-top: 0.875rem;
        }

        /* Order Section */
        .receipt-order {
            text-align: center;
            padding: 1.25rem 0;
            border-bottom: 1px dashed rgba(255, 255, 255, 0.1);
            margin-bottom: 1.5rem;
        }

        .receipt-order-label {
            font-size: 0.6rem;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 0.25rem;
            font-weight: 800;
        }

        .receipt-order-id {
            font-size: 1.5rem;
            font-weight: 900;
            color: var(--purple-light);
            letter-spacing: 1px;
        }

        .receipt-order-date {
            font-size: 0.75rem;
            color: var(--text-muted);
            margin-top: 0.5rem;
        }

        /* Section Title */
        .r-section-title {
            font-size: 0.6rem;
            font-weight: 800;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 0.875rem;
            padding-bottom: 0.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        .r-section {
            margin-bottom: 1.5rem;
        }

        /* Detail Row */
        .r-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.4rem 0;
        }

        .r-label {
            font-size: 0.8rem;
            color: var(--text-muted);
        }

        .r-value {
            font-size: 0.8rem;
            font-weight: 700;
            color: var(--text-main);
            text-align: right;
        }

        /* Items */
        .r-item {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding: 0.625rem 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.03);
        }

        .r-item:last-child {
            border-bottom: none;
        }

        .r-item-name {
            font-size: 0.8rem;
            font-weight: 700;
            color: var(--text-main);
            margin-bottom: 0.15rem;
        }

        .r-item-detail {
            font-size: 0.7rem;
            color: var(--text-muted);
        }

        .r-item-price {
            font-size: 0.8rem;
            font-weight: 700;
            color: var(--text-main);
            white-space: nowrap;
        }

        /* Totals */
        .r-totals {
            border-top: 2px dashed rgba(255, 255, 255, 0.1);
            padding-top: 1rem;
            margin-top: 0.5rem;
        }

        .r-subtotal {
            display: flex;
            justify-content: space-between;
            padding: 0.3rem 0;
        }

        .r-subtotal-label {
            font-size: 0.8rem;
            color: var(--text-muted);
        }

        .r-subtotal-value {
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--text-main);
        }

        .r-grand-total {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-top: 2px solid var(--purple-main);
            padding-top: 0.875rem;
            margin-top: 0.625rem;
        }

        .r-grand-label {
            font-size: 0.875rem;
            font-weight: 800;
            color: var(--text-main);
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .r-grand-value {
            font-size: 1.25rem;
            font-weight: 900;
            color: #f59e0b;
        }

        /* Payment Badge */
        .r-payment {
            text-align: center;
            margin: 1.25rem 0;
        }

        .r-payment-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            background: rgba(16, 185, 129, 0.1);
            color: #10b981;
            border: 1px solid rgba(16, 185, 129, 0.2);
            padding: 0.4rem 1rem;
            border-radius: 4px;
            font-size: 0.65rem;
            font-weight: 800;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .r-payment-badge::before {
            content: '✓';
            font-size: 0.75rem;
        }

        /* Status Badges */
        .r-status {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            padding: 0.25rem 0.625rem;
            border-radius: 3px;
            font-size: 0.6rem;
            font-weight: 800;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .r-status::before {
            content: '';
            width: 5px;
            height: 5px;
            border-radius: 50%;
        }

        .r-status-booked {
            background: rgba(245, 158, 11, 0.1);
            color: #f59e0b;
            border: 1px solid rgba(245, 158, 11, 0.2);
        }

        .r-status-booked::before {
            background: #f59e0b;
        }

        .r-status-active {
            background: rgba(6, 182, 212, 0.1);
            color: #06b6d4;
            border: 1px solid rgba(6, 182, 212, 0.2);
        }

        .r-status-active::before {
            background: #06b6d4;
        }

        .r-status-completed {
            background: rgba(16, 185, 129, 0.1);
            color: #10b981;
            border: 1px solid rgba(16, 185, 129, 0.2);
        }

        .r-status-completed::before {
            background: #10b981;
        }

        .r-status-cancelled {
            background: rgba(239, 68, 68, 0.1);
            color: #ef4444;
            border: 1px solid rgba(239, 68, 68, 0.2);
        }

        .r-status-cancelled::before {
            background: #ef4444;
        }

        /* Footer */
        .r-footer {
            text-align: center;
            border-top: 2px dashed rgba(255, 255, 255, 0.1);
            padding-top: 1.25rem;
            margin-top: 0.5rem;
        }

        .r-footer-text {
            font-size: 0.7rem;
            color: var(--text-muted);
            margin-bottom: 0.25rem;
        }

        .r-footer-brand {
            font-size: 0.75rem;
            font-weight: 800;
            color: var(--purple-light);
            letter-spacing: 2px;
            text-transform: uppercase;
        }
    </style>
@endsection

@section('content')
    <div class="receipt-page">

        {{-- Action Buttons --}}
        <div class="receipt-actions">
            <a href="{{ route('booking.receipt.pdf', $booking->id) }}" class="btn-download primary" id="btn-export-pdf">
                <svg viewBox="0 0 24 24"><path d="M19 9h-4V3H9v6H5l7 7 7-7zM5 18v2h14v-2H5z"/></svg>
                EXPORT PDF
            </a>
            <a href="{{ route('home') }}" class="btn-download secondary">
                <svg viewBox="0 0 24 24"><path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"/></svg>
                KEMBALI
            </a>
        </div>

        {{-- Receipt Card --}}
        <div class="receipt-card-container">
            <div class="receipt-inner">

                {{-- Brand Header --}}
                <div class="receipt-brand">
                    <div class="receipt-brand-name">WARNET ASOY</div>
                    <div class="receipt-brand-sub">Game Center & Internet Café</div>
                    <div class="receipt-badge">Struk Pembayaran</div>
                </div>

                {{-- Order ID --}}
                <div class="receipt-order">
                    <div class="receipt-order-label">Order ID</div>
                    <div class="receipt-order-id">#WA-{{ str_pad($booking->id, 4, '0', STR_PAD_LEFT) }}</div>
                    <div class="receipt-order-date">{{ $booking->created_at->format('d F Y, H:i') }} WIB</div>
                </div>

                {{-- Customer Info --}}
                <div class="r-section">
                    <div class="r-section-title">Informasi Pelanggan</div>
                    <div class="r-row">
                        <span class="r-label">Nama</span>
                        <span class="r-value">{{ $booking->user->name ?? 'Guest' }}</span>
                    </div>
                    <div class="r-row">
                        <span class="r-label">Email</span>
                        <span class="r-value">{{ $booking->user->email ?? '-' }}</span>
                    </div>
                    <div class="r-row">
                        <span class="r-label">Status</span>
                        <span class="r-value">
                            <span class="r-status r-status-{{ $booking->status }}">{{ ucfirst($booking->status) }}</span>
                        </span>
                    </div>
                </div>

                {{-- Booking Details --}}
                <div class="r-section">
                    <div class="r-section-title">Detail Booking</div>
                    <div class="r-row">
                        <span class="r-label">Stasiun / PC</span>
                        <span class="r-value">{{ $booking->computer->name ?? 'PC Dihapus' }}</span>
                    </div>
                    <div class="r-row">
                        <span class="r-label">Durasi</span>
                        <span class="r-value">{{ $booking->package_type === 'night' ? 'Paket Malam' : $booking->duration_hours . ' Jam' }}</span>
                    </div>
                    <div class="r-row">
                        <span class="r-label">Waktu Mulai</span>
                        <span class="r-value">{{ $booking->start_time ? $booking->start_time->format('d/m/Y H:i') : '-' }}</span>
                    </div>
                    <div class="r-row">
                        <span class="r-label">Waktu Selesai</span>
                        <span class="r-value">{{ $booking->end_time ? $booking->end_time->format('d/m/Y H:i') : '-' }}</span>
                    </div>
                </div>

                {{-- Rincian Biaya --}}
                <div class="r-section">
                    <div class="r-section-title">Rincian Biaya</div>

                    {{-- PC Rental --}}
                    <div class="r-item">
                        <div>
                            <div class="r-item-name">Sewa {{ $booking->computer->name ?? 'PC' }}</div>
                            <div class="r-item-detail">{{ $booking->duration_hours }} jam × Rp {{ number_format($booking->computer->price_per_hour ?? 0, 0, ',', '.') }}</div>
                        </div>
                        <div class="r-item-price">Rp {{ number_format(($booking->computer->price_per_hour ?? 0) * $booking->duration_hours, 0, ',', '.') }}</div>
                    </div>

                    {{-- Canteen Items --}}
                    @foreach($booking->canteenItems as $item)
                        <div class="r-item">
                            <div>
                                <div class="r-item-name">{{ $item->canteenItem->name ?? 'Item Dihapus' }}</div>
                                <div class="r-item-detail">{{ $item->quantity }}x × Rp {{ number_format($item->canteenItem->price ?? 0, 0, ',', '.') }}</div>
                            </div>
                            <div class="r-item-price">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</div>
                        </div>
                    @endforeach
                </div>

                {{-- Totals --}}
                @php
                    $pcCost = ($booking->computer->price_per_hour ?? 0) * $booking->duration_hours;
                    $canteenCost = $booking->canteenItems->sum('subtotal');
                @endphp
                <div class="r-totals">
                    <div class="r-subtotal">
                        <span class="r-subtotal-label">Subtotal Sewa PC</span>
                        <span class="r-subtotal-value">Rp {{ number_format($pcCost, 0, ',', '.') }}</span>
                    </div>
                    @if($canteenCost > 0)
                        <div class="r-subtotal">
                            <span class="r-subtotal-label">Subtotal Kantin</span>
                            <span class="r-subtotal-value">Rp {{ number_format($canteenCost, 0, ',', '.') }}</span>
                        </div>
                    @endif
                    <div class="r-grand-total">
                        <span class="r-grand-label">Total Bayar</span>
                        <span class="r-grand-value">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
                    </div>
                </div>

                {{-- Payment Badge --}}
                <div class="r-payment">
                    <div class="r-payment-badge">Dibayar via e-Wallet</div>
                </div>

                {{-- Footer --}}
                <div class="r-footer">
                    <div class="r-footer-text">Terima kasih telah bermain di</div>
                    <div class="r-footer-brand">WARNET ASOY</div>
                    <div class="r-footer-text" style="margin-top: 0.5rem;">Struk ini merupakan bukti pembayaran yang sah.</div>
                </div>

            </div>
        </div>

    </div>
@endsection
