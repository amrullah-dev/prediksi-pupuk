<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengajuan extends Model
{
    protected $table = 'pengajuan';

    protected $primaryKey = 'id_pengajuan';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'id_pengajuan',
        'id_kios',
        'periode',
        'jumlah_pengajuan'
    ];

    public function kios()
    {
        return $this->belongsTo(Kios::class, 'id_kios', 'id_kios');
    }
}