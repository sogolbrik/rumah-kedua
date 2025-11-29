<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_user');
            $table->foreignId('id_kamar');

            $table->string('kode')->unique(); // kode invoice internal

            $table->date('tanggal_pembayaran');
            $table->date('tanggal_jatuhtempo');
            $table->string('periode_pembayaran', 20); // contoh: November 2025
            $table->date('masuk_kamar')->nullable();
            $table->string('durasi', 20); // contoh: 1,3,6 "bulan"

            $table->decimal('total_bayar', 15, 2);
            $table->enum('metode_pembayaran', ['cash', 'midtrans'])->default('midtrans');

            $table->enum('status_pembayaran', ['pending', 'paid', 'failed', 'cancelled', 'expired', 'challenge'])->default('pending');

            //midtrans payment details
            $table->string('midtrans_order_id')->nullable();
            $table->string('midtrans_transaction_id')->nullable();
            $table->string('midtrans_payment_type')->nullable(); // bank_transfer, gopay, qris, dll
            $table->json('midtrans_response')->nullable(); // simpan response JSON dari Midtrans
            $table->datetime('expired_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
