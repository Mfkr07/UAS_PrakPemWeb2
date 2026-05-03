<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WARNET ASOY - Dashboard</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-dark: #0f0b15;
            --bg-card: #15111c;
            --bg-sidebar: #0f0b15;
            --text-main: #ffffff;
            --text-muted: #8b8599;
            --purple-main: #a855f7;
            --purple-light: #c084fc;
            --border-color: rgba(168, 85, 247, 0.15);
            --sidebar-width: 260px;
            --topbar-height: 70px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            background-color: var(--bg-dark);
            color: var(--text-main);
            -webkit-font-smoothing: antialiased;
            display: flex;
            flex-direction: column;
            height: 100vh;
            overflow: hidden;
        }

        /* Topbar */
        .topbar {
            height: var(--topbar-height);
            background-color: var(--bg-card);
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 2rem;
            z-index: 50;
            flex-shrink: 0;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 800;
            font-size: 1.25rem;
            color: var(--purple-light);
            text-decoration: none;
            text-transform: uppercase;
            letter-spacing: 1px;
            width: var(--sidebar-width);
        }

        .logo svg {
            width: 24px;
            height: 24px;
            fill: var(--purple-light);
        }

        .top-links {
            display: flex;
            gap: 2rem;
            flex-grow: 1;
            margin-left: 1rem;
        }

        .top-links a {
            color: var(--text-muted);
            text-decoration: none;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: color 0.2s;
        }

        .top-links a:hover {
            color: var(--text-main);
        }

        .top-right {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .balance {
            font-weight: 700;
            color: var(--purple-light);
            font-size: 0.875rem;
            letter-spacing: 1px;
        }

        .avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background-color: #333;
            overflow: hidden;
            border: 1px solid var(--border-color);
        }

        .avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Layout Container */
        .layout-container {
            display: flex;
            flex-grow: 1;
            overflow: hidden;
        }

        /* Sidebar */
        .sidebar {
            width: var(--sidebar-width);
            background-color: var(--bg-sidebar);
            border-right: 1px solid var(--border-color);
            display: flex;
            flex-direction: column;
            overflow-y: auto;
            flex-shrink: 0;
        }

        .user-profile {
            padding: 1.5rem 2rem;
            border-bottom: 1px solid var(--border-color);
        }

        .user-name {
            font-weight: 700;
            font-size: 1rem;
            margin-bottom: 0.25rem;
        }

        .user-tier {
            font-size: 0.625rem;
            color: #f59e0b;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .nav-menu {
            padding: 1.5rem 0;
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
            flex-grow: 1;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem 2rem;
            color: var(--text-muted);
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 600;
            transition: all 0.2s;
            border-left: 3px solid transparent;
        }

        .nav-item svg {
            width: 18px;
            height: 18px;
            fill: currentColor;
        }

        .nav-item:hover {
            background-color: rgba(255, 255, 255, 0.02);
            color: var(--text-main);
        }

        .nav-item.active {
            background-color: rgba(168, 85, 247, 0.1);
            color: var(--purple-light);
            border-left-color: var(--purple-light);
        }

        .logout-btn {
            margin: 2rem;
            padding: 0.75rem;
            background: transparent;
            border: 1px solid var(--border-color);
            color: var(--text-muted);
            border-radius: 4px;
            font-weight: 600;
            font-size: 0.75rem;
            cursor: pointer;
            transition: all 0.2s;
        }

        .logout-btn:hover {
            background: rgba(239, 68, 68, 0.1);
            color: #f87171;
            border-color: rgba(239, 68, 68, 0.3);
        }

        /* Main Content */
        .main-content {
            flex-grow: 1;
            padding: 3rem 4rem;
            overflow-y: auto;
            background-color: var(--bg-dark);
        }

        @yield('styles')
    </style>
</head>

