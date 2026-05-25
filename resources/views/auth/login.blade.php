<<<<<<< HEAD
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Transaksi Barang</title>
    <style>
        :root {
            color-scheme: light;
            --bg: #f3f7fb;
            --panel: #ffffff;
            --ink: #172033;
            --muted: #667085;
            --line: #d9e2ec;
            --primary: #0f766e;
            --primary-dark: #115e59;
            --accent: #f59e0b;
            --danger-bg: #fef2f2;
            --danger: #b42318;
            --danger-line: #fecdca;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: Inter, "Segoe UI", Arial, sans-serif;
            background:
                radial-gradient(circle at 12% 18%, rgba(15, 118, 110, .18), transparent 28rem),
                radial-gradient(circle at 88% 8%, rgba(245, 158, 11, .16), transparent 24rem),
                var(--bg);
            color: var(--ink);
        }

        .login-shell {
            min-height: 100vh;
            display: grid;
            place-items: center;
            padding: 28px;
        }

        .login-card {
            width: min(100%, 980px);
            display: grid;
            grid-template-columns: 1fr 420px;
            overflow: hidden;
            background: var(--panel);
            border: 1px solid rgba(217, 226, 236, .9);
            border-radius: 8px;
            box-shadow: 0 24px 60px rgba(17, 24, 39, .14);
        }

        .brand-panel {
            position: relative;
            padding: 44px;
            min-height: 560px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            color: #f8fafc;
            background:
                linear-gradient(140deg, rgba(15, 23, 42, .96), rgba(15, 118, 110, .92)),
                linear-gradient(45deg, rgba(245, 158, 11, .26), transparent);
        }

        .brand-panel::after {
            content: "";
            position: absolute;
            inset: auto 44px 96px auto;
            width: 210px;
            height: 210px;
            border: 1px solid rgba(255, 255, 255, .16);
            border-radius: 50%;
        }

        .brand-mark {
            display: flex;
            align-items: center;
            gap: 14px;
            position: relative;
            z-index: 1;
        }

        .brand-icon {
            width: 48px;
            height: 48px;
            display: grid;
            place-items: center;
            border-radius: 8px;
            background: rgba(255, 255, 255, .12);
            border: 1px solid rgba(255, 255, 255, .22);
            font-weight: 800;
        }

        .brand-title {
            margin: 0;
            font-size: 24px;
            line-height: 1.1;
        }

        .brand-subtitle {
            margin: 4px 0 0;
            color: rgba(248, 250, 252, .72);
            font-size: 14px;
        }

        .hero-copy {
            position: relative;
            z-index: 1;
            max-width: 430px;
        }

        .hero-copy h1 {
            margin: 0 0 18px;
            font-size: clamp(34px, 5vw, 54px);
            line-height: 1;
            letter-spacing: 0;
        }

        .hero-copy p {
            margin: 0;
            color: rgba(248, 250, 252, .76);
            font-size: 17px;
            line-height: 1.7;
        }

        .brand-stats {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 12px;
            position: relative;
            z-index: 1;
        }

        .stat {
            padding: 14px;
            border-radius: 8px;
            background: rgba(255, 255, 255, .1);
            border: 1px solid rgba(255, 255, 255, .16);
        }

        .stat strong {
            display: block;
            font-size: 18px;
        }

        .stat span {
            display: block;
            margin-top: 4px;
            color: rgba(248, 250, 252, .68);
            font-size: 12px;
        }

        .form-panel {
            padding: 44px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .mobile-brand {
            display: none;
            margin-bottom: 28px;
        }

        .form-panel h2 {
            margin: 0 0 8px;
            font-size: 30px;
            line-height: 1.15;
        }

        .form-panel > p {
            margin: 0 0 28px;
            color: var(--muted);
            line-height: 1.6;
        }

        .alert {
            margin-bottom: 18px;
            padding: 13px 14px;
            border-radius: 8px;
            border: 1px solid var(--danger-line);
            background: var(--danger-bg);
            color: var(--danger);
            font-size: 14px;
            line-height: 1.5;
        }

        .alert ul {
            margin: 0;
            padding-left: 18px;
        }

        .field {
            margin-bottom: 18px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #344054;
            font-size: 14px;
            font-weight: 700;
        }

        input {
            width: 100%;
            min-height: 48px;
            border: 1px solid var(--line);
            border-radius: 8px;
            padding: 12px 14px;
            font: inherit;
            color: var(--ink);
            background: #fff;
            outline: none;
            transition: border-color .18s ease, box-shadow .18s ease;
        }

        input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(15, 118, 110, .14);
        }

        .submit {
            width: 100%;
            min-height: 50px;
            border: 0;
            border-radius: 8px;
            background: var(--primary);
            color: #fff;
            font: inherit;
            font-weight: 800;
            cursor: pointer;
            transition: background .18s ease, transform .18s ease, box-shadow .18s ease;
            box-shadow: 0 12px 24px rgba(15, 118, 110, .24);
        }

        .submit:hover {
            background: var(--primary-dark);
            transform: translateY(-1px);
        }

        .credentials {
            margin-top: 24px;
            padding: 16px;
            border: 1px solid #b7e4dd;
            border-radius: 8px;
            background: #ecfdf9;
        }

        .credentials h3 {
            margin: 0 0 10px;
            font-size: 14px;
            color: var(--primary-dark);
        }

        .credential-row {
            display: flex;
            justify-content: space-between;
            gap: 12px;
            padding: 8px 0;
            border-top: 1px solid rgba(15, 118, 110, .12);
            font-size: 14px;
        }

        .credential-row:first-of-type {
            border-top: 0;
            padding-top: 0;
        }

        .credential-row span {
            color: var(--muted);
        }

        .credential-row strong {
            color: #0f3f3b;
            text-align: right;
            overflow-wrap: anywhere;
        }

        @media (max-width: 820px) {
            .login-shell {
                padding: 18px;
                align-items: start;
            }

            .login-card {
                grid-template-columns: 1fr;
            }

            .brand-panel {
                display: none;
            }

            .form-panel {
                padding: 28px;
            }

            .mobile-brand {
                display: flex;
            }
        }
    </style>
