@extends('layouts.app')

@section('content')
    <h1>{{ $mode === 'edit' ? 'Edit Barang' : 'Tambah Barang' }}</h1>
    <form method="POST" action="{{ $mode === 'edit' ? route('barang.update', $barang->id) : route('barang.store') }}">
        @csrf
        @if($mode === 'edit') @method('PUT') @endif

        <div class="form-group">
            <label>Kode Barang</label>
            <input type="text" name="kode_barang" value="{{ old('kode_barang', $barang->kode_barang ?? '') }}" required />
        </div>

        <div class="form-group">
            <label>Nama Barang</label>
            <input type="text" name="nama_barang" value="{{ old('nama_barang', $barang->nama_barang ?? '') }}" required />
        </div>

        <div class="form-group">
            <label>Kategori</label>
            <input type="text" name="kategori" value="{{ old('kategori', $barang->kategori ?? '') }}" />
        </div>

        <div class="form-group">
            <label>Stok</label>
            <input type="number" name="stok" min="0" value="{{ old('stok', $barang->stok ?? 0) }}" required />
        </div>

        <div class="form-group">
            <label>Harga Jual</label>
            <input type="number" name="harga_jual" step="0.01" min="0" value="{{ old('harga_jual', $barang->harga_jual ?? '0.00') }}" required />
        </div>

        <div class="form-group">
            <label>Deskripsi</label>
            <textarea name="deskripsi">{{ old('deskripsi', $barang->deskripsi ?? '') }}</textarea>
        </div>

        <button type="submit">Simpan</button>
    </form>
@endsection
