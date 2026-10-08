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
        Schema::create('safety_stok', function (Blueprint $table) {

            $table->string('id_safety', 10)->primary();

            $table->string('id_stok', 10);

            $table->date('periode');

            $table->decimal('safety_stok', 12, 2);

            $table->decimal('siap_salur', 12, 2);

            $table->timestamps();

            $table->foreign('id_stok')
                ->references('id_stok')
                ->on('stok_pupuk')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('safety_stok');
    }
};
