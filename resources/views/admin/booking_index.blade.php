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
    .status-badge::before { content: ''; width: 6px; height: 6px; border-radius: 50%; }
    
    .status-booked { background-color: rgba(245, 158, 11, 0.1); color: #f59e0b; border: 1px solid rgba(245, 158, 11, 0.2); }
    .status-booked::before { background-color: #f59e0b; }
    
    .status-active { background-color: rgba(6, 182, 212, 0.1); color: #06b6d4; border: 1px solid rgba(6, 182, 212, 0.2); }
    .status-active::before { background-color: #06b6d4; animation: blink 1.5s infinite; }
    @keyframes blink { 0%, 100% { opacity: 1; } 50% { opacity: 0.3; } }
    
    .status-completed { background-color: rgba(16, 185, 129, 0.1); color: #10b981; border: 1px solid rgba(16, 185, 129, 0.2); }
    .status-completed::before { background-color: #10b981; }

    .status-cancelled { background-color: rgba(239, 68, 68, 0.1); color: #ef4444; border: 1px solid rgba(239, 68, 68, 0.2); }
    .status-cancelled::before { background-color: #ef4444; }

    .btn-action-admin {
        padding: 0.625rem 1rem;
        border-radius: 4px;
        font-size: 0.75rem;
        font-weight: 800;
        cursor: pointer;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border: 1px solid;
    }

    .btn-checkin {
        background: rgba(16, 185, 129, 0.1);
        border-color: rgba(16, 185, 129, 0.3);
        color: #10b981;
    }
    .btn-checkin:hover {
        background: #10b981;
        color: white;
    }

    .btn-checkout {
        background: rgba(239, 68, 68, 0.1);
        border-color: rgba(239, 68, 68, 0.3);
        color: #ef4444;
    }
    .btn-checkout:hover {
        background: #ef4444;
        color: white;
    }
    
    .btn-action-admin svg { width: 14px; height: 14px; fill: currentColor; }

    .btn-export {
        background: rgba(239, 68, 68, 0.1);
        border: 1px solid rgba(239, 68, 68, 0.3);
        color: #ef4444;
        padding: 0.625rem 1rem;
        border-radius: 4px;
        font-size: 0.75rem;
        font-weight: 800;
        cursor: pointer;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        text-decoration: none;
    }
    .btn-export:hover { background: rgba(239, 68, 68, 0.2); }
    .btn-export.green { background: rgba(16, 185, 129, 0.1); border-color: rgba(16, 185, 129, 0.3); color: #10b981; }
    .btn-export.green:hover { background: rgba(16, 185, 129, 0.2); }

    .time-remaining {
        font-size: 0.625rem;
        color: #f59e0b;
        font-weight: 700;
        margin-top: 0.25rem;
    }
</style>
@endsection

@section('content')
<div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 2.5rem;">
    <div>
        <h1 class="page-title">Riwayat Billing</h1>
        <p class="page-subtitle" style="margin-bottom: 0;">Kelola check-in, check-out, dan pantau seluruh transaksi booking.</p>
    </div>
    <div style="display: flex; gap: 1rem;">
        <a href="{{ route('admin.bookings.export.excel', request()->all()) }}" class="btn-export green">
            <svg viewBox="0 0 24 24" width="16" height="16" fill="currentColor"><path d="M19 9h-4V3H9v6H5l7 7 7-7zM5 18v2h14v-2H5z"/></svg>
            Export Excel
        </a>
        <a href="{{ route('admin.bookings.export.pdf', request()->all()) }}" class="btn-export">
            <svg viewBox="0 0 24 24" width="16" height="16" fill="currentColor"><path d="M19 9h-4V3H9v6H5l7 7 7-7zM5 18v2h14v-2H5z"/></svg>
            Export PDF
        </a>
    </div>
</div>

@if(session('success'))
    <div style="background: rgba(16, 185, 129, 0.1); color: #10b981; padding: 1rem; border-radius: 8px; margin-bottom: 2rem; font-size: 0.875rem; border: 1px solid rgba(16, 185, 129, 0.2);">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div style="background: rgba(239, 68, 68, 0.1); color: #ef4444; padding: 1rem; border-radius: 8px; margin-bottom: 2rem; font-size: 0.875rem; border: 1px solid rgba(239, 68, 68, 0.2);">
        {{ session('error') }}
    </div>
@endif

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
    <div style="flex: 1;">
        <label style="font-size: 0.75rem; color: var(--text-muted); margin-bottom: 0.5rem; display: block; font-weight: 800; text-transform: uppercase;">Status</label>
        <select name="status" style="width: 100%; background: rgba(255,255,255,0.02); border: 1px solid var(--border-color); color: var(--text-main); padding: 0.75rem; border-radius: 4px;">
            <option value="" style="background: var(--bg-card); color: var(--text-main);">Semua Status</option>
            <option value="booked" style="background: var(--bg-card); color: var(--text-main);" {{ request('status') == 'booked' ? 'selected' : '' }}>Booked</option>
            <option value="active" style="background: var(--bg-card); color: var(--text-main);" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
            <option value="completed" style="background: var(--bg-card); color: var(--text-main);" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
            <option value="cancelled" style="background: var(--bg-card); color: var(--text-main);" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
        </select>
    </div>
    <div style="display: flex; gap: 0.5rem;">
        <button type="submit" class="btn-action-admin btn-checkin" style="padding: 0.85rem 1.5rem;">
            Terapkan Filter
        </button>
        @if(request()->filled('date') || request()->filled('pc_category') || request()->filled('status'))
            <a href="{{ route('admin.bookings.index') }}" class="btn-export" style="padding: 0.85rem 1.5rem; background: transparent; border-color: var(--border-color); color: var(--text-muted);">Reset</a>
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
                <th>Status</th>
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
                        <span class="status-badge status-{{ $booking->status }}">{{ ucfirst($booking->status) }}</span>
                    </td>
                    <td>
                        <div class="price">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</div>
                        <div class="duration">Durasi: {{ $booking->duration_hours }} Jam</div>
                    </td>
                    <td class="time">
                        {{ $booking->start_time ? $booking->start_time->format('d M Y, H:i') : '--:--' }} <br>
                        <span style="color: var(--purple-light);">sampai</span> <br>
                        {{ $booking->end_time ? $booking->end_time->format('d M Y, H:i') : '--:--' }}
                        @if($booking->status === 'active' && $booking->end_time)
                            @php
                                $remaining = now()->diff($booking->end_time);
                                $isOverdue = now()->gt($booking->end_time);
                            @endphp
                            <div class="time-remaining">
                                @if($isOverdue)
                                    ⚠️ SUDAH LEWAT {{ $remaining->h }}j {{ $remaining->i }}m
                                @else
                                    ⏱ Sisa: {{ $remaining->h }}j {{ $remaining->i }}m
                                @endif
                            </div>
                        @endif
                    </td>
                    <td style="text-align: right;">
                        @if($booking->status === 'booked')
                            <form action="{{ route('admin.bookings.checkin', $booking->id) }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn-action-admin btn-checkin" onclick="return confirm('Check-In pelanggan ini? PC akan diubah menjadi IN USE.')">
                                    <svg viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>
                                    Check-In
                                </button>
                            </form>
                        @elseif($booking->status === 'active')
                            <form action="{{ route('admin.bookings.checkout', $booking->id) }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn-action-admin btn-checkout" onclick="return confirm('Check-Out pelanggan ini? Sesi akan diakhiri dan PC menjadi available.')">
                                    <svg viewBox="0 0 24 24"><path d="M6 6h12v12H6z"/></svg>
                                    Check-Out
                                </button>
                            </form>
                        @elseif($booking->status === 'completed')
                            <span class="status-badge status-completed">Selesai</span>
                        @elseif($booking->status === 'cancelled')
                            <span class="status-badge status-cancelled">Dibatalkan</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align: center; color: var(--text-muted); padding: 5rem;">
                        <svg viewBox="0 0 24 24" width="64" height="64" fill="rgba(255,255,255,0.05)" style="margin-bottom: 1rem;"><path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z"/></svg>
                        <div>Belum ada riwayat pesanan (billing).</div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
