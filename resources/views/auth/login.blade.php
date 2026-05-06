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

                <!-- Session Status -->
                @if (session('status'))
                    <div class="alert-success" style="background: rgba(16, 185, 129, 0.1); color: #10b981; padding: 1.25rem; border-radius: 8px; margin-bottom: 2rem; font-size: 0.875rem; border: 1px solid rgba(16, 185, 129, 0.2); font-weight: 600;">
                        {{ session('status') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert-error" style="background: rgba(239, 68, 68, 0.1); color: #ef4444; padding: 1.25rem; border-radius: 8px; margin-bottom: 2rem; font-size: 0.875rem; border: 1px solid rgba(239, 68, 68, 0.2); font-weight: 600;">
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
                            <label class="form-label" for="email">Email</label>
                        </div>
                        <div class="form-input-container">
                            <svg class="form-input-icon" viewBox="0 0 24 24">
                                <path
                                    d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                            </svg>
                            <input type="email" id="email" name="email" class="form-input" placeholder="Masukkan Email Anda"
                                value="{{ old('email') }}" required autofocus>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-label-container">
                            <label class="form-label" for="password">Password</label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="form-link">Lupa Password?</a>
                            @endif
                        </div>
                        <div class="form-input-container">
                            <svg class="form-input-icon" viewBox="0 0 24 24">
                                <path
                                    d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm3.1-9H8.9V6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2z" />
                            </svg>
                            <input type="password" id="password" name="password" class="form-input" placeholder="••••••••" required>
                        </div>
                    </div>

                    <div class="form-group block mt-4" style="margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem;">
                        <input id="remember_me" type="checkbox" name="remember" style="accent-color: var(--purple-light);">
                        <label for="remember_me" class="form-label" style="margin: 0; color: var(--text-muted);">Ingat Saya</label>
                    </div>

                    <button type="submit" class="btn-submit">
                        Masuk
                        <svg viewBox="0 0 24 24">
                            <path d="M16.01 11H4v2h12.01v3L20 12l-3.99-4z" />
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
