@extends('layouts.dashboard')

@section('styles')
<style>
    .page-title { font-size: 1.5rem; font-weight: 800; margin-bottom: 0.25rem; letter-spacing: -0.5px; }
    .page-subtitle { font-size: 0.875rem; color: var(--text-muted); margin-bottom: 2.5rem; }

    .profile-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 2rem;
        margin-bottom: 2rem;
    }

    .info-card {
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
    .info-label { font-size: 0.75rem; font-weight: 800; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 0.5rem; display: block; }
    .info-value { font-size: 1rem; font-weight: 600; color: var(--text-main); }

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
<h1 class="page-title">Profil Administrator</h1>
<p class="page-subtitle">Kelola informasi dan keamanan akun administrator Anda.</p>

@if(session('success') || session('status') === 'profile-updated' || session('status') === 'password-updated')
<div style="background: rgba(16, 185, 129, 0.1); color: #10b981; padding: 1.25rem; border-radius: 8px; margin-bottom: 2rem; font-size: 0.875rem; border: 1px solid rgba(16, 185, 129, 0.2); font-weight: 600;">
    <i class="bi bi-check-circle-fill me-2"></i> 
    @if(session('status') === 'profile-updated') Profil berhasil diperbarui.
    @elseif(session('status') === 'password-updated') Password berhasil diperbarui.
    @else {{ session('success') }}
    @endif
</div>
@endif

@if($errors->any() && !session('status'))
<div style="background: rgba(239, 68, 68, 0.1); color: #ef4444; padding: 1.25rem; border-radius: 8px; margin-bottom: 2rem; font-size: 0.875rem; border: 1px solid rgba(239, 68, 68, 0.2); font-weight: 600;">
    <ul style="margin: 0; padding-left: 1.5rem;">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="info-card" style="margin-bottom: 2rem;">
    <div class="card-title">
        <svg viewBox="0 0 24 24" width="24" height="24" fill="var(--purple-light)"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
        Detail Akun Admin
    </div>

    <div class="profile-header">
        <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=a855f7&color=fff&size=128" alt="Avatar" class="profile-avatar">
        <div>
            <div class="profile-name">{{ $user->name }}</div>
            <div class="profile-email">{{ $user->email }}</div>
        </div>
    </div>

    <div class="info-row">
        <div class="info-label">Tanggal Ditunjuk</div>
        <div class="info-value">{{ $user->created_at->format('d M Y, H:i') }}</div>
    </div>
    
    <div class="info-row">
        <div class="info-label">Status Otorisasi</div>
        <div class="info-value" style="color: #06b6d4;">Super Administrator Aktif</div>
    </div>
</div>

<div class="profile-grid">
    <!-- Update Profile Form -->
    <div class="info-card">
        <div class="card-title">
            <svg viewBox="0 0 24 24" width="24" height="24" fill="var(--purple-light)"><path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/></svg>
            Perbarui Profil
        </div>

        <form method="post" action="{{ route('profile.update') }}">
            @csrf
            @method('patch')

            <div class="form-group">
                <label class="info-label" for="name">Nama</label>
                <input id="name" name="name" type="text" class="form-control" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
                @error('name') <span style="color:#ef4444; font-size:0.75rem;">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label class="info-label" for="email">Email</label>
                <input id="email" name="email" type="email" class="form-control" value="{{ old('email', $user->email) }}" required autocomplete="username">
                @error('email') <span style="color:#ef4444; font-size:0.75rem;">{{ $message }}</span> @enderror
            </div>

            <button type="submit" class="btn-submit">Simpan Perubahan</button>
        </form>
    </div>

    <!-- Update Password Form -->
    <div class="info-card">
        <div class="card-title">
            <svg viewBox="0 0 24 24" width="24" height="24" fill="var(--purple-light)"><path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm3.1-9H8.9V6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2z"/></svg>
            Ubah Password
        </div>

        <form method="post" action="{{ route('password.update') }}">
            @csrf
            @method('put')

            <div class="form-group">
                <label class="info-label" for="update_password_current_password">Password Saat Ini</label>
                <input id="update_password_current_password" name="current_password" type="password" class="form-control" autocomplete="current-password">
                @error('current_password', 'updatePassword') <span style="color:#ef4444; font-size:0.75rem;">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label class="info-label" for="update_password_password">Password Baru</label>
                <input id="update_password_password" name="password" type="password" class="form-control" autocomplete="new-password">
                @error('password', 'updatePassword') <span style="color:#ef4444; font-size:0.75rem;">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label class="info-label" for="update_password_password_confirmation">Konfirmasi Password Baru</label>
                <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="form-control" autocomplete="new-password">
                @error('password_confirmation', 'updatePassword') <span style="color:#ef4444; font-size:0.75rem;">{{ $message }}</span> @enderror
            </div>

            <button type="submit" class="btn-submit">Ubah Password</button>
        </form>
    </div>
</div>

@endsection
