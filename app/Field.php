<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
    protected $guarded = [];

    public function data() {

        return $this->hasMany(Addcol::class);

    }

}
