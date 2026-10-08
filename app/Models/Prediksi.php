<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\JenisPupuk;

class Prediksi extends Model
{
    protected $table = 'prediksi';

    protected $primaryKey = 'id_prediksi';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'id_prediksi',
        'id_kios',
        'id_jenis',
        'periode',
        'hasil_prediksi'
    ];

    public function kios()
    {
        return $this->belongsTo(Kios::class, 'id_kios', 'id_kios');
    }

    public function penyaluran()
    {
        return $this->hasMany(Penyaluran::class, 'id_prediksi', 'id_prediksi');
    }

    public function jenisPupuk()
    {
        return $this->belongsTo(
            JenisPupuk::class,
            'id_jenis',
            'id_jenis'
        );
    }
}