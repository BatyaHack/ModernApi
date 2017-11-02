<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class personal extends Authenticatable
{
    use Notifiable;

    protected $fillable = ['name', 'family', 'patronymic', 'created_at', 'updated_at'];

    public function data() {

        return $this->hasMany(AddCol::class);

    }
}
