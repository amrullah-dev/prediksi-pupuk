<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistorisPenyaluran extends Model
{
    protected $table = 'historis_penyaluran';

    protected $primaryKey = 'id_historis';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'id_historis',
        'id_kios',
        'periode',
        'jumlah_penyaluran',
    ];

    public function kios()
    {
        return $this->belongsTo(Kios::class, 'id_kios', 'id_kios');
    }
}