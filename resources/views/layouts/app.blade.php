<!DOCTYPE html>
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
    </div>
</body>
</html>
