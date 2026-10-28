<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    public function resenias()
    {
        return $this->hasMany(Resenia::class, 'user_id'); //esto va en el lado 1 de la relación 1:n
    }

    protected $guarded = [
        'id'
    ];

    protected $hidden = [
        'password',
    ];
}
