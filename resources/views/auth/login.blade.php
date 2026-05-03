@extends('layouts.auth')

@section('title', 'Masuk - WARNET ASOY')

@section('content')
<div class="auth-container">
    <img src="{{ asset('images/hero_bg.png') }}" class="auth-bg" alt="Background">
    <div class="auth-overlay"></div>
    
    <div class="auth-content">
        <div class="auth-header">
            <h1>WARNET ASOY</h1>
            <p>Access Your Command Center</p>
        </div>

        <div class="auth-card">
            <div class="auth-tabs">
                <button class="auth-tab active">Masuk</button>
                <button class="auth-tab" onclick="window.location.href='{{ route('register') }}'">Daftar</button>
            </div>

            @if($errors->any())
                <div class="alert-error">
                    <ul style="margin:0; padding-left:1rem;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form id="login-form" class="auth-form" method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group">
                    <div class="form-label-container">
                        <label class="form-label">Email</label>
                    </div>
                    <div class="form-input-container">
                        <svg class="form-input-icon" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                        <input type="email" name="email" class="form-input" placeholder="Masukkan Email Anda" value="{{ old('email') }}" required autofocus>
                    </div>
                </div>

                <div class="form-group">
                    <div class="form-label-container">
                        <label class="form-label">Password</label>
                        <a href="#" class="form-link">Lupa Password?</a>
                    </div>
                    <div class="form-input-container">
                        <svg class="form-input-icon" viewBox="0 0 24 24"><path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm3.1-9H8.9V6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2z"/></svg>
                        <input type="password" name="password" class="form-input" placeholder="••••••••" required>
                    </div>
                </div>

                <button type="submit" class="btn-submit">
                    Masuk
                    <svg viewBox="0 0 24 24"><path d="M16.01 11H4v2h12.01v3L20 12l-3.99-4z"/></svg>
                </button>
            </form>

            <div class="auth-divider">ATAU</div>

            <div class="auth-social">
                <button class="btn-social">
                    <svg viewBox="0 0 24 24" width="16" height="16" xmlns="http://www.w3.org/2000/svg"><path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/><path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/><path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/><path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/></svg>
                    Sign in with Google
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
