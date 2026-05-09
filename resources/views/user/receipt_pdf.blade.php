<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Struk Booking #WA-{{ str_pad($booking->id, 4, '0', STR_PAD_LEFT) }}</title>
    <style>
        @page {
            margin: 0;
        }

        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 12px;
            color: #1a1a2e;
            margin: 0;
            padding: 0;
            background: #ffffff;
        }

        .receipt-wrapper {
            max-width: 400px;
            margin: 0 auto;
            padding: 40px 30px;
        }

        /* Header */
        .receipt-header {
            text-align: center;
            padding-bottom: 20px;
            border-bottom: 2px dashed #d1d5db;
            margin-bottom: 20px;
        }

        .brand-name {
            font-size: 22px;
            font-weight: 900;
            color: #7c3aed;
            letter-spacing: 3px;
            text-transform: uppercase;
            margin-bottom: 4px;
        }

        .brand-tagline {
            font-size: 9px;
            color: #9ca3af;
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-bottom: 12px;
        }

        .receipt-type {
            display: inline-block;
            background-color: #f3e8ff;
            color: #7c3aed;
            padding: 4px 14px;
            border-radius: 3px;
            font-size: 9px;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        /* Order ID Section */
        .order-section {
            text-align: center;
            padding: 16px 0;
            border-bottom: 1px dashed #e5e7eb;
            margin-bottom: 16px;
        }

        .order-label {
            font-size: 8px;
            color: #9ca3af;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 4px;
        }

        .order-id {
            font-size: 20px;
            font-weight: 800;
            color: #7c3aed;
            letter-spacing: 1px;
        }

        .order-date {
            font-size: 10px;
            color: #6b7280;
            margin-top: 6px;
        }

        /* Detail Sections */
        .section-title {
            font-size: 9px;
            font-weight: 700;
            color: #9ca3af;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 10px;
            padding-bottom: 6px;
            border-bottom: 1px solid #f3f4f6;
        }

        .detail-row {
            display: table;
            width: 100%;
            padding: 5px 0;
        }

        .detail-label {
            display: table-cell;
            color: #6b7280;
            font-size: 11px;
            width: 45%;
        }

        .detail-value {
            display: table-cell;
            text-align: right;
            font-weight: 600;
            font-size: 11px;
            color: #1a1a2e;
        }

        .section-block {
            margin-bottom: 18px;
        }

        /* Items Table */
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 6px;
        }

        .items-table th {
            font-size: 9px;
            color: #9ca3af;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 600;
            padding: 6px 0;
            border-bottom: 1px solid #e5e7eb;
            text-align: left;
        }

        .items-table th:last-child {
            text-align: right;
        }

        .items-table td {
            padding: 8px 0;
            font-size: 11px;
            border-bottom: 1px solid #f3f4f6;
        }

        .items-table td:last-child {
            text-align: right;
            font-weight: 600;
        }

        .item-name {
            font-weight: 600;
            color: #1a1a2e;
        }

        .item-qty {
            color: #6b7280;
            font-size: 10px;
        }

        /* Totals */
        .totals-section {
            border-top: 2px dashed #d1d5db;
            padding-top: 14px;
            margin-top: 14px;
        }

        .subtotal-row {
            display: table;
            width: 100%;
            padding: 4px 0;
        }

        .subtotal-label {
            display: table-cell;
            font-size: 11px;
            color: #6b7280;
        }

        .subtotal-value {
            display: table-cell;
            text-align: right;
            font-size: 11px;
            font-weight: 600;
            color: #1a1a2e;
        }

        .grand-total {
            display: table;
            width: 100%;
            padding: 12px 0;
            margin-top: 8px;
            border-top: 2px solid #7c3aed;
        }

        .grand-total-label {
            display: table-cell;
            font-size: 13px;
            font-weight: 800;
            color: #1a1a2e;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .grand-total-value {
            display: table-cell;
            text-align: right;
            font-size: 16px;
            font-weight: 900;
            color: #7c3aed;
        }

        /* Payment Info */
        .payment-badge {
            text-align: center;
            margin: 18px 0;
        }

        .payment-badge span {
            display: inline-block;
            background-color: #dcfce7;
            color: #16a34a;
            padding: 6px 16px;
            border-radius: 3px;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        /* Footer */
        .receipt-footer {
            text-align: center;
            border-top: 2px dashed #d1d5db;
            padding-top: 18px;
            margin-top: 10px;
        }

        .footer-text {
            font-size: 10px;
            color: #9ca3af;
            margin-bottom: 4px;
        }

        .footer-brand {
            font-size: 11px;
            font-weight: 700;
            color: #7c3aed;
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        .no-items {
            font-size: 11px;
            color: #9ca3af;
            font-style: italic;
            padding: 6px 0;
        }

        .status-badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 3px;
            font-size: 9px;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .status-booked {
            background-color: #fef3c7;
            color: #d97706;
        }

        .status-active {
            background-color: #dbeafe;
            color: #2563eb;
        }

        .status-completed {
            background-color: #dcfce7;
            color: #16a34a;
        }

        .status-cancelled {
            background-color: #fee2e2;
            color: #dc2626;
        }
    </style>
</head>
<body>
    <div class="receipt-wrapper">

        {{-- Header --}}
        <div class="receipt-header">
            <div class="brand-name">WARNET ASOY</div>
            <div class="brand-tagline">Game Center & Internet Café</div>
            <div class="receipt-type">Struk Pembayaran</div>
        </div>

        {{-- Order ID --}}
        <div class="order-section">
            <div class="order-label">Order ID</div>
            <div class="order-id">#WA-{{ str_pad($booking->id, 4, '0', STR_PAD_LEFT) }}</div>
            <div class="order-date">{{ $booking->created_at->format('d F Y, H:i') }} WIB</div>
        </div>

        {{-- Customer Info --}}
        <div class="section-block">
            <div class="section-title">Informasi Pelanggan</div>
            <div class="detail-row">
                <span class="detail-label">Nama</span>
                <span class="detail-value">{{ $booking->user->name ?? 'Guest' }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Email</span>
                <span class="detail-value">{{ $booking->user->email ?? '-' }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Status</span>
                <span class="detail-value">
                    <span class="status-badge status-{{ $booking->status }}">{{ ucfirst($booking->status) }}</span>
                </span>
            </div>
        </div>

        {{-- Booking Details --}}
        <div class="section-block">
            <div class="section-title">Detail Booking</div>
            <div class="detail-row">
                <span class="detail-label">Stasiun / PC</span>
                <span class="detail-value">{{ $booking->computer->name ?? 'PC Dihapus' }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Durasi</span>
                <span class="detail-value">{{ $booking->package_type === 'night' ? 'Paket Malam' : $booking->duration_hours . ' Jam' }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Waktu Mulai</span>
                <span class="detail-value">{{ $booking->start_time ? $booking->start_time->format('d/m/Y H:i') : '-' }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Waktu Selesai</span>
                <span class="detail-value">{{ $booking->end_time ? $booking->end_time->format('d/m/Y H:i') : '-' }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Tarif / Jam</span>
                <span class="detail-value">Rp {{ number_format($booking->computer->price_per_hour ?? 0, 0, ',', '.') }}</span>
            </div>
        </div>

        {{-- Rincian Biaya --}}
        <div class="section-block">
            <div class="section-title">Rincian Biaya</div>
            <table class="items-table">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th style="text-align: right;">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Rental PC --}}
                    <tr>
                        <td>
                            <div class="item-name">Sewa {{ $booking->computer->name ?? 'PC' }}</div>
                            <div class="item-qty">{{ $booking->duration_hours }} jam × Rp {{ number_format($booking->computer->price_per_hour ?? 0, 0, ',', '.') }}</div>
                        </td>
                        <td>Rp {{ number_format(($booking->computer->price_per_hour ?? 0) * $booking->duration_hours, 0, ',', '.') }}</td>
                    </tr>

                    {{-- Canteen Items --}}
                    @forelse($booking->canteenItems as $item)
                        <tr>
                            <td>
                                <div class="item-name">{{ $item->canteenItem->name ?? 'Item Dihapus' }}</div>
                                <div class="item-qty">{{ $item->quantity }}x × Rp {{ number_format($item->canteenItem->price ?? 0, 0, ',', '.') }}</div>
                            </td>
                            <td>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        {{-- No canteen items --}}
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Totals --}}
        <div class="totals-section">
            @php
                $pcCost = ($booking->computer->price_per_hour ?? 0) * $booking->duration_hours;
                $canteenCost = $booking->canteenItems->sum('subtotal');
            @endphp
            <div class="subtotal-row">
                <span class="subtotal-label">Subtotal Sewa PC</span>
                <span class="subtotal-value">Rp {{ number_format($pcCost, 0, ',', '.') }}</span>
            </div>
            @if($canteenCost > 0)
                <div class="subtotal-row">
                    <span class="subtotal-label">Subtotal Kantin</span>
                    <span class="subtotal-value">Rp {{ number_format($canteenCost, 0, ',', '.') }}</span>
                </div>
            @endif
            <div class="grand-total">
                <span class="grand-total-label">Total Bayar</span>
                <span class="grand-total-value">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
            </div>
        </div>

        {{-- Payment Method --}}
        <div class="payment-badge">
            <span>✓ Dibayar via e-Wallet</span>
        </div>

        {{-- Footer --}}
        <div class="receipt-footer">
            <div class="footer-text">Terima kasih telah bermain di</div>
            <div class="footer-brand">WARNET ASOY</div>
            <div class="footer-text" style="margin-top: 8px;">Struk ini merupakan bukti pembayaran yang sah.</div>
            <div class="footer-text">Dicetak pada: {{ now()->format('d/m/Y H:i') }} WIB</div>
        </div>

    </div>
</body>
</html>
