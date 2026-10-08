<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kios extends Model
{
    protected $table = 'kios';

    protected $primaryKey = 'id_kios';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'id_kios',
        'nama_kios',
        'kecamatan'
    ];

    public function pengajuan()
    {
        return $this->hasMany(Pengajuan::class, 'id_kios', 'id_kios');
    }

    public function prediksi()
    {
        return $this->hasMany(Prediksi::class, 'id_kios', 'id_kios');
    }

    public function penyaluran()
    {
        return $this->hasMany(Penyaluran::class, 'id_kios', 'id_kios');
    }

    public function historisPenyaluran()
    {
        return $this->hasMany(HistorisPenyaluran::class, 'id_kios', 'id_kios');
    }
}