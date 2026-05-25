<?php

namespace Illuminate\Support\Facades;

use Illuminate\Database\Schema\Blueprint;

class Schema
{
    public static function create(string $table, callable $callback): void
    {
        $callback(new Blueprint());
    }

    public static function dropIfExists(string $table): void
    {
    }
}
