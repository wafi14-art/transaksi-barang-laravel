<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('barang', 'harga')) {
            DB::statement('ALTER TABLE barang MODIFY harga DECIMAL(12, 2) NULL');
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('barang', 'harga')) {
            DB::statement('ALTER TABLE barang MODIFY harga DECIMAL(12, 2) NOT NULL');
        }
    }
};
