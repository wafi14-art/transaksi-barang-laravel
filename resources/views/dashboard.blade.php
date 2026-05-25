@extends('layouts.app')

@section('content')
    <h1>Dashboard</h1>
    <p>Selamat datang, {{ session('user_name') ?? 'Pengguna' }}.</p>
    <p>Pilih menu di atas untuk mengelola data dan transaksi.</p>
@endsection
