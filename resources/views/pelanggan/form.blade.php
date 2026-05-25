@extends('layouts.app')

@section('content')
    <h1>{{ $mode === 'edit' ? 'Edit Pelanggan' : 'Tambah Pelanggan' }}</h1>

    <form method="POST" action="{{ $mode === 'edit' ? route('pelanggan.update', $pelanggan->id) : route('pelanggan.store') }}">
        @csrf
        @if($mode === 'edit')
            @method('PUT')
        @endif

        <div class="form-group">
            <label>Nama</label>
            <input type="text" name="nama" value="{{ old('nama', $pelanggan->nama ?? '') }}" required />
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" value="{{ old('email', $pelanggan->email ?? '') }}" />
        </div>

        <div class="form-group">
            <label>Telepon</label>
            <input type="text" name="telepon" value="{{ old('telepon', $pelanggan->telepon ?? '') }}" />
        </div>

        <div class="form-group">
            <label>Alamat</label>
            <textarea name="alamat">{{ old('alamat', $pelanggan->alamat ?? '') }}</textarea>
        </div>

        <button type="submit">Simpan</button>
    </form>
@endsection
