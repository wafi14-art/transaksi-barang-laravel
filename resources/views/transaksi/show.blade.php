@extends('layouts.app')

@section('content')
    <h1>Detail Transaksi</h1>
    <div>
        <p><strong>No. Transaksi:</strong> {{ $transaksi->no_transaksi }}</p>
        <p><strong>Pelanggan:</strong> {{ $transaksi->pelanggan->nama ?? '-' }}</p>
        <p><strong>Kasir:</strong> {{ $transaksi->user->name ?? '-' }}</p>
        <p><strong>Status:</strong> {{ ucfirst($transaksi->status) }}</p>
        <p><strong>Total Harga:</strong> Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</p>
        <p><strong>Bayar:</strong> Rp {{ number_format($transaksi->bayar, 0, ',', '.') }}</p>
        <p><strong>Kembalian:</strong> Rp {{ number_format($transaksi->kembalian, 0, ',', '.') }}</p>
        <p><strong>Catatan:</strong> {{ $transaksi->catatan ?? '-' }}</p>
    </div>

    <h2>Detail Item</h2>
    <table>
        <thead>
            <tr>
                <th>Barang</th>
                <th>Harga Satuan</th>
                <th>Jumlah</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transaksi->detailTransaksi as $item)
                <tr>
                    <td>{{ $item->barang->nama_barang ?? '-' }}</td>
                    <td>Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                    <td>{{ $item->jumlah }}</td>
                    <td>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">Tidak ada item transaksi.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <a href="{{ route('transaksi.index') }}">Kembali ke daftar transaksi</a>
@endsection
