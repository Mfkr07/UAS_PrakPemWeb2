@extends('layouts.dashboard')

@section('styles')
<style>
    .page-title { font-size: 1.5rem; font-weight: 800; margin-bottom: 0.25rem; letter-spacing: -0.5px; }
    .page-subtitle { font-size: 0.875rem; color: var(--text-muted); margin-bottom: 2.5rem; }

    .profile-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 2rem;
    }

    .info-card, .topup-card {
        background-color: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 2.5rem;
    }

    .card-title {
        font-size: 1.125rem;
        font-weight: 800;
        margin-bottom: 2rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        border-bottom: 1px dashed rgba(255,255,255,0.1);
        padding-bottom: 1.25rem;
        letter-spacing: -0.5px;
    }

    .profile-header {
        display: flex;
        align-items: center;
        gap: 1.5rem;
        margin-bottom: 2.5rem;
    }
    .profile-avatar {
        width: 80px; height: 80px;
        border-radius: 50%;
        border: 2px solid var(--purple-light);
        object-fit: cover;
    }
    .profile-name { font-size: 1.5rem; font-weight: 800; margin-bottom: 0.25rem; }
    .profile-email { color: var(--text-muted); font-size: 0.875rem; }

    .info-row { margin-bottom: 1.5rem; }
    .info-label { font-size: 0.75rem; font-weight: 800; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 0.5rem; }
    .info-value { font-size: 1rem; font-weight: 600; color: var(--text-main); }
    .wallet-value { font-size: 1.5rem; font-weight: 800; color: #10b981; }

    .preset-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1rem; margin-bottom: 1.5rem; }
    .preset-btn { 
        background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.1); 
        color: var(--text-main); font-weight: 700; font-size: 0.875rem; 
        padding: 1rem; border-radius: 8px; cursor: pointer; transition: all 0.2s;
    }
    .preset-btn:hover { border-color: var(--purple-light); background: rgba(168, 85, 247, 0.05); }

    .form-group { margin-bottom: 1.5rem; }
    .form-control { width: 100%; background: rgba(0,0,0,0.2); border: 1px solid var(--border-color); color: var(--text-main); padding: 1rem; border-radius: 6px; font-size: 1rem; font-weight: 600; transition: all 0.2s; }
    .form-control:focus { outline: none; border-color: var(--purple-light); box-shadow: 0 0 0 3px rgba(168, 85, 247, 0.15); }

    .btn-submit { background: var(--purple-light); color: var(--bg-dark); border: none; padding: 1rem; width: 100%; border-radius: 6px; font-weight: 800; font-size: 0.875rem; text-transform: uppercase; letter-spacing: 1px; cursor: pointer; transition: background 0.2s; }
    .btn-submit:hover { background: #d8b4fe; }

    @media (max-width: 1024px) {
        .profile-grid { grid-template-columns: 1fr; }
    }
</style>
@endsection

@section('content')
<h1 class="page-title">Informasi Akun</h1>
<p class="page-subtitle">Kelola profil Anda dan isi saldo e-Wallet untuk kemudahan pemesanan.</p>

@if(session('success'))
<div style="background: rgba(16, 185, 129, 0.1); color: #10b981; padding: 1.25rem; border-radius: 8px; margin-bottom: 2rem; font-size: 0.875rem; border: 1px solid rgba(16, 185, 129, 0.2); font-weight: 600;">
    <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
</div>
@endif
@if($errors->any())
<div style="background: rgba(239, 68, 68, 0.1); color: #ef4444; padding: 1.25rem; border-radius: 8px; margin-bottom: 2rem; font-size: 0.875rem; border: 1px solid rgba(239, 68, 68, 0.2); font-weight: 600;">
    <ul style="margin: 0; padding-left: 1.5rem;">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="profile-grid">
    <!-- Profil Data -->
    <div class="info-card">
        <div class="card-title">
            <svg viewBox="0 0 24 24" width="24" height="24" fill="var(--purple-light)"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
            Detail Akun
        </div>

        <div class="profile-header">
            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=a855f7&color=fff&size=128" alt="Avatar" class="profile-avatar">
            <div>
                <div class="profile-name">{{ $user->name }}</div>
                <div class="profile-email">{{ $user->email }}</div>
            </div>
        </div>

        <div class="info-row">
            <div class="info-label">Sisa Saldo e-Wallet</div>
            <div class="wallet-value">Rp {{ number_format($user->wallet_balance, 0, ',', '.') }}</div>
        </div>

        <div class="info-row">
            <div class="info-label">Tanggal Bergabung</div>
            <div class="info-value">{{ $user->created_at->format('d M Y, H:i') }}</div>
        </div>
        
        <div class="info-row">
            <div class="info-label">Status Akun</div>
            <div class="info-value" style="color: #06b6d4;">Aktif Terverifikasi</div>
        </div>
    </div>

    <!-- Topup Form -->
    <div class="topup-card">
        <div class="card-title">
            <svg viewBox="0 0 24 24" width="24" height="24" fill="var(--purple-light)"><path d="M21 18v1c0 1.1-.9 2-2 2H5c-1.11 0-2-.9-2-2V5c0-1.1.89-2 2-2h14c1.1 0 2 .9 2 2v1h-9c-1.11 0-2 .9-2 2v8c0 1.1.89 2 2 2h9zm-9-2h10V8H12v8zm4-2.5c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5z"/></svg>
            Top-Up Saldo
        </div>

        <p style="color: var(--text-muted); font-size: 0.875rem; margin-bottom: 1.5rem; line-height: 1.5;">
            Isi saldo e-Wallet Anda agar proses penyewaan PC dan pembelian di kantin bisa dilakukan secara instan.
        </p>

        <div class="info-label">Pilih Nominal Cepat</div>
        <div class="preset-grid">
            <button type="button" class="preset-btn" onclick="setTopup(20000)">Rp 20.000</button>
            <button type="button" class="preset-btn" onclick="setTopup(50000)">Rp 50.000</button>
            <button type="button" class="preset-btn" onclick="setTopup(100000)">Rp 100.000</button>
            <button type="button" class="preset-btn" onclick="setTopup(200000)">Rp 200.000</button>
            <button type="button" class="preset-btn" onclick="setTopup(500000)">Rp 500.000</button>
            <button type="button" class="preset-btn" onclick="setTopup(1000000)">Rp 1 Juta</button>
        </div>

        <form action="{{ route('profile.topup') }}" method="POST">
            @csrf
            <div class="form-group">
                <label class="info-label">Atau Masukkan Nominal Kustom</label>
                <input type="number" name="amount" id="topup-amount" class="form-control" placeholder="Minimal Rp 10.000" min="10000" required>
            </div>
            <button type="submit" class="btn-submit">Proses Top-Up Sekarang</button>
        </form>
    </div>
</div>

<script>
    function setTopup(amount) {
        document.getElementById('topup-amount').value = amount;
    }
</script>
@endsection
