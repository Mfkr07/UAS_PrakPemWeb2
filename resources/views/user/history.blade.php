@extends('layouts.dashboard')

@section('styles')
    <style>
        .page-title {
            font-size: 1.5rem;
            font-weight: 800;
            margin-bottom: 0.25rem;
            letter-spacing: -0.5px;
        }

        .page-subtitle {
            font-size: 0.875rem;
            color: var(--text-muted);
            margin-bottom: 2.5rem;
        }

        /* Stats Bar */
        .stats-bar {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background-color: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 10px;
            padding: 1.25rem 1.5rem;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .stat-icon {
            width: 42px;
            height: 42px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .stat-icon svg {
            width: 20px;
            height: 20px;
            fill: currentColor;
        }

        .stat-icon.purple { background: rgba(168, 85, 247, 0.15); color: var(--purple-light); }
        .stat-icon.green { background: rgba(16, 185, 129, 0.15); color: #10b981; }
        .stat-icon.amber { background: rgba(245, 158, 11, 0.15); color: #f59e0b; }
        .stat-icon.red { background: rgba(239, 68, 68, 0.15); color: #ef4444; }

        .stat-label {
            font-size: 0.6rem;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 800;
            margin-bottom: 0.15rem;
        }

        .stat-value {
            font-size: 1.25rem;
            font-weight: 800;
        }

        /* Data Table Card */
        .data-card {
            background-color: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            overflow: hidden;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th {
            background: rgba(255, 255, 255, 0.02);
            padding: 1.25rem 1.5rem;
            text-align: left;
            font-size: 0.7rem;
            font-weight: 800;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 1px;
            border-bottom: 1px solid var(--border-color);
        }

        .table td {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.04);
            font-size: 0.875rem;
            vertical-align: middle;
        }

        .table tr:last-child td {
            border-bottom: none;
        }

        .table tbody tr {
            transition: background 0.15s;
        }

        .table tbody tr:hover {
            background: rgba(255, 255, 255, 0.015);
        }

        /* Order ID */
        .order-id {
            font-family: 'Courier New', monospace;
            font-weight: 800;
            font-size: 0.8rem;
            color: var(--purple-light);
        }

        /* PC Name */
        .pc-info {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .pc-icon-box {
            width: 34px;
            height: 34px;
            border-radius: 6px;
            background: rgba(168, 85, 247, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .pc-icon-box svg {
            width: 16px;
            height: 16px;
            fill: var(--purple-light);
        }

        .pc-name {
            font-weight: 700;
        }

        /* Time */
        .time-info {
            display: flex;
            flex-direction: column;
            gap: 0.15rem;
        }

        .time-main {
            font-weight: 600;
            font-size: 0.8rem;
        }

        .time-sub {
            font-size: 0.7rem;
            color: var(--text-muted);
        }

        /* Duration */
        .duration-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            padding: 0.3rem 0.65rem;
            background: rgba(6, 182, 212, 0.08);
            border: 1px solid rgba(6, 182, 212, 0.15);
            border-radius: 4px;
            font-size: 0.7rem;
            font-weight: 700;
            color: #06b6d4;
        }

        /* Status Badges */
        .status-badge {
            padding: 0.3rem 0.65rem;
            border-radius: 4px;
            font-size: 0.6rem;
            font-weight: 800;
            text-transform: uppercase;
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            letter-spacing: 0.5px;
        }

        .status-badge::before {
            content: '';
            width: 5px;
            height: 5px;
            border-radius: 50%;
        }

        .badge-booked {
            background: rgba(245, 158, 11, 0.1);
            color: #f59e0b;
            border: 1px solid rgba(245, 158, 11, 0.2);
        }

        .badge-booked::before { background: #f59e0b; }

        .badge-active {
            background: rgba(6, 182, 212, 0.1);
            color: #06b6d4;
            border: 1px solid rgba(6, 182, 212, 0.2);
        }

        .badge-active::before {
            background: #06b6d4;
            box-shadow: 0 0 6px #06b6d4;
            animation: pulse 1.5s infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.3; }
        }

        .badge-completed {
            background: rgba(16, 185, 129, 0.1);
            color: #10b981;
            border: 1px solid rgba(16, 185, 129, 0.2);
        }

        .badge-completed::before { background: #10b981; }

        .badge-cancelled {
            background: rgba(239, 68, 68, 0.1);
            color: #ef4444;
            border: 1px solid rgba(239, 68, 68, 0.2);
        }

        .badge-cancelled::before { background: #ef4444; }

        /* Price */
        .price {
            font-weight: 800;
            color: #10b981;
            white-space: nowrap;
        }

        /* Action Buttons */
        .btn-action {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            padding: 0.45rem 0.75rem;
            border-radius: 4px;
            font-size: 0.65rem;
            font-weight: 800;
            text-decoration: none;
            transition: all 0.2s;
            white-space: nowrap;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn-action svg {
            width: 12px;
            height: 12px;
            fill: currentColor;
        }

        .btn-struk {
            background: rgba(168, 85, 247, 0.1);
            color: var(--purple-light);
            border: 1px solid rgba(168, 85, 247, 0.2);
        }

        .btn-struk:hover {
            background: rgba(168, 85, 247, 0.2);
            color: #d8b4fe;
        }

        .btn-pdf {
            background: rgba(6, 182, 212, 0.08);
            color: #06b6d4;
            border: 1px solid rgba(6, 182, 212, 0.15);
        }

        .btn-pdf:hover {
            background: rgba(6, 182, 212, 0.2);
            color: #22d3ee;
        }

        /* Empty State */
        .empty-state {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 5rem 2rem;
            text-align: center;
        }

        .empty-icon {
            width: 72px;
            height: 72px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.02);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
        }

        .empty-icon svg {
            width: 32px;
            height: 32px;
            fill: rgba(255, 255, 255, 0.08);
        }

        .empty-title {
            font-size: 1rem;
            font-weight: 700;
            margin-bottom: 0.35rem;
            color: var(--text-muted);
        }

        .empty-desc {
            font-size: 0.8rem;
            color: rgba(255, 255, 255, 0.2);
        }

        @media (max-width: 768px) {
            .stats-bar { grid-template-columns: repeat(2, 1fr); }
        }
    </style>
@endsection

@section('content')
    <h1 class="page-title">Riwayat Booking</h1>
    <p class="page-subtitle">Rekap seluruh transaksi booking dan pesanan kantin Anda.</p>

    {{-- Stats Summary --}}
    @php
        $totalBookings = $bookings->count();
        $completedBookings = $bookings->where('status', 'completed')->count();
        $totalSpent = $bookings->sum('total_price');
        $cancelledBookings = $bookings->where('status', 'cancelled')->count();
    @endphp

    <div class="stats-bar">
        <div class="stat-card">
            <div class="stat-icon purple">
                <svg viewBox="0 0 24 24"><path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z"/></svg>
            </div>
            <div>
                <div class="stat-label">Total Booking</div>
                <div class="stat-value">{{ $totalBookings }}</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green">
                <svg viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>
            </div>
            <div>
                <div class="stat-label">Selesai</div>
                <div class="stat-value">{{ $completedBookings }}</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon amber">
                <svg viewBox="0 0 24 24"><path d="M11.8 10.9c-2.27-.59-3-1.2-3-2.15 0-1.09 1.01-1.85 2.7-1.85 1.78 0 2.44.85 2.5 2.1h2.21c-.07-1.72-1.12-3.3-3.21-3.81V3h-3v2.16c-1.94.42-3.5 1.68-3.5 3.61 0 2.31 1.91 3.46 4.7 4.13 2.5.6 3 1.48 3 2.41 0 .69-.49 1.79-2.7 1.79-2.06 0-2.87-.92-2.98-2.1h-2.2c.12 2.19 1.76 3.42 3.68 3.83V21h3v-2.15c1.95-.37 3.5-1.5 3.5-3.55 0-2.84-2.43-3.81-4.7-4.4z"/></svg>
            </div>
            <div>
                <div class="stat-label">Total Pengeluaran</div>
                <div class="stat-value" style="font-size: 1rem;">Rp {{ number_format($totalSpent, 0, ',', '.') }}</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon red">
                <svg viewBox="0 0 24 24"><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/></svg>
            </div>
            <div>
                <div class="stat-label">Dibatalkan</div>
                <div class="stat-value">{{ $cancelledBookings }}</div>
            </div>
        </div>
    </div>

    {{-- Data Table --}}
    <div class="data-card">
        <table class="table">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Stasiun</th>
                    <th>Jadwal</th>
                    <th>Durasi</th>
                    <th>Status</th>
                    <th>Total</th>
                    <th style="text-align: right;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bookings as $booking)
                    <tr>
                        <td>
                            <span class="order-id">#WA-{{ str_pad($booking->id, 4, '0', STR_PAD_LEFT) }}</span>
                        </td>
                        <td>
                            <div class="pc-info">
                                <div class="pc-icon-box">
                                    <svg viewBox="0 0 24 24"><path d="M21 2H3c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h7v2H8v2h8v-2h-2v-2h7c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm0 14H3V4h18v12z"/></svg>
                                </div>
                                <span class="pc-name">{{ $booking->computer->name ?? 'Dihapus' }}</span>
                            </div>
                        </td>
                        <td>
                            <div class="time-info">
                                <span class="time-main">{{ $booking->start_time->format('d M Y') }}</span>
                                <span class="time-sub">{{ $booking->start_time->format('H:i') }} — {{ $booking->end_time->format('H:i') }}</span>
                            </div>
                        </td>
                        <td>
                            <span class="duration-badge">{{ $booking->duration_hours }} Jam</span>
                        </td>
                        <td>
                            @if($booking->status === 'booked')
                                <span class="status-badge badge-booked">Booked</span>
                            @elseif($booking->status === 'active')
                                <span class="status-badge badge-active">Aktif</span>
                            @elseif($booking->status === 'completed')
                                <span class="status-badge badge-completed">Selesai</span>
                            @elseif($booking->status === 'cancelled')
                                <span class="status-badge badge-cancelled">Dibatalkan</span>
                            @endif
                        </td>
                        <td>
                            <span class="price">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
                        </td>
                        <td style="text-align: right;">
                            <div style="display: flex; gap: 0.5rem; justify-content: flex-end;">
                                <a href="{{ route('booking.receipt', $booking->id) }}" class="btn-action btn-struk" title="Lihat Struk">
                                    <svg viewBox="0 0 24 24"><path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z"/></svg>
                                    Struk
                                </a>
                                <a href="{{ route('booking.receipt.pdf', $booking->id) }}" class="btn-action btn-pdf" title="Download PDF">
                                    <svg viewBox="0 0 24 24"><path d="M19 9h-4V3H9v6H5l7 7 7-7zM5 18v2h14v-2H5z"/></svg>
                                    PDF
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <svg viewBox="0 0 24 24"><path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z"/></svg>
                                </div>
                                <div class="empty-title">Belum Ada Riwayat</div>
                                <div class="empty-desc">Riwayat booking Anda akan muncul di sini setelah melakukan pemesanan.</div>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
