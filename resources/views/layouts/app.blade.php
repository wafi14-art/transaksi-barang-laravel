<!DOCTYPE html>
<<<<<<< HEAD
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Transaksi Barang')</title>
    <style>
        :root {
            --bg: #f4f7fb;
            --surface: #ffffff;
            --surface-soft: #f8fafc;
            --ink: #182230;
            --muted: #667085;
            --line: #d9e2ec;
            --primary: #0f766e;
            --primary-dark: #115e59;
            --danger: #b42318;
            --danger-bg: #fef2f2;
            --success: #067647;
            --success-bg: #ecfdf3;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: Inter, "Segoe UI", Arial, sans-serif;
            background: var(--bg);
            color: var(--ink);
        }

        a {
            color: inherit;
        }

        .app-shell {
            min-height: 100vh;
        }

        .topbar {
            position: sticky;
            top: 0;
            z-index: 10;
            background: rgba(255, 255, 255, .94);
            border-bottom: 1px solid var(--line);
            backdrop-filter: blur(12px);
        }

        .topbar-inner {
            max-width: 1180px;
            margin: 0 auto;
            padding: 14px 22px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 18px;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            min-width: 210px;
            text-decoration: none;
        }

        .brand-badge {
            width: 40px;
            height: 40px;
            display: grid;
            place-items: center;
            border-radius: 8px;
            background: var(--primary);
            color: #fff;
            font-weight: 800;
        }

        .brand strong {
            display: block;
            font-size: 16px;
        }

        .brand span {
            display: block;
            margin-top: 2px;
            color: var(--muted);
            font-size: 12px;
        }

        .nav {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            flex-wrap: wrap;
            gap: 8px;
        }

        .nav a,
        .nav button,
        .btn,
        button,
        input[type="submit"] {
            min-height: 38px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: 1px solid transparent;
            border-radius: 8px;
            padding: 8px 12px;
            font: inherit;
            font-size: 14px;
            font-weight: 700;
            text-decoration: none;
            cursor: pointer;
            transition: background .18s ease, border-color .18s ease, color .18s ease, box-shadow .18s ease;
        }

        .nav a {
            color: #344054;
        }

        .nav a:hover {
            background: #eef6f5;
            color: var(--primary-dark);
        }

        .nav button,
        .btn,
        button,
        input[type="submit"] {
            background: var(--primary);
            color: #fff;
            box-shadow: 0 8px 18px rgba(15, 118, 110, .16);
        }

        .nav button:hover,
        .btn:hover,
        button:hover,
        input[type="submit"]:hover {
            background: var(--primary-dark);
        }

        .container {
            width: min(100% - 32px, 1180px);
            margin: 26px auto;
            padding: 24px;
            background: var(--surface);
            border: 1px solid var(--line);
            border-radius: 8px;
            box-shadow: 0 18px 42px rgba(16, 24, 40, .08);
        }

        h1,
        h2,
        h3 {
            letter-spacing: 0;
            color: var(--ink);
        }

        h1 {
            margin: 0 0 20px;
            font-size: clamp(28px, 4vw, 40px);
            line-height: 1.1;
        }

        .alert {
            display: flex;
            gap: 10px;
            padding: 13px 14px;
            margin-bottom: 18px;
            border-radius: 8px;
            border: 1px solid;
            line-height: 1.5;
        }

        .alert-success {
            color: var(--success);
            background: var(--success-bg);
            border-color: #abefc6;
        }

        .alert-error {
            color: var(--danger);
            background: var(--danger-bg);
            border-color: #fecdca;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 16px;
            overflow: hidden;
            border: 1px solid var(--line);
            border-radius: 8px;
            background: var(--surface);
        }

        table th,
        table td {
            padding: 12px 14px;
            border-bottom: 1px solid var(--line);
            text-align: left;
            vertical-align: middle;
        }

        table th {
            background: var(--surface-soft);
            color: #475467;
            font-size: 13px;
            text-transform: uppercase;
        }

        table tr:last-child td {
            border-bottom: 0;
        }

        table tr:hover td {
            background: #fbfdfd;
        }

        .form-group {
            margin-bottom: 16px;
        }

        .form-group label {
            display: block;
            margin-bottom: 7px;
            color: #344054;
            font-size: 14px;
            font-weight: 700;
        }

        .form-group input,
        .form-group textarea,
        .form-group select,
        input[type="text"],
        input[type="email"],
        input[type="number"],
        input[type="password"],
        input[type="date"],
        textarea,
        select {
            width: 100%;
            min-height: 44px;
            padding: 10px 12px;
            border: 1px solid var(--line);
            border-radius: 8px;
            background: #fff;
            color: var(--ink);
            font: inherit;
            outline: none;
            transition: border-color .18s ease, box-shadow .18s ease;
        }

        textarea {
            min-height: 110px;
            resize: vertical;
        }

        .form-group input:focus,
        .form-group textarea:focus,
        .form-group select:focus,
        input:focus,
        textarea:focus,
        select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(15, 118, 110, .13);
        }

        .actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            align-items: center;
            margin-top: 18px;
        }

        .actions a {
            min-height: 38px;
            display: inline-flex;
            align-items: center;
            border-radius: 8px;
            padding: 8px 12px;
            background: #eef6f5;
            color: var(--primary-dark);
            font-weight: 700;
            text-decoration: none;
        }

        @media (max-width: 760px) {
            .topbar-inner {
                align-items: flex-start;
                flex-direction: column;
            }

            .brand {
                min-width: 0;
            }

            .nav {
                justify-content: flex-start;
                width: 100%;
            }

            .container {
                width: min(100% - 20px, 1180px);
                margin-top: 14px;
                padding: 18px;
            }
        }
    </style>
