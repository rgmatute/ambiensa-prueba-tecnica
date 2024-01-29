<?php

namespace App\Domain;

use Illuminate\Database\Eloquent\Model;

class Clients extends Model
{

    protected $table = 'clients';
    protected $fillable = [
        'firts_name',
        'last_name',
        'email',
        'password',
        'status',
        'created_at',
        'updated_at'
    ];
}
