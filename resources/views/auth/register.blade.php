@extends('layouts.auth')

@section('title', 'Daftar - WARNET ASOY')

@section('content')
    <div class="auth-container">
        <img src="{{ asset('images/hero_bg.png') }}" class="auth-bg" alt="Background">
        <div class="auth-overlay"></div>

        <div class="auth-content">
            <div class="auth-header">
                <h1>WARNET ASOY</h1>
                <p>Create Your Account</p>
            </div>

            <div class="auth-card">
                <div class="auth-tabs">
                    <button class="auth-tab" onclick="window.location.href='{{ route('login') }}'">Masuk</button>
                    <button class="auth-tab active">Daftar</button>
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

                <form id="register-form" class="auth-form" method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="form-group">
                        <div class="form-label-container">
                            <label class="form-label">Email</label>
                        </div>
                        <div class="form-input-container">
                            <svg class="form-input-icon" viewBox="0 0 24 24">
                                <path
                                    d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z" />
                            </svg>
                            <input type="email" name="email" class="form-input" placeholder="Masukkan Email Anda"
                                value="{{ old('email') }}" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-label-container">
                            <label class="form-label">Username</label>
                        </div>
                        <div class="form-input-container">
                            <svg class="form-input-icon" viewBox="0 0 24 24">
                                <path
                                    d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                            </svg>
                            <input type="text" name="name" class="form-input" placeholder="Masukkan Username Anda"
                                value="{{ old('name') }}" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-label-container">
                            <label class="form-label">Password</label>
                        </div>
                        <div class="form-input-container">
                            <svg class="form-input-icon" viewBox="0 0 24 24">
                                <path
                                    d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm3.1-9H8.9V6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2z" />
                            </svg>
                            <input type="password" name="password" class="form-input" placeholder="Minimal 8 karakter"
                                required>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-label-container">
                            <label class="form-label">Konfirmasi Password</label>
                        </div>
                        <div class="form-input-container">
                            <svg class="form-input-icon" viewBox="0 0 24 24">
                                <path
                                    d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm3.1-9H8.9V6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2z" />
                            </svg>
                            <input type="password" name="password_confirmation" class="form-input"
                                placeholder="Masukkan Ulang Password" required>
                        </div>
                    </div>

                    <button type="submit" class="btn-submit">
                        Daftar Sekarang
                        <svg viewBox="0 0 24 24">
                            <path d="M16.01 11H4v2h12.01v3L20 12l-3.99-4z" />
                        </svg>
                    </button>
                </form>


            </div>
        </div>
    </div>
@endsection