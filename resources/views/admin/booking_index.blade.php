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
<div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 2.5rem;">
    <div>
        <h1 class="page-title">Riwayat Billing</h1>
        <p class="page-subtitle" style="margin-bottom: 0;">Pantau PC yang sedang digunakan dan lihat rekaman transaksi masuk.</p>
    </div>
    <div style="display: flex; gap: 1rem;">
        <a href="{{ route('admin.bookings.export.excel', request()->all()) }}" class="btn-stop" style="background: rgba(16, 185, 129, 0.1); border-color: rgba(16, 185, 129, 0.3); color: #10b981; text-decoration: none;">
            <svg viewBox="0 0 24 24" width="16" height="16" fill="currentColor" style="margin-right: 4px;">
                <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7.9 14.8l-1.6-4.5h-1.4v4.5H6.8V6.5h3.4c2.5 0 4.1 1.6 4.1 3.9 0 1.8-1.1 3.1-2.6 3.6l2.1 5.3h-1.5zM8.2 11.9h1.9c1.6 0 2.5-1 2.5-2.5S11.7 6.9 10.1 6.9H8.2v5z"/>
            </svg>
            Export Excel
        </a>
        <a href="{{ route('admin.bookings.export.pdf', request()->all()) }}" class="btn-stop" style="background: rgba(239, 68, 68, 0.1); border-color: rgba(239, 68, 68, 0.3); color: #ef4444; text-decoration: none;">
            <svg viewBox="0 0 24 24" width="16" height="16" fill="currentColor" style="margin-right: 4px;">
                <path d="M20 2H8c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm-8.5 7.5c0 .8-.7 1.5-1.5 1.5H9v2H7.5V7H10c.8 0 1.5.7 1.5 1.5v1zm5 2c0 .8-.7 1.5-1.5 1.5h-2.5V7H15c.8 0 1.5.7 1.5 1.5v3zm4-3H19v1h1.5V11H19v2h-1.5V7h3v1.5zM9 9.5h1v-1H9v1zM4 6H2v14c0 1.1.9 2 2 2h14v-2H4V6zm10 5.5h1v-3h-1v3z"/>
            </svg>
            Export PDF
        </a>
    </div>
</div>

<form method="GET" action="{{ route('admin.bookings.index') }}" style="display: flex; gap: 1rem; margin-bottom: 2rem; background: var(--bg-card); padding: 1rem; border-radius: 8px; border: 1px solid var(--border-color); align-items: flex-end;">
    <div style="flex: 1;">
        <label style="font-size: 0.75rem; color: var(--text-muted); margin-bottom: 0.5rem; display: block; font-weight: 800; text-transform: uppercase;">Tanggal</label>
        <input type="date" name="date" value="{{ request('date') }}" style="width: 100%; background: rgba(255,255,255,0.02); border: 1px solid var(--border-color); color: var(--text-main); padding: 0.75rem; border-radius: 4px; color-scheme: dark;">
    </div>
    <div style="flex: 1;">
        <label style="font-size: 0.75rem; color: var(--text-muted); margin-bottom: 0.5rem; display: block; font-weight: 800; text-transform: uppercase;">Kategori PC (Harga)</label>
        <select name="pc_category" style="width: 100%; background: rgba(255,255,255,0.02); border: 1px solid var(--border-color); color: var(--text-main); padding: 0.75rem; border-radius: 4px;">
            <option value="" style="background: var(--bg-card); color: var(--text-main);">Semua Kategori</option>
            @foreach($categories as $category)
                <option value="{{ $category->price_per_hour }}" style="background: var(--bg-card); color: var(--text-main);" {{ request('pc_category') == $category->price_per_hour ? 'selected' : '' }}>
                    Kategori Rp {{ number_format($category->price_per_hour, 0, ',', '.') }}/jam
                </option>
            @endforeach
        </select>
    </div>
    <div style="display: flex; gap: 0.5rem;">
        <button type="submit" class="btn-stop" style="background: var(--purple-light); border-color: var(--purple-main); color: var(--bg-dark); padding: 0.85rem 1.5rem;">
            Terapkan Filter
        </button>
        @if(request()->filled('date') || request()->filled('pc_category'))
            <a href="{{ route('admin.bookings.index') }}" class="btn-stop" style="background: transparent; border-color: var(--border-color); color: var(--text-muted); padding: 0.85rem 1.5rem; text-decoration: none;">Reset</a>
        @endif
    </div>
</form>

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
