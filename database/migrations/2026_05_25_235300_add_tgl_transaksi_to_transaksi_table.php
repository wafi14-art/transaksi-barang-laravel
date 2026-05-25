<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transaksi', function (Blueprint $table): void {
            $table->timestamp('tgl_transaksi')->nullable()->useCurrent()->after('catatan');
        });

        DB::table('transaksi')
            ->whereNull('tgl_transaksi')
            ->update(['tgl_transaksi' => DB::raw('COALESCE(created_at, CURRENT_TIMESTAMP)')]);
    }

    public function down(): void
    {
        Schema::table('transaksi', function (Blueprint $table): void {
            $table->dropColumn('tgl_transaksi');
        });
    }
};
