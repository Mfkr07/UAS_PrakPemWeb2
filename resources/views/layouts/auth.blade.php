<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'WARNET ASOY - Autentikasi')</title>
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
            --border-color: rgba(168, 85, 247, 0.3);
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
            width: 100%;
            overflow-x: hidden;
        }

        .auth-container {
            position: relative;
            width: 100%;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .auth-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: -2;
            opacity: 0.2;
        }

        .auth-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to bottom, rgba(15, 11, 21, 0.7) 0%, rgba(15, 11, 21, 1) 100%);
            z-index: -1;
        }

        .auth-content {
            width: 100%;
            max-width: 420px;
            padding: 2rem;
            z-index: 10;
        }

        .auth-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .auth-header h1 {
            font-size: 2rem;
            font-weight: 800;
            color: var(--purple-light);
            letter-spacing: 1px;
            margin-bottom: 0.25rem;
            text-shadow: 0 0 20px rgba(192, 132, 252, 0.3);
        }

        .auth-header p {
            font-size: 0.875rem;
            color: var(--text-muted);
            font-weight: 500;
        }

        .auth-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 20px 40px rgba(0,0,0,0.5);
        }

        .auth-tabs {
            display: flex;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            margin-bottom: 1.5rem;
        }

        .auth-tab {
            flex: 1;
            background: none;
            border: none;
            color: var(--text-muted);
            padding: 0.75rem 0;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: color 0.2s, border-color 0.2s;
            border-bottom: 2px solid transparent;
        }

        .auth-tab:hover {
            color: var(--text-main);
        }

        .auth-tab.active {
            color: var(--text-main);
            border-bottom-color: var(--purple-light);
        }

        .form-group {
            margin-bottom: 1.25rem;
        }

        .form-label-container {
            display: flex;
            justify-content: space-between;
            align-items: baseline;
            margin-bottom: 0.5rem;
        }

        .form-label {
            font-size: 0.625rem;
            font-weight: 800;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .form-link {
            font-size: 0.625rem;
            color: var(--text-muted);
            text-decoration: none;
            transition: color 0.2s;
        }

        .form-link:hover {
            color: var(--purple-light);
        }

        .form-input-container {
            position: relative;
        }

        .form-input {
            width: 100%;
            background: #ffffff;
            color: var(--bg-dark);
            border: none;
            padding: 0.75rem 1rem 0.75rem 2.5rem;
            border-radius: 4px;
            font-size: 0.875rem;
            font-weight: 500;
            transition: box-shadow 0.2s;
        }

        .form-input:focus {
            outline: none;
            box-shadow: 0 0 0 2px var(--purple-main);
        }

        .form-input-icon {
            position: absolute;
            left: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            width: 16px;
            height: 16px;
            fill: var(--text-muted);
            pointer-events: none;
        }

        .btn-submit {
            width: 100%;
            background: var(--purple-light);
            color: var(--bg-dark);
            border: none;
            padding: 0.875rem;
            border-radius: 4px;
            font-weight: 800;
            font-size: 0.875rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            transition: background 0.2s;
            margin-top: 1.5rem;
        }

        .btn-submit:hover {
            background: #d8b4fe;
        }

        .btn-submit svg {
            width: 16px;
            height: 16px;
            fill: currentColor;
        }

        .auth-divider {
            text-align: center;
            margin: 1.5rem 0;
            position: relative;
            font-size: 0.625rem;
            font-weight: 700;
            color: var(--text-muted);
            text-transform: uppercase;
        }

        .auth-divider::before, .auth-divider::after {
            content: '';
            position: absolute;
            top: 50%;
            width: 38%;
            height: 1px;
            background: rgba(255,255,255,0.1);
        }

        .auth-divider::before { left: 0; }
        .auth-divider::after { right: 0; }

        .btn-social {
            width: 100%;
            background: transparent;
            border: 1px solid rgba(255,255,255,0.1);
            color: var(--text-muted);
            padding: 0.75rem;
            border-radius: 4px;
            font-size: 0.75rem;
            font-weight: 600;
            margin-bottom: 0.75rem;
            cursor: pointer;
            transition: background 0.2s, color 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .btn-social:hover {
            background: rgba(255,255,255,0.05);
            color: var(--text-main);
        }

        .alert-error {
            background-color: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: #f87171;
            padding: 0.75rem;
            border-radius: 4px;
            font-size: 0.75rem;
            margin-bottom: 1.5rem;
            list-style-position: inside;
        }
    </style>
</head>
<body>
    @yield('content')
</body>
</html>