</head>
<body>
    <main class="login-shell">
        <section class="login-card" aria-label="Halaman login">
            <div class="brand-panel">
                <div class="brand-mark">
                    <div class="brand-icon">TB</div>
                    <div>
                        <p class="brand-title">Transaksi Barang</p>
                        <p class="brand-subtitle">Inventory dan penjualan</p>
                    </div>
                </div>

                <div class="hero-copy">
                    <h1>Kelola stok dan transaksi lebih rapi.</h1>
                    <p>Masuk untuk mengatur data barang, pelanggan, dan transaksi penjualan dalam satu dashboard yang siap dipakai.</p>
                </div>

                <div class="brand-stats" aria-label="Fitur utama">
                    <div class="stat">
                        <strong>Stok</strong>
                        <span>Kontrol barang</span>
                    </div>
                    <div class="stat">
                        <strong>POS</strong>
                        <span>Transaksi cepat</span>
                    </div>
                    <div class="stat">
                        <strong>Data</strong>
                        <span>Laporan ringkas</span>
                    </div>
                </div>
            </div>

            <div class="form-panel">
                <div class="brand-mark mobile-brand">
                    <div class="brand-icon" style="background:#0f766e;color:#fff;">TB</div>
                    <div>
                        <p class="brand-title">Transaksi Barang</p>
                        <p class="brand-subtitle" style="color:#667085;">Inventory dan penjualan</p>
                    </div>
                </div>

                <h2>Login</h2>
                <p>Gunakan akun admin di bawah untuk masuk ke aplikasi.</p>

                @if(session('error'))
                    <div class="alert">{{ session('error') }}</div>
                @endif

                @if(session('success'))
                    <div class="credentials" style="margin-top:0;margin-bottom:18px;">
                        <h3>{{ session('success') }}</h3>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('login.post') }}">
                    @csrf
                    <div class="field">
                        <label for="email">Email</label>
                        <input id="email" type="email" name="email" value="{{ old('email', 'adminbaru@gmail.com') }}" autocomplete="email" required>
                    </div>

                    <div class="field">
                        <label for="password">Password</label>
                        <input id="password" type="password" name="password" autocomplete="current-password" required>
                    </div>

                    <button class="submit" type="submit">Masuk</button>
                </form>

                <div class="credentials">
                    <h3>Info Login Default</h3>
                    <div class="credential-row">
                        <span>Email</span>
                        <strong>adminbaru@gmail.com</strong>
                    </div>
                    <div class="credential-row">
                        <span>Password</span>
                        <strong>password123</strong>
                    </div>
                </div>
            </div>
        </section>
    </main>
</body>
</html>
=======
@extends('layouts.app')

@section('content')
    <h1>Login</h1>
    <form method="POST" action="{{ route('login.post') }}">
        @csrf
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required />
        </div>
        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" required />
        </div>
        <button type="submit">Login</button>
    </form>
@endsection
>>>>>>> be5b8eccddf63807057a578f2e624d09e99c65b6
