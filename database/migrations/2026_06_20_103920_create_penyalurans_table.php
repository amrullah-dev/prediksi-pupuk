<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('penyaluran', function (Blueprint $table) {

            $table->string('id_penyaluran', 10)->primary();

            $table->string('id_kios', 10);

            $table->string('id_prediksi', 10);

            $table->string('id_safety', 10);

            $table->date('periode');

            $table->decimal('proporsi', 8, 4);

            $table->decimal('jumlah_penyaluran', 12, 2);

            $table->timestamps();

            $table->foreign('id_kios')
                ->references('id_kios')
                ->on('kios')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreign('id_prediksi')
                ->references('id_prediksi')
                ->on('prediksi')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreign('id_safety')
                ->references('id_safety')
                ->on('safety_stok')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penyaluran');
    }
};
