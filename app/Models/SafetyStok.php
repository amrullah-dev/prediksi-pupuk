<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\StokPupuk;

class SafetyStok extends Model
{
    protected $table = 'safety_stok';

    protected $primaryKey = 'id_safety';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'id_safety',
        'id_stok',
        'id_jenis',
        'periode',
        'safety_stok',
        'siap_salur',
    ];

    public function stokPupuk()
    {
        return $this->belongsTo(StokPupuk::class, 'id_stok', 'id_stok');
    }

    public function penyaluran()
    {
        return $this->hasMany(Penyaluran::class, 'id_safety', 'id_safety');
    }

    public function prediksi()
    {
        return $this->belongsTo(Prediksi::class, 'id_prediksi', 'id_prediksi');
    }

    public function jenisPupuk()
    {
        return $this->belongsTo(JenisPupuk::class, 'id_jenis', 'id_jenis');
    }
}