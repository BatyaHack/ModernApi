<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
    protected $guarded = [];
    protected $primaryKey = 'name';
    public $incrementing  = false;

    public function data() {

        return $this->hasMany(Addcol::class);

    }

}
