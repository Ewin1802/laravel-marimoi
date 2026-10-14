<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Catatan setoran pajak (laporan untuk owner & petugas pajak).
 *
 * Tabel ini BERDIRI SENDIRI: tidak ada foreign key / perubahan apa pun
 * ke tabel orders maupun order_items. Pajak terkumpul tetap dihitung
 * dari SUM(orders.tax); tabel ini hanya mencatat berapa yang sudah
 * disetor beserta bukti transfernya.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tax_payments', function (Blueprint $table) {
            $table->id();

            // Masa pajak yang dibayar, format YYYY-MM
            $table->string('period', 7);

            // Tanggal setor sebenarnya
            $table->date('payment_date');

            // Rupiah (sama seperti orders.tax yang integer)
            $table->unsignedBigInteger('amount');

            // Kode billing / NTPN / nomor referensi (opsional)
            $table->string('reference')->nullable();

            $table->text('notes')->nullable();

            // Path bukti di disk "public", mis. tax-proofs/xxxx.jpg
            $table->string('proof_path');

            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();

            $table->index('period');
            $table->index('payment_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tax_payments');
    }
};
