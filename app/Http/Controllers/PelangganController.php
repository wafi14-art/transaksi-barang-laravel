<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pelanggan;

class PelangganController extends Controller
{
    // READ — tampilkan semua pelanggan + fitur cari
    public function index(Request $request)
    {
        $query = Pelanggan::query();

        if ($request->filled('search')) {
            $cari = $request->search;
            $query->where('nama', 'like', "%$cari%")
                ->orWhere('telepon', 'like', "%$cari%")
                ->orWhere('email', 'like', "%$cari%");
        }

        $pelanggan = $query->latest()->paginate(10);

        return view('pelanggan.index', compact('pelanggan'));
    }

    // CREATE — tampilkan form tambah
    public function create()
    {
        return view('pelanggan.form', [
            'pelanggan' => null,
            'mode' => 'create',
        ]);
    }

    // STORE — simpan data baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'email' => 'nullable|email|unique:pelanggan,email',
            'telepon' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
        ], [
            'nama.required' => 'Nama pelanggan wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
        ]);

        Pelanggan::create($validated);

        return redirect()->route('pelanggan.index')
            ->with('success', 'Pelanggan berhasil ditambahkan.');
    }

    // EDIT — tampilkan form edit
    public function edit($id)
    {
        $pelanggan = Pelanggan::findOrFail($id);

        return view('pelanggan.form', [
            'pelanggan' => $pelanggan,
            'mode' => 'edit',
        ]);
    }

    // UPDATE — simpan perubahan
    public function update(Request $request, $id)
    {
        $pelanggan = Pelanggan::findOrFail($id);

        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'email' => 'nullable|email|unique:pelanggan,email,' . $id,
            'telepon' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
        ], [
            'nama.required' => 'Nama pelanggan wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan pelanggan lain.',
        ]);

        $pelanggan->update($validated);

        return redirect()->route('pelanggan.index')
            ->with('success', 'Data pelanggan berhasil diperbarui.');
    }

    // DELETE — hapus pelanggan
    public function destroy($id)
    {
        $pelanggan = Pelanggan::findOrFail($id);

        // Cegah hapus jika sudah punya transaksi
        if ($pelanggan->transaksi()->count() > 0) {
            return back()->with('error', 'Pelanggan tidak dapat dihapus karena memiliki riwayat transaksi.');
        }

        $pelanggan->delete();

        return redirect()->route('pelanggan.index')
            ->with('success', 'Pelanggan berhasil dihapus.');
    }
}