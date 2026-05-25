<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * @property int|string|null $id
 * @property string|null $name
 * @property string|null $email
 * @property string|null $password
 * @property string|null $role
 */
class User extends Authenticatable
{
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class);
    }
}
