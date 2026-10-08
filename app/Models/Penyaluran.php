<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penyaluran extends Model
{
    protected $table = 'penyaluran';

    protected $primaryKey = 'id_penyaluran';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'id_penyaluran',
        'id_kios',
        'id_prediksi',
        'id_safety',
        'id_jenis',
        'periode',
        'proporsi',
        'jumlah_penyaluran',
    ];

    public function kios()
    {
        return $this->belongsTo(Kios::class, 'id_kios', 'id_kios');
    }

    public function prediksi()
    {
        return $this->belongsTo(Prediksi::class, 'id_prediksi', 'id_prediksi');
    }

    public function safetyStok()
    {
        return $this->belongsTo(SafetyStok::class, 'id_safety', 'id_safety');
    }

    public function jenisPupuk()
    {
        return $this->belongsTo(JenisPupuk::class, 'id_jenis', 'id_jenis');
    }
}