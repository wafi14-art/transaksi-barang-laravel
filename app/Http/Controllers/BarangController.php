<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;

class BarangController extends Controller
{
    public function index(Request $request)
    {
        $query = Barang::query();

        if ($request->filled('search')) {
            $cari = $request->search;
            $query->where('nama_barang', 'like', "%$cari%")
                ->orWhere('kode_barang', 'like', "%$cari%")
                ->orWhere('kategori', 'like', "%$cari%");
        }

        // Sort (enterprise table) - default terbaru
        $sort = $request->input('sort');
        $dir = strtolower($request->input('dir', 'desc')) === 'asc' ? 'asc' : 'desc';

        if ($sort) {
            $allowed = ['nama_barang', 'kode_barang', 'stok'];
            if (in_array($sort, $allowed, true)) {
                $query->orderBy($sort, $dir);
            } else {
                $query->latest();
            }
        } else {
            $query->latest();
        }

        $barang = $query->paginate(10);

        return view('barang.index', compact('barang'));
    }

    public function create()
    {
        return view('barang.form', [
            'barang' => null,
            'mode' => 'create',
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_barang' => 'required|string|unique:barang,kode_barang',
            'nama_barang' => 'required|string|max:150',
            'kategori' => 'nullable|string|max:100',
            'stok' => 'required|integer|min:0',
            'harga_jual' => 'required|numeric|min:0',
            'deskripsi' => 'nullable|string',
        ]);

        Barang::create($validated);

        return redirect()->route('barang.index')
            ->with('success', 'Barang berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $barang = Barang::findOrFail($id);

        return view('barang.form', [
            'barang' => $barang,
            'mode' => 'edit',
        ]);
    }

    public function update(Request $request, $id)
    {
        $barang = Barang::findOrFail($id);

        $validated = $request->validate([
            'kode_barang' => 'required|string|unique:barang,kode_barang,' . $id,
            'nama_barang' => 'required|string|max:150',
            'kategori' => 'nullable|string|max:100',
            'stok' => 'required|integer|min:0',
            'harga_jual' => 'required|numeric|min:0',
            'deskripsi' => 'nullable|string',
        ]);

        $barang->update($validated);

        return redirect()->route('barang.index')
            ->with('success', 'Data barang berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $barang = Barang::findOrFail($id);

        if ($barang->detailTransaksi()->count() > 0) {
            return back()->with('error', 'Barang tidak dapat dihapus karena sudah pernah ditransaksikan.');
        }

        $barang->delete();

        return redirect()->route('barang.index')
            ->with('success', 'Barang berhasil dihapus.');
    }
}