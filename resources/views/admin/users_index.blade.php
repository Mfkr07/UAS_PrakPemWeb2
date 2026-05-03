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
    .user-avatar { width: 32px; height: 32px; border-radius: 50%; background: rgba(168, 85, 247, 0.2); color: var(--purple-light); display: flex; align-items: center; justify-content: center; font-size: 0.75rem; flex-shrink: 0;}
    
    .text-email { font-size: 0.75rem; color: var(--text-muted); font-weight: 500; margin-top: 0.25rem; }
    .wallet-val { font-weight: 800; color: #10b981; }

    .btn-delete { background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.3); color: #ef4444; padding: 0.625rem 1rem; border-radius: 4px; font-size: 0.75rem; font-weight: 800; cursor: pointer; transition: all 0.2s; display: inline-flex; align-items: center; gap: 0.5rem; text-transform: uppercase; letter-spacing: 0.5px; }
    .btn-delete:hover { background: #ef4444; color: white; }
    .btn-delete svg { width: 14px; height: 14px; fill: currentColor; }
</style>
@endsection

@section('content')
<h1 class="page-title">Manajemen Akun</h1>
<p class="page-subtitle">Kelola data pelanggan yang terdaftar di sistem.</p>

@if(session('success'))
<div style="background: rgba(16, 185, 129, 0.1); color: #10b981; padding: 1rem; border-radius: 8px; margin-bottom: 2rem; font-size: 0.875rem; border: 1px solid rgba(16, 185, 129, 0.2);">
    <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
</div>
@endif

@if(session('error'))
<div style="background: rgba(239, 68, 68, 0.1); color: #ef4444; padding: 1rem; border-radius: 8px; margin-bottom: 2rem; font-size: 0.875rem; border: 1px solid rgba(239, 68, 68, 0.2);">
    <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
</div>
@endif

<div class="data-card">
    <table class="table">
        <thead>
            <tr>
                <th>Pelanggan</th>
                <th>Tanggal Daftar</th>
                <th>Saldo Wallet</th>
                <th style="text-align: right;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
                <tr>
                    <td>
                        <div class="user-info">
                            <div class="user-avatar">{{ substr($user->name, 0, 1) }}</div>
                            <div>
                                <div>{{ $user->name }}</div>
                                <div class="text-email">{{ $user->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td style="color: var(--text-muted); font-size: 0.75rem;">
                        {{ $user->created_at->format('d M Y') }}
                    </td>
                    <td>
                        <div class="wallet-val">Rp {{ number_format($user->wallet_balance, 0, ',', '.') }}</div>
                    </td>
                    <td style="text-align: right;">
                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus pelanggan ini? Semua riwayatnya mungkin ikut terhapus.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-delete">
                                <svg viewBox="0 0 24 24"><path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/></svg>
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="text-align: center; color: var(--text-muted); padding: 5rem;">
                        <svg viewBox="0 0 24 24" width="64" height="64" fill="rgba(255,255,255,0.05)" style="margin-bottom: 1rem;"><path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/></svg>
                        <div>Belum ada pelanggan yang mendaftar.</div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
