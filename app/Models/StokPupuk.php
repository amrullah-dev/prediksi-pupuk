<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StokPupuk extends Model
{
    protected $table = 'stok_pupuk';

    protected $primaryKey = 'id_stok';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'id_stok',
        'id_jenis',
        'periode',
        'jumlah_stok'
    ];

    public function penyaluran()
    {
        return $this->hasMany(Penyaluran::class, 'id_stok', 'id_stok');
    }

    public function safetyStok()
    {
        return $this->hasMany(SafetyStok::class, 'id_stok', 'id_stok');
    }
    public function jenisPupuk()
    {
        return $this->belongsTo(JenisPupuk::class, 'id_jenis', 'id_jenis');
    }
}