<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WARNET ASOY</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-dark: #0f0b15;
            --bg-card: #15111c;
            --text-main: #ffffff;
            --text-muted: #8b8599;
            --purple-main: #a855f7;
            --purple-light: #c084fc;
            --border-color: rgba(168, 85, 247, 0.2);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            background-color: var(--bg-dark);
            color: var(--text-main);
            line-height: 1.5;
            -webkit-font-smoothing: antialiased;
            width: 100%;
            overflow-x: hidden;
        }

        /* Navbar */
        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.5rem 5%;
            background-color: var(--bg-dark);
            position: sticky;
            top: 0;
            z-index: 50;
            border-bottom: 1px solid var(--border-color);
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
        }

        .logo svg {
            width: 24px;
            height: 24px;
            fill: var(--purple-light);
        }

        .nav-links {
            display: flex;
            gap: 2rem;
        }

        .nav-links a {
            color: var(--text-muted);
            text-decoration: none;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: color 0.2s;
        }

        .nav-links a:hover {
            color: var(--text-main);
        }

        .nav-right a {
            color: var(--text-muted);
            text-decoration: none;
            font-size: 0.75rem;
            font-weight: 500;
            transition: color 0.2s;
        }

        .nav-right a:hover {
            color: var(--purple-light);
        }

        /* Main Container */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
        }

        /* Footer */
        footer {
            text-align: center;
            padding: 3rem 0;
            border-top: 1px solid var(--border-color);
            margin-top: 5rem;
            color: var(--text-muted);
            font-size: 0.625rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        @media (max-width: 768px) {
            .nav-links {
                display: none;
            }
        }
    </style>
    @yield('styles')
</head>

<body>

    <nav>
        <a href="/" class="logo">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path
                    d="M21.58 8.87l-2.07-5A2 2 0 0017.65 2.5h-11.3a2 2 0 00-1.86 1.37l-2.07 5A1 1 0 002.5 10v9a2 2 0 002 2h15a2 2 0 002-2v-9a1 1 0 00.08-1.13zM6.5 15a1.5 1.5 0 110-3 1.5 1.5 0 010 3zm11 0a1.5 1.5 0 110-3 1.5 1.5 0 010 3zM10 10V8a1 1 0 012 0v2h-2zm4 0V8a1 1 0 012 0v2h-2z" />
            </svg>
            WARNET ASOY
        </a>
        <div class="nav-links">
            <a href="#katalog">Katalog</a>
            <a href="#fasilitas">Game</a>
            <a href="#kantin">Kantin</a>
        </div>
        <div class="nav-right">
            @auth
                <a href="{{ auth()->user()->role === 'admin' ? route('admin.dashboard') : route('home') }}"
                    style="color: var(--purple-light); font-weight: 700;">
                    Dashboard →
                </a>
            @else
                <a href="{{ route('login') }}">Login</a>
                <span style="color: rgba(255,255,255,0.2); margin: 0 0.5rem;">|</span>
                <a href="{{ route('register') }}">Daftar</a>
            @endauth
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <footer>
        &copy; 2023 WARNET ASOY. ALL RIGHTS RESERVED.
    </footer>

</body>

</html>