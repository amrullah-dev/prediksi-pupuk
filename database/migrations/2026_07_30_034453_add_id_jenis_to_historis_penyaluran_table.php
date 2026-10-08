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
        Schema::table('historis_penyaluran', function (Blueprint $table) {

            $table->string('id_jenis',10)
                  ->after('id_kios');

            $table->foreign('id_jenis')
                  ->references('id_jenis')
                  ->on('jenis_pupuk')
                  ->cascadeOnUpdate()
                  ->restrictOnDelete();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('historis_penyaluran', function (Blueprint $table) {

            $table->dropForeign(['id_jenis']);

            $table->dropColumn('id_jenis');

        });
    }
};