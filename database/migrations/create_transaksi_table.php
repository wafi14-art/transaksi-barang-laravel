<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateTransaksiTable extends Migration
{
    public function up(): void
    {
        Schema::create('transaksi', function (Blueprint $table): void {
            $table->id();
            $table->string('no_transaksi')->unique();
            $table->foreignId('pelanggan_id')->constrained('pelanggan')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->decimal('total_harga', 12, 2);
            $table->decimal('bayar', 12, 2);
            $table->decimal('kembalian', 12, 2);
            $table->enum('status', ['draft', 'selesai', 'batal']);
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
}
