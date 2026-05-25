<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int|string|null $id
 * @property string|null $no_transaksi
 * @property int|string|null $pelanggan_id
 * @property int|string|null $user_id
 * @property float|int|string|null $total_harga
 * @property float|int|string|null $bayar
 * @property float|int|string|null $kembalian
 * @property string|null $status
 * @property string|null $catatan
 */
class Transaksi extends Model
{
    protected $table = 'transaksi';

    protected $fillable = [
        'no_transaksi',
        'pelanggan_id',
        'user_id',
        'total_harga',
        'bayar',
        'kembalian',
        'status',
        'catatan',
    ];

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function detailTransaksi()
    {
        return $this->hasMany(DetailTransaksi::class);
    }
}
