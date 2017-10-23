<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class personal extends Authenticatable
{
    use Notifiable;

    protected $guarded = ['id'];

    public function data() {

        return $this->hasMany(AddCol::class);

    }
}
