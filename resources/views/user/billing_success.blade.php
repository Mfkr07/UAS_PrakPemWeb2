@extends('layouts.dashboard')

@section('styles')
    <style>
        .success-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 70vh;
            text-align: center;
        }

        .success-icon {
            width: 64px;
            height: 64px;
            background-color: rgba(16, 185, 129, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 2rem;
            box-shadow: 0 0 30px rgba(16, 185, 129, 0.2);
        }

        .success-icon svg {
            width: 32px;
            height: 32px;
            fill: #10b981;
        }

        .success-title {
            font-size: 2rem;
            font-weight: 800;
            margin-bottom: 1rem;
            letter-spacing: -0.5px;
        }

        .success-desc {
            font-size: 0.875rem;
            color: var(--text-muted);
            max-width: 450px;
            line-height: 1.6;
            margin-bottom: 3rem;
        }

        .receipt-card {
            background-color: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(6, 182, 212, 0.3);
            border-radius: 12px;
            width: 100%;
            max-width: 550px;
            padding: 2.5rem;
            box-shadow: 0 0 20px rgba(6, 182, 212, 0.05);
            margin-bottom: 3rem;
            text-align: left;
        }

        .receipt-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px dashed rgba(255, 255, 255, 0.1);
            padding-bottom: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .order-label {
            font-size: 0.625rem;
            font-weight: 800;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 0.25rem;
        }

        .order-id {
            font-size: 1.25rem;
            font-weight: 800;
            color: var(--text-main);
        }

        .status-badge {
            background-color: rgba(245, 158, 11, 0.1);
            color: #f59e0b;
            border: 1px solid rgba(245, 158, 11, 0.2);
            padding: 0.35rem 0.75rem;
            border-radius: 4px;
            font-size: 0.625rem;
            font-weight: 800;
            text-transform: uppercase;
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
        }

        .status-badge::before {
            content: '';
            width: 6px;
            height: 6px;
            background-color: #f59e0b;
            border-radius: 50%;
        }

        .receipt-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
            margin-bottom: 2.5rem;
        }

        .receipt-val {
            font-size: 1.125rem;
            font-weight: 800;
            color: var(--text-main);
        }

        .receipt-val.highlight {
            color: #f59e0b;
        }

        .info-box {
            background-color: rgba(255, 255, 255, 0.03);
            border-radius: 8px;
            padding: 1.25rem;
            display: flex;
            gap: 1rem;
            align-items: flex-start;
        }

        .info-box svg {
            width: 20px;
            height: 20px;
            fill: var(--purple-light);
            flex-shrink: 0;
        }

        .info-box p {
            font-size: 0.75rem;
            color: var(--text-muted);
            line-height: 1.5;
            margin: 0;
        }

        .btn-action {
            background-color: var(--purple-light);
            color: var(--bg-dark);
            border: none;
            padding: 1rem 3rem;
            border-radius: 4px;
            font-weight: 800;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            cursor: pointer;
            transition: background 0.2s;
            text-decoration: none;
            display: inline-flex;
            justify-content: center;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1.5rem;
        }

        .btn-action:hover {
            background-color: #d8b4fe;
            color: var(--bg-dark);
        }

        .btn-link {
            color: var(--text-muted);
            text-decoration: none;
            font-size: 0.75rem;
            font-weight: 700;
            transition: color 0.2s;
        }

        .btn-link:hover {
            color: var(--text-main);
        }
    </style>
@endsection

@section('content')
    <div class="success-container">
        <div class="success-icon">
            <svg viewBox="0 0 24 24">
                <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z" />
            </svg>
        </div>

        <h1 class="success-title">Transaksi Berhasil!</h1>
        <p class="success-desc">Stasiun pertempuran Anda sudah disiapkan. Saldo Wallet berhasil dipotong.</p>

        <div class="receipt-card">
            <div class="receipt-header">
                <div>
                    <div class="order-label">ORDER ID</div>
                    <div class="order-id">#WA-{{ str_pad($booking->id, 4, '0', STR_PAD_LEFT) }}</div>
                </div>
                <div class="status-badge">Menunggu Check-In</div>
            </div>

            <div class="receipt-grid">
                <div>
                    <div class="order-label">Rig Terpilih</div>
                    <div class="receipt-val">{{ $booking->computer->name ?? '-' }}</div>
                </div>
                <div>
                    <div class="order-label">Amunisi Tambahan</div>
                    <div class="receipt-val" style="font-size: 0.875rem;">
                        @forelse($booking->canteenItems as $item)
                            {{ $item->quantity }}x {{ $item->canteenItem->name }}<br>
                        @empty
                            -
                        @endforelse
                    </div>
                </div>
                <div>
                    <div class="order-label">Durasi Sesi</div>
                    <div class="receipt-val">
                        {{ $booking->package_type === 'night' ? 'Paket Malam' : $booking->duration_hours . ' Jam' }}</div>
                </div>
                <div>
                    <div class="order-label">Total Dibayar</div>
                    <div class="receipt-val highlight">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</div>
                </div>
            </div>

            <div class="info-box">
                <svg viewBox="0 0 24 24">
                    <path
                        d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z" />
                </svg>
                <p>Silakan menuju ke {{ $booking->computer->name ?? 'PC Anda' }} sesuai jadwal. Sesi Anda akan otomatis
                    berjalan pada waktu yang telah Anda tentukan.</p>
            </div>
        </div>

        <a href="{{ route('home') }}" class="btn-action" style="width: 100%; max-width: 550px;">CEK TIKET SAYA</a>
    </div>
@endsection