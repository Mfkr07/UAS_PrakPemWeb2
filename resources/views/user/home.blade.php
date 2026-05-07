@extends('layouts.dashboard')

@section('styles')
    <style>
        .page-title {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 0.25rem;
        }

        .page-subtitle {
            font-size: 0.875rem;
            color: var(--text-muted);
            margin-bottom: 2.5rem;
        }

        /* Empty State */
        .empty-state {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 40vh;
            text-align: center;
            background-color: var(--bg-card);
            border: 1px dashed var(--border-color);
            border-radius: 12px;
            margin-bottom: 4rem;
            padding: 3rem;
        }

        .empty-icon {
            width: 64px;
            height: 64px;
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
            fill: var(--text-muted);
        }

        .empty-title {
            font-size: 1.25rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
        }

        .empty-desc {
            font-size: 0.875rem;
            color: var(--text-muted);
            margin-bottom: 2rem;
            max-width: 400px;
        }

        .btn-book {
            background-color: var(--purple-light);
            color: var(--bg-dark);
            border: none;
            padding: 0.875rem 2rem;
            border-radius: 4px;
            font-weight: 800;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            cursor: pointer;
            transition: background 0.2s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-book:hover {
            background-color: #d8b4fe;
        }

        /* Booking Cards Grid */
        .bookings-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(400px, 1fr));
            gap: 1.5rem;
            margin-bottom: 3rem;
        }

        .booking-card {
            background: linear-gradient(135deg, rgba(21, 17, 28, 1) 0%, rgba(15, 11, 21, 1) 100%);
            border: 1px solid var(--border-color);
            border-radius: 10px;
            overflow: hidden;
            position: relative;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
            transition: all 0.25s ease;
        }

        .booking-card:hover {
            border-color: rgba(168, 85, 247, 0.3);
            box-shadow: 0 12px 32px rgba(0, 0, 0, 0.3);
        }

        .booking-card::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            width: 4px;
            height: 100%;
        }

        .booking-card.status-booked::before {
            background: linear-gradient(to bottom, #f59e0b, #d97706);
        }

        .booking-card.status-active::before {
            background: linear-gradient(to bottom, #10b981, #059669);
        }

        .booking-card-inner {
            padding: 1.75rem;
        }

        .booking-card-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1.25rem;
        }

        .booking-code {
            font-size: 0.6rem;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 2px;
            font-weight: 800;
            margin-bottom: 0.25rem;
        }

        .booking-code-value {
            font-size: 1.125rem;
            font-weight: 800;
            color: var(--purple-light);
        }

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
            background-color: rgba(245, 158, 11, 0.1);
            color: #f59e0b;
            border: 1px solid rgba(245, 158, 11, 0.2);
        }

        .badge-booked::before {
            background-color: #f59e0b;
        }

        .badge-active {
            background-color: rgba(16, 185, 129, 0.1);
            color: #10b981;
            border: 1px solid rgba(16, 185, 129, 0.2);
        }

        .badge-active::before {
            background-color: #10b981;
            box-shadow: 0 0 8px #10b981;
            animation: pulse 1.5s infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.3; }
        }

        .booking-detail-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
            margin-bottom: 1.25rem;
        }

        .detail-label {
            font-size: 0.6rem;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 800;
            margin-bottom: 0.25rem;
        }

        .detail-value {
            font-size: 0.95rem;
            font-weight: 700;
            color: var(--text-main);
        }

        .detail-value.cyan {
            color: #06b6d4;
        }

        .detail-value.amber {
            color: #f59e0b;
        }

        .booking-card-footer {
            display: flex;
            gap: 0.75rem;
            padding-top: 1rem;
            border-top: 1px dashed rgba(255, 255, 255, 0.08);
        }

        .btn-card {
            flex: 1;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.4rem;
            padding: 0.65rem 1rem;
            border-radius: 4px;
            font-size: 0.7rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            border: none;
        }

        .btn-card svg {
            width: 14px;
            height: 14px;
            fill: currentColor;
        }

        .btn-card-receipt {
            background: rgba(168, 85, 247, 0.1);
            color: var(--purple-light);
            border: 1px solid rgba(168, 85, 247, 0.2);
        }

        .btn-card-receipt:hover {
            background: rgba(168, 85, 247, 0.2);
            color: #d8b4fe;
        }

        .btn-card-cancel {
            background: transparent;
            color: var(--text-muted);
            border: 1px solid var(--border-color);
        }

        .btn-card-cancel:hover {
            background: rgba(239, 68, 68, 0.1);
            color: #ef4444;
            border-color: rgba(239, 68, 68, 0.3);
        }

        /* History Section */
        .section-title {
            font-size: 1.125rem;
            font-weight: 700;
            margin-bottom: 1.25rem;
        }

        .history-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 1rem;
        }

        .history-card {
            background-color: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 1.25rem;
            display: flex;
            align-items: center;
            gap: 1.25rem;
            text-decoration: none;
            color: inherit;
            transition: all 0.2s;
        }

        .history-card:hover {
            border-color: rgba(168, 85, 247, 0.3);
        }

        .history-icon {
            width: 44px;
            height: 44px;
            border-radius: 8px;
            background-color: rgba(255, 255, 255, 0.05);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .history-icon svg {
            width: 20px;
            height: 20px;
            fill: var(--text-muted);
        }

        .history-details {
            flex-grow: 1;
        }

        .history-id {
            font-size: 0.625rem;
            font-weight: 800;
            color: var(--text-muted);
            margin-bottom: 0.25rem;
        }

        .history-time {
            font-size: 0.75rem;
            color: var(--text-muted);
        }

        .history-pc {
            font-size: 0.875rem;
            font-weight: 700;
            margin-bottom: 0.25rem;
            text-align: right;
        }

        .history-status {
            font-size: 0.625rem;
            color: var(--text-muted);
            text-align: right;
        }
    </style>
@endsection

@section('content')

    @if(session('success'))
        <div
            style="background: rgba(16, 185, 129, 0.1); color: #10b981; padding: 1rem; border-radius: 8px; margin-bottom: 2rem; font-size: 0.875rem; border: 1px solid rgba(16, 185, 129, 0.2);">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div
            style="background: rgba(239, 68, 68, 0.1); color: #ef4444; padding: 1rem; border-radius: 8px; margin-bottom: 2rem; font-size: 0.875rem; border: 1px solid rgba(239, 68, 68, 0.2);">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
        </div>
    @endif

    <h1 class="page-title">Selamat Datang, {{ auth()->user()->name }}</h1>
    <p class="page-subtitle">Kelola booking dan pantau sesi bermain Anda.</p>

    @if($activeBookings->count() === 0)
        <div class="empty-state">
            <div class="empty-icon">
                <svg viewBox="0 0 24 24">
                    <path
                        d="M21 2H3c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h7v2H8v2h8v-2h-2v-2h7c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm0 14H3V4h18v12z" />
                </svg>
            </div>
            <div class="empty-title">Tidak Ada Booking Aktif</div>
            <div class="empty-desc">Anda belum memiliki booking. Pesan PC sekarang untuk memulai sesi bermain.</div>
            <a href="{{ route('billing') }}" class="btn-book">
                <svg viewBox="0 0 24 24" width="18" height="18" fill="currentColor">
                    <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z" />
                </svg>
                BOOKING PC SEKARANG
            </a>
        </div>
    @else
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
            <h2 class="section-title" style="margin-bottom: 0;">Booking Aktif Saya</h2>
            <a href="{{ route('billing') }}" class="btn-book" style="padding: 0.65rem 1.25rem; font-size: 0.75rem;">
                <svg viewBox="0 0 24 24" width="14" height="14" fill="currentColor">
                    <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z" />
                </svg>
                TAMBAH BOOKING
            </a>
        </div>

        <div class="bookings-grid">
            @foreach($activeBookings as $booking)
                <div class="booking-card status-{{ $booking->status }}">
                    <div class="booking-card-inner">
                        <div class="booking-card-header">
                            <div>
                                <div class="booking-code">KODE BOOKING</div>
                                <div class="booking-code-value">#WA-{{ str_pad($booking->id, 4, '0', STR_PAD_LEFT) }}</div>
                            </div>
                            @if($booking->status === 'booked')
                                <span class="status-badge badge-booked">Menunggu Check-In</span>
                            @else
                                <span class="status-badge badge-active">Sedang Bermain</span>
                            @endif
                        </div>

                        <div class="booking-detail-grid">
                            <div>
                                <div class="detail-label">Stasiun</div>
                                <div class="detail-value">{{ $booking->computer->name ?? 'Dihapus' }}</div>
                            </div>
                            <div>
                                <div class="detail-label">Durasi</div>
                                <div class="detail-value cyan">{{ $booking->duration_hours }} Jam</div>
                            </div>
                            <div>
                                <div class="detail-label">Waktu Mulai</div>
                                <div class="detail-value">{{ $booking->start_time->format('d M, H:i') }}</div>
                            </div>
                            <div>
                                <div class="detail-label">Waktu Selesai</div>
                                <div class="detail-value">{{ $booking->end_time->format('d M, H:i') }}</div>
                            </div>
                        </div>

                        <div style="margin-bottom: 1rem;">
                            <div class="detail-label">Total Dibayar</div>
                            <div class="detail-value amber">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</div>
                        </div>

                        <div class="booking-card-footer">
                            <a href="{{ route('booking.receipt', $booking->id) }}" class="btn-card btn-card-receipt">
                                <svg viewBox="0 0 24 24"><path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z"/></svg>
                                Lihat Struk
                            </a>
                            @if($booking->status === 'booked')
                                <form action="{{ route('booking.cancel', $booking->id) }}" method="POST" style="flex: 1;">
                                    @csrf
                                    <button type="submit" class="btn-card btn-card-cancel" style="width: 100%;" onclick="return confirm('Yakin ingin membatalkan? Saldo TIDAK akan dikembalikan.')">
                                        <svg viewBox="0 0 24 24"><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/></svg>
                                        Batalkan
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <h2 class="section-title">Riwayat Tiket</h2>
    <div class="history-grid">
        @forelse($historyBookings as $history)
            <a href="{{ route('booking.receipt', $history->id) }}" class="history-card">
                <div class="history-icon"><svg viewBox="0 0 24 24">
                        <path
                            d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67z" />
                    </svg></div>
                <div class="history-details">
                    <div class="history-id">#WA-{{ str_pad($history->id, 4, '0', STR_PAD_LEFT) }}</div>
                    <div class="history-time">{{ $history->created_at->diffForHumans() }}</div>
                </div>
                <div>
                    <div class="history-pc">{{ $history->computer->name ?? '-' }}</div>
                    <div class="history-status">{{ ucfirst($history->status) }}</div>
                </div>
            </a>
        @empty
            <div style="color: var(--text-muted); font-size: 0.875rem;">Belum ada riwayat pesanan.</div>
        @endforelse
    </div>

@endsection