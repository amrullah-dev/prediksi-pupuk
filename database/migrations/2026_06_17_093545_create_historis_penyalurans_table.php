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
        Schema::create('historis_penyaluran', function (Blueprint $table) {
            $table->string('id_historis', 10)->primary();

            $table->string('id_kios', 10);

            $table->date('periode');

            $table->decimal('jumlah_penyaluran', 12, 2);

            $table->timestamps();

            $table->foreign('id_kios')
                ->references('id_kios')
                ->on('kios')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historis_penyalurans');
    }
};
