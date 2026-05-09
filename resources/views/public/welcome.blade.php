@extends('layouts.public')

@section('styles')
    <style>
        /* Hero Section */
        .hero {
            position: relative;
            height: 600px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            overflow: hidden;
            margin-bottom: 4rem;
            border-bottom: 1px solid var(--border-color);
        }

        .hero-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: -2;
            opacity: 0.4;
        }

        .hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to bottom, rgba(15, 11, 21, 0.4) 0%, rgba(15, 11, 21, 1) 100%);
            z-index: -1;
        }

        .hero h1 {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 1rem;
            letter-spacing: -1px;
        }

        .hero p {
            color: var(--text-muted);
            max-width: 600px;
            font-size: 0.875rem;
            margin-bottom: 2rem;
        }

        .btn-primary {
            background-color: var(--purple-light);
            color: var(--bg-dark);
            border: none;
            padding: 0.875rem 2.5rem;
            border-radius: 4px;
            font-weight: 800;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            cursor: pointer;
            transition: background-color 0.2s, transform 0.2s;
            text-decoration: none;
            display: inline-block;
        }

        .btn-primary:hover {
            background-color: #d8b4fe;
            transform: translateY(-2px);
        }

        .btn-outline {
            background-color: transparent;
            color: var(--text-muted);
            border: 1px solid var(--border-color);
            padding: 0.75rem 2rem;
            border-radius: 4px;
            font-weight: 600;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            display: inline-block;
            margin-top: 2rem;
        }

        .btn-outline:hover {
            background-color: rgba(168, 85, 247, 0.1);
            color: var(--text-main);
        }

        /* Section Global */
        .section-title {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 2rem;
        }

        .section-title svg {
            width: 24px;
            height: 24px;
            fill: var(--purple-light);
        }

        .section {
            padding: 4rem 0;
        }

        /* Katalog Cards */
        .katalog-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
        }

        .card {
            background-color: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 2rem;
            position: relative;
            transition: transform 0.3s, border-color 0.3s, box-shadow 0.3s;
            display: flex;
            flex-direction: column;
        }

        .card:hover {
            transform: translateY(-5px);
            border-color: var(--purple-light);
            box-shadow: 0 0 0 1px var(--purple-light);
        }

        .card-vip {
            /* No permanent stroke, matches other cards */
        }

        .badge {
            position: absolute;
            top: 1.5rem;
            right: 1.5rem;
            background-color: var(--purple-light);
            color: var(--bg-dark);
            font-size: 0.5rem;
            font-weight: 800;
            padding: 0.25rem 0.5rem;
            border-radius: 2px;
            text-transform: uppercase;
        }

        .card h3 {
            font-size: 1.125rem;
            font-weight: 700;
            margin-bottom: 0.25rem;
            color: var(--purple-light);
        }

        .card .category {
            font-size: 0.625rem;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 1.5rem;
        }

        .card ul {
            list-style: none;
            margin-bottom: 2rem;
            flex-grow: 1;
        }

        .card ul li {
            font-size: 0.75rem;
            color: var(--text-muted);
            margin-bottom: 0.75rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .card ul li::before {
            content: '✓';
            color: var(--text-main);
            font-size: 0.625rem;
        }

        .card-footer {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
            padding-top: 1.5rem;
        }

        .price {
            font-size: 1.5rem;
            font-weight: 700;
            color: #06b6d4;
        }

        .card-vip .price {
            color: var(--purple-light);
        }

        .price-vvip {
            color: #f59e0b;
        }

        .price span {
            font-size: 0.75rem;
            color: var(--text-muted);
            font-weight: 400;
        }

        .card-btn {
            width: 32px;
            height: 32px;
            border: 1px solid var(--border-color);
            background: transparent;
            color: var(--text-muted);
            border-radius: 4px;
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            transition: background 0.2s, color 0.2s;
        }

        .card-btn:hover {
            background: var(--border-color);
            color: var(--text-main);
        }

        /* Game Section */
        .game-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1.5rem;
        }

        .game-card {
            background-color: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 4px;
            padding: 2rem 1.5rem;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            transition: background 0.2s;
            cursor: pointer;
        }

        .game-card:hover {
            background-color: rgba(255, 255, 255, 0.05);
        }

        .game-icon {
            width: 40px;
            height: 40px;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .game-card span {
            font-size: 0.625rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--text-muted);
        }

        /* Kantin Section */
        .kantin-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
            gap: 1.5rem;
        }

        .kantin-card {
            background-color: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 4px;
            overflow: hidden;
        }

        .kantin-img {
            width: 100%;
            height: 250px;
            object-fit: cover;
        }

        .kantin-body {
            padding: 1.5rem;
        }

        .kantin-title {
            font-size: 1rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .kantin-desc {
            font-size: 0.75rem;
            color: var(--text-muted);
            margin-bottom: 1.5rem;
        }

        .kantin-price {
            font-size: 1rem;
            font-weight: 700;
            color: var(--purple-light);
        }

        .center-action {
            text-align: center;
        }

        @media (max-width: 768px) {
            .game-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .kantin-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endsection

@section('content')
    <!-- Hero Section -->
    <div class="hero">
        <img src="{{ asset('images/hero_bg.png') }}" alt="Gaming Center Background" class="hero-bg">
        <div class="hero-overlay"></div>
        <div class="container" style="position: relative; z-index: 10;">
            <h1>Elevate Your Gaming Experience</h1>
            <p>Masuk ke dunia tanpa batas dengan spesifikasi dewa dan koneksi anti-lag.<br>Command center gaming premium
                Anda siap digunakan.</p>
            @auth
                <a href="{{ auth()->user()->role === 'admin' ? route('admin.dashboard') : route('billing') }}"
                    class="btn-primary">MASUK KE DASHBOARD</a>
            @else
                <a href="{{ route('register') }}" class="btn-primary">BOOKING PC SEKARANG</a>
            @endauth
        </div>
    </div>

    <div class="container">
        <!-- Katalog Section -->
        <div id="katalog" class="section">
            <h2 class="section-title">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path d="M4 6h16v2H4zm0 5h16v2H4zm0 5h16v2H4z" />
                </svg>
                Katalog
            </h2>
            <div class="katalog-grid">
                <!-- Regular -->
                <div class="card">
                    <h3 style="color: #ffffff;">Regular</h3>
                    <div class="category">CASUAL GAMING</div>
                    <ul>
                        <li>Intel i5 12th Gen</li>
                        <li>RTX 3060 12GB</li>
                        <li>16GB RAM DDR4</li>
                        <li>24" 144Hz Monitor</li>
                    </ul>
                    <div class="card-footer">
                        <div class="price">Rp 5.000<span>/jam</span></div>
                        <button class="card-btn" onclick="window.location.href='{{ auth()->check() ? (auth()->user()->role === 'admin' ? route('admin.dashboard') : route('billing')) : route('login') }}'">→</button>
                    </div>
                </div>

                <!-- VIP -->
                <div class="card card-vip">
                    <div class="badge">PALING LARIS</div>
                    <h3>VIP</h3>
                    <div class="category">HARDCORE GAMING</div>
                    <ul>
                        <li>Intel i7 13th Gen</li>
                        <li>RTX 4070 Ti</li>
                        <li>32GB RAM DDR5</li>
                        <li>27" 240Hz OLED Monitor</li>
                        <li>Kursi Ergonomis Premium</li>
                    </ul>
                    <div class="card-footer">
                        <div class="price">Rp 10.000<span>/jam</span></div>
                        <button class="card-btn" onclick="window.location.href='{{ auth()->check() ? (auth()->user()->role === 'admin' ? route('admin.dashboard') : route('billing')) : route('login') }}'">→</button>
                    </div>
                </div>

                <!-- VVIP Streaming -->
                <div class="card">
                    <h3 style="color: #f59e0b;">VVIP Streaming</h3>
                    <div class="category">CONTENT CREATOR</div>
                    <ul>
                        <li>Dual PC Setup (i9 + Ryzen 9)</li>
                        <li>RTX 4090 24GB</li>
                        <li>64GB RAM DDR5</li>
                        <li>Triple Monitor Setup</li>
                        <li>Mic Shure SM7B + Kamera Sony</li>
                        <li>Ruangan Kedap Suara</li>
                    </ul>
                    <div class="card-footer">
                        <div class="price price-vvip" style="color: #f59e0b;">Rp 25.000<span>/jam</span></div>
                        <button class="card-btn" onclick="window.location.href='{{ auth()->check() ? (auth()->user()->role === 'admin' ? route('admin.dashboard') : route('billing')) : route('login') }}'">→</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Game Terinstal Section -->
        <div id="fasilitas" class="section">
            <h2 class="section-title">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path
                        d="M21.58 8.87l-2.07-5A2 2 0 0017.65 2.5h-11.3a2 2 0 00-1.86 1.37l-2.07 5A1 1 0 002.5 10v9a2 2 0 002 2h15a2 2 0 002-2v-9a1 1 0 00.08-1.13zM6.5 15a1.5 1.5 0 110-3 1.5 1.5 0 010 3zm11 0a1.5 1.5 0 110-3 1.5 1.5 0 010 3zM10 10V8a1 1 0 012 0v2h-2zm4 0V8a1 1 0 012 0v2h-2z" />
                </svg>
                Game Terinstal
            </h2>
            <div class="game-grid">
                <div class="game-card">
                    <div class="game-icon">
                        <svg viewBox="0 0 24 24" fill="white" width="32" height="32">
                            <path
                                d="M23 4.2L12 19l-4.7-6.2 3.2-3.8 1.5 2 7.5-10h3.5zm-15.5 8L1.5 4h5.8L12 10.3l-4.5 5.9z" />
                        </svg>
                    </div>
                    <span>VALORANT</span>
                </div>
                <div class="game-card">
                    <div class="game-icon">
                        <svg viewBox="0 0 24 24" fill="white" width="32" height="32">
                            <path d="M2 13v6h8V2zM12 2v10h10V2zm10 12H12v8h10z" />
                        </svg>
                    </div>
                    <span>DOTA 2</span>
                </div>
                <div class="game-card">
                    <div class="game-icon">
                        <svg viewBox="0 0 24 24" fill="white" width="32" height="32">
                            <path
                                d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 15h-2v-2h2v2zm0-4h-2V7h2v6z" />
                        </svg>
                    </div>
                    <span>CS 2</span>
                </div>
            </div>
        </div>

        <!-- Kantin Section -->
        <div id="kantin" class="section">
            <h2 class="section-title">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path
                        d="M11 9H9V2H7v7H5V2H3v7c0 2.12 1.66 3.84 3.75 3.97V22h2.5v-9.03C11.34 12.84 13 11.12 13 9V2h-2v7zm5-7v20h2v-8h4V2h-6z" />
                </svg>
                Kantin
            </h2>
            <div class="kantin-grid">
                <div class="kantin-card">
                    <img src="{{ asset('images/indomie.png') }}" alt="Indomie Telur Kornet" class="kantin-img">
                    <div class="kantin-body">
                        <div class="kantin-title">Indomie Telur Kornet</div>
                        <div class="kantin-desc">Bahan bakar utama gamer. Disajikan panas dengan topping komplit.</div>
                        <div class="kantin-price">Rp 15.000</div>
                    </div>
                </div>
                <div class="kantin-card">
                    <img src="{{ asset('images/kopi_susu.png') }}" alt="Es Kopi Susu Asoy" class="kantin-img">
                    <div class="kantin-body">
                        <div class="kantin-title">Es Kopi Susu Asoy</div>
                        <div class="kantin-desc">Kopi racikan rahasia untuk push rank semalaman tanpa kantuk.</div>
                        <div class="kantin-price">Rp 18.000</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection