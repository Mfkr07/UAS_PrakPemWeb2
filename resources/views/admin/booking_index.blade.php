@extends('layouts.dashboard')

@section('styles')
<style>
    .page-title { font-size: 1.5rem; font-weight: 800; margin-bottom: 0.25rem; letter-spacing: -0.5px; }
    .page-subtitle { font-size: 0.875rem; color: var(--text-muted); margin-bottom: 2.5rem; }

    .data-card {
        background-color: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        overflow: hidden;
    }
    .table { width: 100%; border-collapse: collapse; }
    .table th { background: rgba(255,255,255,0.02); padding: 1.25rem 1.5rem; text-align: left; font-size: 0.75rem; font-weight: 800; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px; border-bottom: 1px solid var(--border-color); }
    .table td { padding: 1.25rem 1.5rem; border-bottom: 1px solid rgba(255,255,255,0.05); font-size: 0.875rem; vertical-align: middle; }
    .table tr:last-child td { border-bottom: none; }
    .table tbody tr:hover { background: rgba(255,255,255,0.01); }

    .user-info { display: flex; align-items: center; gap: 0.75rem; font-weight: 700; }
    .user-avatar { width: 32px; height: 32px; border-radius: 50%; background: rgba(168, 85, 247, 0.2); color: var(--purple-light); display: flex; align-items: center; justify-content: center; font-size: 0.75rem; }

    .pc-name { font-weight: 700; color: var(--text-main); }
    .price { font-weight: 800; color: #10b981; }
    .duration { font-size: 0.75rem; color: var(--text-muted); font-weight: 500; margin-top: 0.25rem; }
    .time { font-size: 0.75rem; color: var(--text-muted); font-family: monospace; }

    .status-badge {
        padding: 0.35rem 0.75rem;
        border-radius: 4px;
        font-size: 0.625rem;
        font-weight: 800;
        text-transform: uppercase;
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
    }
    .status-cleared { background-color: rgba(16, 185, 129, 0.1); color: #10b981; border: 1px solid rgba(16, 185, 129, 0.2); }
    .status-cleared::before { content: ''; width: 6px; height: 6px; background-color: #10b981; border-radius: 50%; }
    
    .btn-stop { background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.3); color: #ef4444; padding: 0.625rem 1rem; border-radius: 4px; font-size: 0.75rem; font-weight: 800; cursor: pointer; transition: all 0.2s; display: inline-flex; align-items: center; gap: 0.5rem; text-transform: uppercase; letter-spacing: 0.5px; }
    .btn-stop:hover { background: #ef4444; color: white; }
    .btn-stop svg { width: 14px; height: 14px; fill: currentColor; }
</style>
@endsection

@section('content')
<h1 class="page-title">Riwayat Billing</h1>
<p class="page-subtitle">Pantau PC yang sedang digunakan dan lihat rekaman transaksi masuk.</p>

<div class="data-card">
    <table class="table">
        <thead>
            <tr>
                <th>ID Order</th>
                <th>Penyewa</th>
                <th>Rig / PC</th>
                <th>Tarif Terbayar</th>
                <th>Waktu (Mulai - Selesai)</th>
                <th style="text-align: right;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($bookings as $booking)
                <tr>
                    <td style="color: var(--text-muted); font-family: monospace;">#WA-{{ str_pad($booking->id, 4, '0', STR_PAD_LEFT) }}</td>
                    <td>
                        <div class="user-info">
                            <div class="user-avatar">{{ substr($booking->user->name ?? 'G', 0, 1) }}</div>
                            {{ $booking->user->name ?? 'Guest' }}
                        </div>
                    </td>
                    <td class="pc-name">{{ $booking->computer->name ?? 'Dihapus' }}</td>
                    <td>
                        <div class="price">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</div>
                        <div class="duration">Durasi: {{ $booking->duration_hours }} Jam</div>
                    </td>
                    <td class="time">
                        {{ $booking->start_time ? $booking->start_time->format('d M Y, H:i') : '--:--' }} <br>
                        <span style="color: var(--purple-light);">sampai</span> <br>
                        {{ $booking->end_time ? $booking->end_time->format('d M Y, H:i') : '--:--' }}
                    </td>
                    <td style="text-align: right;">
                        @if($booking->status === 'active')
                            <form action="{{ route('admin.bookings.finish', $booking->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn-stop">
                                    <svg viewBox="0 0 24 24"><path d="M6 6h12v12H6z"/></svg>
                                    Force Stop
                                </button>
                            </form>
                        @elseif($booking->status === 'pending')
                            <span class="status-badge" style="background-color: rgba(245,158,11,0.1); color: #f59e0b; border: 1px solid rgba(245,158,11,0.2);">Pending</span>
                        @else
                            <span class="status-badge status-cleared">Cleared</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center; color: var(--text-muted); padding: 5rem;">
                        <svg viewBox="0 0 24 24" width="64" height="64" fill="rgba(255,255,255,0.05)" style="margin-bottom: 1rem;"><path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z"/></svg>
                        <div>Belum ada riwayat pesanan (billing).</div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
