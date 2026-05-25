<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int|string|null $id
 * @property string|null $kode_barang
 * @property string|null $nama_barang
 * @property string|null $kategori
 * @property int|null $stok
 * @property float|int|string|null $harga_jual
 * @property string|null $deskripsi
 */
class Barang extends Model
{
    protected $table = 'barang';

    protected $fillable = [
        'kode_barang',
        'nama_barang',
        'kategori',
        'stok',
        'harga_jual',
        'deskripsi',
<<<<<<< HEAD
        'image',
        'thumbnail',
=======
>>>>>>> be5b8eccddf63807057a578f2e624d09e99c65b6
    ];

    public function detailTransaksi()
    {
        return $this->hasMany(DetailTransaksi::class);
    }
}
