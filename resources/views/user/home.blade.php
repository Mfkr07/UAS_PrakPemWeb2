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

        /* Tiket View */
        .ticket-card {
            background: linear-gradient(135deg, rgba(21, 17, 28, 1) 0%, rgba(15, 11, 21, 1) 100%);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            display: flex;
            overflow: hidden;
            margin-bottom: 4rem;
            position: relative;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .ticket-left {
            flex: 2;
            padding: 2.5rem;
            border-right: 1px dashed rgba(255, 255, 255, 0.1);
            position: relative;
        }

        .ticket-left::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            width: 4px;
            height: 100%;
            background: linear-gradient(to bottom, #f59e0b, #d97706);
        }

        .ticket-right {
            flex: 1;
            padding: 2.5rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background-color: rgba(0, 0, 0, 0.2);
        }

        .info-label {
            font-size: 0.625rem;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 0.5rem;
            font-weight: 800;
        }

        .info-value {
            font-size: 1.25rem;
            font-weight: 800;
            color: var(--text-main);
            margin-bottom: 2rem;
        }

        .info-sub {
            font-size: 0.75rem;
            color: var(--text-muted);
            font-weight: 500;
            display: block;
            margin-top: 0.25rem;
        }

        .ticket-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
            margin-bottom: 0;
        }

        .ticket-grid .info-value {
            margin-bottom: 0;
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
            position: absolute;
            top: 2.5rem;
            right: 2.5rem;
        }

        .status-badge::before {
            content: '';
            width: 6px;
            height: 6px;
            background-color: #f59e0b;
            border-radius: 50%;
        }

        .timer-label {
            font-size: 0.625rem;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 0.5rem;
            font-weight: 800;
            text-align: center;
        }

        .timer-value {
            font-size: 2rem;
            font-weight: 800;
            color: #f59e0b;
            margin-bottom: 1.5rem;
            text-align: center;
        }

        .btn-action {
            background-color: var(--purple-light);
            color: var(--bg-dark);
            border: none;
            padding: 0.875rem 1.5rem;
            border-radius: 4px;
            font-weight: 800;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            cursor: pointer;
            transition: background 0.2s;
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-action:hover {
            background-color: #d8b4fe;
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

        /* Online View */
        .online-view {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 60vh;
        }

        .online-card {
            background-color: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 4rem;
            text-align: center;
            width: 100%;
            max-width: 700px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.5);
        }

        .status-online {
            background-color: rgba(16, 185, 129, 0.1);
            color: #10b981;
            border: 1px solid rgba(16, 185, 129, 0.2);
            padding: 0.35rem 0.875rem;
            border-radius: 4px;
            font-size: 0.625rem;
            font-weight: 800;
            text-transform: uppercase;
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            margin-bottom: 2.5rem;
        }

        .status-online::before {
            content: '';
            width: 6px;
            height: 6px;
            background-color: #10b981;
            border-radius: 50%;
            box-shadow: 0 0 10px #10b981;
        }

        .huge-timer {
            font-size: 6rem;
            font-weight: 800;
            color: #06b6d4;
            text-shadow: 0 0 40px rgba(6, 182, 212, 0.4);
            margin-bottom: 3rem;
            font-variant-numeric: tabular-nums;
            line-height: 1;
            letter-spacing: -2px;
        }

        .user-info-row {
            display: flex;
            justify-content: center;
            gap: 5rem;
            margin-bottom: 3.5rem;
            padding-top: 2.5rem;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
        }

        .info-col {
            text-align: center;
        }

        .info-col .label {
            font-size: 0.625rem;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 800;
            margin-bottom: 0.5rem;
        }

        .info-col .val {
            font-size: 1.125rem;
            font-weight: 700;
        }

        .val-highlight {
            color: #f59e0b;
        }

        .action-row {
            display: flex;
            justify-content: center;
            gap: 1.25rem;
        }

        .btn-outline {
            background-color: transparent;
            color: var(--text-muted);
            border: 1px solid var(--border-color);
            padding: 0.875rem 1.5rem;
            border-radius: 4px;
            font-weight: 800;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-outline:hover {
            background-color: rgba(255, 255, 255, 0.05);
            color: var(--text-main);
        }

        .btn-outline.active-btn {
            color: var(--purple-light);
            border-color: var(--purple-main);
            background-color: rgba(168, 85, 247, 0.1);
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

    @if(!$activeBooking)
        <h1 class="page-title">Selamat Datang, {{ auth()->user()->name }}</h1>
        <p class="page-subtitle">Siap untuk memulai sesi permainan berikutnya?</p>

        <div class="empty-state">
            <div class="empty-icon">
                <svg viewBox="0 0 24 24">
                    <path
                        d="M21 2H3c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h7v2H8v2h8v-2h-2v-2h7c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm0 14H3V4h18v12z" />
                </svg>
            </div>
            <div class="empty-title">Tidak Ada Sesi Aktif</div>
            <div class="empty-desc">Anda belum memesan PC untuk sesi bermain saat ini. Pesan sekarang untuk mendapatkan PC
                favorit Anda.</div>
            <a href="{{ route('billing') }}" class="btn-book">
                <svg viewBox="0 0 24 24" width="18" height="18" fill="currentColor">
                    <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z" />
                </svg>
                BOOKING PC SEKARANG
            </a>
        </div>
    @elseif($activeBooking->status === 'pending')
        <!-- TICKET VIEW -->
        <h1 class="page-title">Tiket Saya</h1>
        <p class="page-subtitle">Kelola sesi bermain dan check-in PC Anda.</p>

        <div class="ticket-card">
            <div class="ticket-left">
                <div class="status-badge">Menunggu Check-In</div>

                <div class="info-label">KODE BOOKING</div>
                <div class="info-value" style="color: var(--purple-light);">
                    #WA-{{ str_pad($activeBooking->id, 4, '0', STR_PAD_LEFT) }}</div>

                <div class="ticket-grid">
                    <div>
                        <div class="info-label">STASIUN</div>
                        <div class="info-value">{{ $activeBooking->computer->name ?? 'Dihapus' }} <span class="info-sub">Area
                                Standard</span></div>
                    </div>
                    <div>
                        <div class="info-label">DURASI</div>
                        <div class="info-value" style="color: #06b6d4;">
                            {{ $activeBooking->package_type === 'night' ? 'Paket Malam' : $activeBooking->duration_hours . ' Jam' }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="ticket-right">
                <div class="timer-label">WAKTU MULAI SESI</div>
                <div class="timer-value" id="start-timer">{{ $activeBooking->start_time->format('H:i') }}</div>
                <div style="font-size: 0.75rem; color: var(--text-muted); text-align: center; margin-bottom: 1rem;">Sesi akan otomatis berjalan pada jadwal tersebut.</div>
                <form action="{{ route('user.cancel_booking', $activeBooking->id) }}" method="POST" style="width: 100%;">
                    @csrf
                    <button type="submit" class="btn-action" style="background-color: transparent; color: #ef4444; border: 1px solid rgba(239, 68, 68, 0.5); margin-top: 1rem;" onclick="return confirm('Yakin ingin membatalkan booking? Dana akan dikembalikan ke e-Wallet.')">
                        Batalkan Booking
                    </button>
                </form>
            </div>
        </div>
        <script>
            const startTimeStr = "{{ $activeBooking->start_time->toIso8601String() }}";
            const startTime = new Date(startTimeStr).getTime();

            const checkInInterval = setInterval(() => {
                const now = new Date().getTime();
                if (now >= startTime) {
                    clearInterval(checkInInterval);
                    window.location.reload();
                }
            }, 1000);
        </script>
    @else
        <!-- ONLINE VIEW -->
        <div class="online-view">
            <div class="online-card">
                <div class="status-online">STATUS ONLINE</div>
                <div class="huge-timer" id="session-timer">Loading...</div>

                <div class="user-info-row">
                    <div class="info-col">
                        <div class="label">USER</div>
                        <div class="val">{{ auth()->user()->name }}</div>
                    </div>
                    <div class="info-col">
                        <div class="label">PAKET AKTIF</div>
                        <div class="val val-highlight">
                            {{ $activeBooking->package_type === 'night' ? 'Paket Malam' : $activeBooking->duration_hours . ' Jam' }}
                        </div>
                    </div>
                </div>

                <div class="action-row">
                    <form action="{{ route('user.end_session', $activeBooking->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn-outline" style="color: #ef4444; border-color: rgba(239, 68, 68, 0.5);" onclick="return confirm('Yakin ingin mengakhiri sesi lebih awal?')">
                            <svg viewBox="0 0 24 24" width="16" height="16" fill="currentColor" style="margin-right: 4px;">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm-4-4h8V8H8v8z"/>
                            </svg>
                            Akhiri Sesi
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <script>
            // Actual server end time
            const endTimeStr = "{{ $activeBooking->end_time->toIso8601String() }}";
            const endTime = new Date(endTimeStr).getTime();

            const timerInterval = setInterval(() => {
                const now = new Date().getTime();
                const distance = endTime - now;

                if (distance <= 0) {
                    clearInterval(timerInterval);
                    document.getElementById('session-timer').innerText = "00:00:00";
                    // Optionally reload to let server handle completion
                    window.location.reload();
                    return;
                }

                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                const h = hours.toString().padStart(2, '0');
                const m = minutes.toString().padStart(2, '0');
                const s = seconds.toString().padStart(2, '0');

                document.getElementById('session-timer').innerText = `${h}:${m}:${s}`;
            }, 1000);
        </script>
    @endif

    @if(!$activeBooking || $activeBooking->status === 'pending')
        <h2 class="section-title">Riwayat Tiket</h2>
        <div class="history-grid">
            @forelse($historyBookings as $history)
                <div class="history-card">
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
                        <div class="history-status">Selesai</div>
                    </div>
                </div>
            @empty
                <div style="color: var(--text-muted); font-size: 0.875rem;">Belum ada riwayat pesanan.</div>
            @endforelse
        </div>
    @endif

@endsection