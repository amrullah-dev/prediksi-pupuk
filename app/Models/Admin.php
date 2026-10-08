<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $table = 'admin';

    protected $primaryKey = 'id_admin';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'id_admin',
        'nama_admin',
        'email',
        'username',
        'password'
    ];

    protected $hidden = [
        'password'
    ];
}