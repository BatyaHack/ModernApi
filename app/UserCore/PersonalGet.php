<?php

namespace App\UserCore\PersonalHelper;

use App\Addcol;
use App\Personal;
use App\Field;
use ErrorException;
use Illuminate\Http\Request;


class PersonalGet
{
    public function __construct()
    {
    }

    public function getInfo()
    {
        $all_personal = Personal::all()->toArray();
        $fields = Field::all()->toArray();
        $add_column = Addcol::all();

        foreach ($fields as $field) {

            foreach ($all_personal as &$persona) {
                try {
                    $persona[$field['name']] = $add_column
                        ->where('field_id', '=', $field['id'])
                        ->where('personal_id', '=', $persona['id'])
                        ->pluck('data')[0];
                } catch (ErrorException $ex) {
                    $persona[$field['name']] = '';
                }

            }
        }

        return $all_personal;

    }
}