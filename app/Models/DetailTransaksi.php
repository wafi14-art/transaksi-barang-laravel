<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int|string|null $id
 * @property int|string|null $transaksi_id
 * @property int|string|null $barang_id
 * @property float|int|string|null $harga_satuan
 * @property int|null $jumlah
 * @property float|int|string|null $subtotal
 */
class DetailTransaksi extends Model
{
    protected $table = 'detail_transaksi';

    protected $fillable = [
        'transaksi_id',
        'barang_id',
        'harga_satuan',
        'jumlah',
        'subtotal',
    ];

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class);
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
}
