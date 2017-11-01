<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Addcol extends Model
{
    protected $guarded = [];

    public function personal() {

        return $this->belongsTo(Personal::class);

    }

    public function field() {

        return $this->belongsTo(Field::class, 'field_id', 'id');

    }
}