<body>

    <!-- Topbar -->
    <header class="topbar">
        <a href="/" class="logo">
            <svg viewBox="0 0 24 24">
                <path
                    d="M21.58 8.87l-2.07-5A2 2 0 0017.65 2.5h-11.3a2 2 0 00-1.86 1.37l-2.07 5A1 1 0 002.5 10v9a2 2 0 002 2h15a2 2 0 002-2v-9a1 1 0 00.08-1.13zM6.5 15a1.5 1.5 0 110-3 1.5 1.5 0 010 3zm11 0a1.5 1.5 0 110-3 1.5 1.5 0 010 3zM10 10V8a1 1 0 012 0v2h-2zm4 0V8a1 1 0 012 0v2h-2z" />
            </svg>
            WARNET ASOY
        </a>

        <div class="top-right">
            @if(auth()->user() && auth()->user()->role !== 'admin')
                <div class="stat-value text-accent"
                    style="font-weight: 700; color: var(--purple-light); font-size: 0.875rem; letter-spacing: 1px;">Rp
                    {{ number_format(auth()->user()->wallet_balance ?? 0, 0, ',', '.') }}</div>
            @endif
            <div class="avatar">
                <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=a855f7&color=fff"
                    alt="Avatar">
            </div>
        </div>
    </header>

    <div class="layout-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="user-profile">
                <div class="user-name">{{ auth()->user()->name }}</div>
            </div>
            <nav class="nav-menu">
                @if(auth()->user() && auth()->user()->role === 'admin')
                    <div
                        style="padding: 0 2rem; font-size: 0.625rem; font-weight: 800; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 0.5rem; margin-top: 1rem;">
                        Admin Menu</div>
                    <a href="{{ route('admin.dashboard') }}"
                        class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <svg viewBox="0 0 24 24">
                            <path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z" />
                        </svg>
                        Overview
                    </a>
                    <a href="{{ route('admin.computers.index') }}"
                        class="nav-item {{ request()->routeIs('admin.computers.*') ? 'active' : '' }}">
                        <svg viewBox="0 0 24 24">
                            <path
                                d="M21 2H3c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h7v2H8v2h8v-2h-2v-2h7c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm0 14H3V4h18v12z" />
                        </svg>
                        Manajemen PC
                    </a>
                    <a href="{{ route('admin.bookings.index') }}"
                        class="nav-item {{ request()->routeIs('admin.bookings.*') ? 'active' : '' }}">
                        <svg viewBox="0 0 24 24">
                            <path
                                d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z" />
                        </svg>
                        Riwayat Billing
                    </a>
                    <a href="{{ route('admin.users.index') }}"
                        class="nav-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                        <svg viewBox="0 0 24 24">
                            <path
                                d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z" />
                        </svg>
                        Manajemen Akun
                    </a>
                    <a href="{{ route('admin.canteen.index') }}"
                        class="nav-item {{ request()->routeIs('admin.canteen.*') ? 'active' : '' }}">
                        <svg viewBox="0 0 24 24">
                            <path
                                d="M11 9H9V2H7v7H5V2H3v7c0 2.12 1.66 3.84 3.75 3.97V22h2.5v-9.03C11.34 12.84 13 11.12 13 9V2h-2v7zm5-3v8h2.5v8H21V2c-2.76 0-5 2.24-5 4z" />
                        </svg>
                        Manajemen Kantin
                    </a>
                @else
                    <div
                        style="padding: 0 2rem; font-size: 0.625rem; font-weight: 800; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 0.5rem; margin-top: 1rem;">
                        User Menu</div>
                    <a href="{{ route('home') }}" class="nav-item {{ request()->routeIs('home') ? 'active' : '' }}">
                        <svg viewBox="0 0 24 24">
                            <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z" />
                        </svg>
                        Home
                    </a>
                    <a href="{{ route('billing') }}" class="nav-item {{ request()->routeIs('billing*') ? 'active' : '' }}">
                        <svg viewBox="0 0 24 24">
                            <path
                                d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67z" />
                        </svg>
                        Billing
                    </a>
                    <a href="{{ route('profile') }}" class="nav-item {{ request()->routeIs('profile*') ? 'active' : '' }}">
                        <svg viewBox="0 0 24 24">
                            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                        </svg>
                        Informasi Akun
                    </a>
                @endif
            </nav>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="logout-btn w-100"
                    style="width: calc(100% - 4rem); margin: 2rem;">LOGOUT</button>
            </form>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            @yield('content')
        </main>
    </div>

</body>

</html>