@extends('layouts.dashboard')

@section('styles')
<style>
    .page-title { font-size: 1.5rem; font-weight: 800; margin-bottom: 0.25rem; letter-spacing: -0.5px; }
    .page-subtitle { font-size: 0.875rem; color: var(--text-muted); margin-bottom: 2.5rem; }

    .admin-grid {
        display: grid;
        grid-template-columns: 1fr 2.5fr;
        gap: 2rem;
    }

    .form-card {
        background-color: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 2rem;
    }
    .form-title { font-size: 1.125rem; font-weight: 800; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem; border-bottom: 1px dashed rgba(255,255,255,0.1); padding-bottom: 1.25rem; letter-spacing: -0.5px;}
    
    .form-group { margin-bottom: 1.5rem; }
    .form-label { display: block; font-size: 0.75rem; color: var(--text-muted); font-weight: 800; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 0.5rem; }
    .form-control { width: 100%; background: rgba(0,0,0,0.2); border: 1px solid var(--border-color); color: var(--text-main); padding: 0.875rem 1rem; border-radius: 6px; font-size: 0.875rem; transition: all 0.2s; }
    .form-control:focus { outline: none; border-color: var(--purple-light); box-shadow: 0 0 0 3px rgba(168, 85, 247, 0.15); }
    
    .btn-submit { background: var(--purple-light); color: var(--bg-dark); border: none; padding: 0.875rem; width: 100%; border-radius: 6px; font-weight: 800; font-size: 0.875rem; text-transform: uppercase; letter-spacing: 1px; cursor: pointer; transition: background 0.2s; }
    .btn-submit:hover { background: #d8b4fe; }

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

    .pc-name { font-weight: 700; display: flex; align-items: center; gap: 0.5rem; color: var(--text-main); }
    .pc-name svg { width: 18px; height: 18px; fill: var(--purple-light); }

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

    .status-available { background-color: rgba(16, 185, 129, 0.1); color: #10b981; border: 1px solid rgba(16, 185, 129, 0.2); }
    .status-available::before { background-color: #10b981; }
    
    .status-in-use { background-color: rgba(239, 68, 68, 0.1); color: #ef4444; border: 1px solid rgba(239, 68, 68, 0.2); }
    .status-in-use::before { background-color: #ef4444; animation: blink 1.5s infinite; }
    @keyframes blink { 0%, 100% { opacity: 1; } 50% { opacity: 0.3; } }

    .btn-delete { background: transparent; border: 1px solid rgba(239, 68, 68, 0.3); color: #ef4444; width: 36px; height: 36px; border-radius: 4px; display: inline-flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.2s; }
    .btn-delete:hover { background: rgba(239, 68, 68, 0.1); border-color: #ef4444; }
    .btn-delete svg { width: 18px; height: 18px; fill: currentColor; }

    .booking-schedule {
        display: flex;
        flex-direction: column;
        gap: 0.4rem;
    }

    .schedule-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.7rem;
        background: rgba(255, 255, 255, 0.02);
        padding: 0.4rem 0.65rem;
        border-radius: 4px;
        border: 1px solid rgba(255, 255, 255, 0.05);
    }

    .schedule-item.schedule-booked {
        border-color: rgba(245, 158, 11, 0.2);
        background: rgba(245, 158, 11, 0.05);
    }

    .schedule-item.schedule-active {
        border-color: rgba(6, 182, 212, 0.2);
        background: rgba(6, 182, 212, 0.05);
    }

    .schedule-dot {
        width: 5px;
        height: 5px;
        border-radius: 50%;
        flex-shrink: 0;
    }

    .schedule-dot.booked { background: #f59e0b; }
    .schedule-dot.active { background: #06b6d4; box-shadow: 0 0 6px #06b6d4; }

    .schedule-user {
        font-weight: 700;
        color: var(--text-main);
        white-space: nowrap;
    }

    .schedule-time {
        color: var(--text-muted);
        font-family: monospace;
        white-space: nowrap;
    }

    .no-schedule {
        font-size: 0.7rem;
        color: rgba(255, 255, 255, 0.15);
        font-style: italic;
    }

    @media (max-width: 1024px) {
        .admin-grid { grid-template-columns: 1fr; }
    }
</style>
@endsection

@section('content')
<h1 class="page-title">Manajemen Komputer (PC)</h1>
<p class="page-subtitle">Tambah, lihat, atau hapus perangkat komputer di jaringan Warnet Asoy.</p>

<div class="admin-grid">
    <!-- Kolom Kiri: Form Tambah PC -->
    <div>
        <div class="form-card">
            <div class="form-title">
                <svg viewBox="0 0 24 24" width="20" height="20" fill="var(--purple-light)"><path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/></svg>
                Tambah PC Baru
            </div>
            <form action="{{ route('admin.computers.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label class="form-label">Nama Identifikasi PC</label>
                    <input type="text" name="name" class="form-control" placeholder="Mis. PC VIP-01" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Tarif Sewa Per Jam (Rp)</label>
                    <input type="number" name="price_per_hour" class="form-control" value="5000" required>
                </div>
                <button type="submit" class="btn-submit">Simpan PC</button>
            </form>
        </div>
    </div>

    <!-- Kolom Kanan: Tabel Data PC -->
    <div>
        <div class="data-card">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nama PC</th>
                        <th>Tarif / Jam</th>
                        <th>Status</th>
                        <th>Jadwal Booking</th>
                        <th style="text-align: right;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($computers as $pc)
                        <tr>
                            <td>
                                <div class="pc-name">
                                    <svg viewBox="0 0 24 24"><path d="M21 2H3c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h7v2H8v2h8v-2h-2v-2h7c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm0 14H3V4h18v12z"/></svg>
                                    {{ $pc->name }}
                                </div>
                            </td>
                            <td style="color: var(--text-muted);">Rp {{ number_format($pc->price_per_hour, 0, ',', '.') }}</td>
                            <td>
                                @if($pc->status == 'available')
                                    <span class="status-badge status-available">Kosong</span>
                                @else
                                    <span class="status-badge status-in-use">Digunakan</span>
                                @endif
                            </td>
                            <td>
                                @if(isset($upcomingBookings[$pc->id]) && $upcomingBookings[$pc->id]->count() > 0)
                                    <div class="booking-schedule">
                                        @foreach($upcomingBookings[$pc->id]->take(3) as $bk)
                                            <div class="schedule-item schedule-{{ $bk->status }}">
                                                <span class="schedule-dot {{ $bk->status }}"></span>
                                                <span class="schedule-user">{{ $bk->user->name ?? 'Guest' }}</span>
                                                <span class="schedule-time">{{ $bk->start_time->format('d/m H:i') }} - {{ $bk->end_time->format('H:i') }}</span>
                                            </div>
                                        @endforeach
                                        @if($upcomingBookings[$pc->id]->count() > 3)
                                            <span style="font-size: 0.625rem; color: var(--text-muted);">+{{ $upcomingBookings[$pc->id]->count() - 3 }} lainnya</span>
                                        @endif
                                    </div>
                                @else
                                    <span class="no-schedule">Tidak ada jadwal</span>
                                @endif
                            </td>
                            <td style="text-align: right;">
                                <form action="{{ route('admin.computers.destroy', $pc->id) }}" method="POST" onsubmit="return confirm('Hapus PC ini? Riwayat booking mungkin akan terpengaruh.')" style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-delete" title="Hapus PC">
                                        <svg viewBox="0 0 24 24"><path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/></svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align: center; color: var(--text-muted); padding: 4rem;">
                                <svg viewBox="0 0 24 24" width="48" height="48" fill="rgba(255,255,255,0.05)" style="margin-bottom: 1rem;"><path d="M21 2H3c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h7v2H8v2h8v-2h-2v-2h7c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm0 14H3V4h18v12z"/></svg>
                                <div>Belum ada data PC terdaftar.</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
