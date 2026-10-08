<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\JenisPupuk;

class HistorisPenyaluran extends Model
{
    protected $table = 'historis_penyaluran';

    protected $primaryKey = 'id_historis';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'id_historis',
        'id_kios',
        'id_jenis',
        'periode',
        'jumlah_penyaluran',
    ];

    public function kios()
    {
        return $this->belongsTo(
            Kios::class, 
            'id_kios', 
            'id_kios'
        );
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