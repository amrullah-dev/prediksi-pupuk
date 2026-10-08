<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisPupuk extends Model
{
    protected $table = 'jenis_pupuk';

    protected $primaryKey = 'id_jenis';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [

        'id_jenis',

        'nama_pupuk'

    ];
}