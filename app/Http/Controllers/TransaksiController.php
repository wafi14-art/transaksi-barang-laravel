<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\Pelanggan;
use App\Models\Barang;

class TransaksiController extends Controller
{
    // Daftar semua transaksi
    public function index(Request $request)
    {
        $query = Transaksi::with(['pelanggan', 'user'])->latest();

        if ($request->filled('search')) {
            $cari = $request->search;
            $query->where('no_transaksi', 'like', "%$cari%")
                  ->orWhereHas('pelanggan', fn($q) =>
                      $q->where('nama', 'like', "%$cari%")
                  );
        }

        $transaksi = $query->paginate(10);

        return view('transaksi.index', compact('transaksi'));
    }

    // Form buat transaksi baru
    public function create()
    {
        $pelanggan = Pelanggan::orderBy('nama')->get();
        $barang    = Barang::where('stok', '>', 0)->orderBy('nama_barang')->get();

        return view('transaksi.form', compact('pelanggan', 'barang'));
    }

    // Simpan transaksi baru (dengan detail item)
    public function store(Request $request)
    {
        $request->validate([
            'pelanggan_id'     => 'required|exists:pelanggan,id',
            'bayar'            => 'required|numeric|min:0',
            'barang_id'        => 'required|array|min:1',
            'barang_id.*'      => 'exists:barang,id',
            'jumlah'           => 'required|array|min:1',
            'jumlah.*'         => 'required|integer|min:1',
        ], [
            'pelanggan_id.required' => 'Pilih pelanggan terlebih dahulu.',
            'barang_id.required'    => 'Tambahkan minimal 1 barang.',
            'bayar.required'        => 'Nominal bayar wajib diisi.',
        ]);

        DB::beginTransaction();

        try {
            $totalHarga = 0;
            $items      = [];

            // Hitung total & validasi stok setiap barang
            foreach ($request->barang_id as $index => $barangId) {
                $barang  = Barang::findOrFail($barangId);
                $jumlah  = (int) $request->jumlah[$index];

                if (!$barang->cukupStok($jumlah)) {
                    throw new \Exception("Stok barang '{$barang->nama_barang}' tidak mencukupi. Stok tersedia: {$barang->stok}.");
                }

                $subtotal    = $barang->harga_jual * $jumlah;
                $totalHarga += $subtotal;

                $items[] = [
                    'barang'       => $barang,
                    'jumlah'       => $jumlah,
                    'harga_satuan' => $barang->harga_jual,
                    'subtotal'     => $subtotal,
                ];
            }

            $bayar = (float) $request->bayar;

            if ($bayar < $totalHarga) {
                throw new \Exception('Nominal bayar kurang dari total harga.');
            }

            // Buat header transaksi
            $transaksi = Transaksi::create([
                'no_transaksi' => Transaksi::generateNoTransaksi(),
                'pelanggan_id' => $request->pelanggan_id,
                'user_id'      => session('user_id'),
                'total_harga'  => $totalHarga,
                'bayar'        => $bayar,
                'kembalian'    => $bayar - $totalHarga,
                'status'       => 'selesai',
                'catatan'      => $request->catatan,
            ]);

            // Simpan detail & kurangi stok
            foreach ($items as $item) {
                DetailTransaksi::create([
                    'transaksi_id' => $transaksi->id,
                    'barang_id'    => $item['barang']->id,
                    'jumlah'       => $item['jumlah'],
                    'harga_satuan' => $item['harga_satuan'],
                    'subtotal'     => $item['subtotal'],
                ]);

                $item['barang']->kurangiStok($item['jumlah']);
            }

            DB::commit();

            return redirect()->route('transaksi.show', $transaksi->id)
                             ->with('success', 'Transaksi ' . $transaksi->no_transaksi . ' berhasil disimpan.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    // Detail satu transaksi
    public function show($id)
    {
        $transaksi = Transaksi::with([
            'pelanggan',
            'user',
            'detailTransaksi.barang',
        ])->findOrFail($id);

        return view('transaksi.show', compact('transaksi'));
    }
}