</head>
<body>
    <div class="app-shell">
        <header class="topbar">
            <div class="topbar-inner">
                <a class="brand" href="{{ route('dashboard') }}">
                    <div class="brand-badge">TB</div>
                    <span>
                        <strong>Transaksi Barang</strong>
                        <span>{{ session('user_name') ?? 'Inventory dan penjualan' }}</span>
                    </span>
                </a>

                <nav class="nav">
                    <a href="{{ route('dashboard') }}">Dashboard</a>
                    <a href="{{ route('pelanggan.index') }}">Pelanggan</a>
                    <a href="{{ route('barang.index') }}">Barang</a>
                    <a href="{{ route('transaksi.index') }}">Transaksi</a>
                    @if(session()->has('user_id'))
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit">Logout</button>
                        </form>
                    @endif
                </nav>
            </div>
        </header>

        <main class="container">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-error">{{ session('error') }}</div>
            @endif
            @if($errors->any())
                <div class="alert alert-error">
                    <ul style="margin: 0; padding-left: 18px;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </main>
=======
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaksi Barang</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; background: #f7f7f7; }
        .container { max-width: 1000px; margin: 24px auto; padding: 16px; background: #ffffff; box-shadow: 0 0 10px rgba(0,0,0,.05); }
        nav a { margin-right: 12px; }
        .alert { padding: 12px 16px; margin-bottom: 16px; border-radius: 4px; }
        .alert-success { background: #e3f7e3; border: 1px solid #8fd28f; }
        .alert-error { background: #ffe5e5; border: 1px solid #dd6b6b; }
        table { width: 100%; border-collapse: collapse; margin-top: 12px; }
        table th, table td { padding: 8px 10px; border: 1px solid #ddd; }
        .form-group { margin-bottom: 12px; }
        .form-group label { display: block; margin-bottom: 4px; }
        .form-group input, .form-group textarea, .form-group select { width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px; }
        .actions { display: flex; gap: 8px; flex-wrap: wrap; margin-top: 12px; }
    </style>
</head>
<body>
    <div class="container">
        <nav>
            <a href="{{ route('dashboard') }}">Dashboard</a>
            <a href="{{ route('pelanggan.index') }}">Pelanggan</a>
            <a href="{{ route('barang.index') }}">Barang</a>
            <a href="{{ route('transaksi.index') }}">Transaksi</a>
            @if(session()->has('user_id'))
                <form action="{{ route('logout') }}" method="POST" style="display:inline">
                    @csrf
                    <button type="submit">Logout</button>
                </form>
            @endif
        </nav>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif
        @if($errors->any())
            <div class="alert alert-error">
                <ul style="margin: 0; padding-left: 18px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
>>>>>>> be5b8eccddf63807057a578f2e624d09e99c65b6
    </div>
</body>
</html>
