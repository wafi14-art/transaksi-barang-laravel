<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int|string|null $id
 * @property string|null $nama
 * @property string|null $email
 * @property string|null $telepon
 * @property string|null $alamat
 */
class Pelanggan extends Model
{
    protected $table = 'pelanggan';

    protected $fillable = [
        'nama',
        'email',
        'telepon',
        'alamat',
    ];

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class);
    }
}
