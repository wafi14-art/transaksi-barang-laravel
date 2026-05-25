@extends('layouts.app')

@section('content')
    <h1>Daftar Pelanggan</h1>
    <div class="actions">
        <a href="{{ route('pelanggan.create') }}">Tambah Pelanggan</a>
    </div>

    <table>
        <thead>
            <tr>
                <th>Nama</th>
                <th>Email</th>
                <th>Telepon</th>
                <th>Alamat</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pelanggan as $item)
                <tr>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->email ?? '-' }}</td>
                    <td>{{ $item->telepon ?? '-' }}</td>
                    <td>{{ $item->alamat ?? '-' }}</td>
                    <td>
                        <a href="{{ route('pelanggan.edit', $item->id) }}">Edit</a>
                        <form action="{{ route('pelanggan.destroy', $item->id) }}" method="POST" style="display:inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Hapus pelanggan ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">Belum ada pelanggan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $pelanggan->links() ?? '' }}
@endsection
