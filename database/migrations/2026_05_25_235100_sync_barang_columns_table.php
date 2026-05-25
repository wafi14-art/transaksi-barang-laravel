<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('barang', function (Blueprint $table) {
            if (!Schema::hasColumn('barang', 'kode_barang')) {
                $table->string('kode_barang')->nullable()->unique()->after('id');
            }

            if (!Schema::hasColumn('barang', 'kategori')) {
                $table->string('kategori')->nullable()->after('nama_barang');
            }

            if (!Schema::hasColumn('barang', 'harga_jual')) {
                $table->decimal('harga_jual', 12, 2)->nullable()->after('stok');
            }
        });

        if (Schema::hasColumn('barang', 'harga') && Schema::hasColumn('barang', 'harga_jual')) {
            DB::table('barang')
                ->whereNull('harga_jual')
                ->update(['harga_jual' => DB::raw('harga')]);
        }
    }

    public function down(): void
    {
        Schema::table('barang', function (Blueprint $table) {
            if (Schema::hasColumn('barang', 'kode_barang')) {
                $table->dropUnique('barang_kode_barang_unique');
                $table->dropColumn('kode_barang');
            }

            if (Schema::hasColumn('barang', 'kategori')) {
                $table->dropColumn('kategori');
            }

            if (Schema::hasColumn('barang', 'harga_jual')) {
                $table->dropColumn('harga_jual');
            }
        });
    }
};
