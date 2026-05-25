@extends('layouts.app')

@section('content')
    <h1>Daftar Transaksi</h1>
    <div class="actions">
        <a href="{{ route('transaksi.create') }}">Tambah Transaksi</a>
    </div>

    <table>
        <thead>
            <tr>
                <th>No. Transaksi</th>
                <th>Pelanggan</th>
                <th>Total</th>
                <th>Bayar</th>
                <th>Kembalian</th>
                <th>Status</th>
                <th>Tanggal</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transaksi as $item)
                <tr>
                    <td>{{ $item->no_transaksi }}</td>
                    <td>{{ $item->pelanggan->nama ?? '-' }}</td>
                    <td>Rp {{ number_format($item->total_harga, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($item->bayar, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($item->kembalian, 0, ',', '.') }}</td>
                    <td>{{ ucfirst($item->status) }}</td>
                    <td>{{ $item->created_at->format('d-m-Y') }}</td>
                    <td>
                        <a href="{{ route('transaksi.show', $item->id) }}">Detail</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8">Belum ada transaksi.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $transaksi->links() ?? '' }}
@endsection
