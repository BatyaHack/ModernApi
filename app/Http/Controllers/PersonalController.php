<?php

namespace App\Http\Controllers;

use App\Addcol;
use App\Field;
use Error;
use Illuminate\Http\Request;
use App\Personal;
use App\User;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Cookie;
use Mockery\Exception;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class PersonalController extends UserController
{
    public function index(Request $request = null)
    {
        $all_personal = Personal::all();
        $add_data = [];

        for ($i = 0; $i < count($all_personal); $i++) {

            // чееее уже два запроса. Может ложить в меременную?!
            $add_data[] = $all_personal[$i]->data->pluck('data');
            $add_id[] = $all_personal[$i]->data->pluck('field_id');
            $add_key = [];

            for($i = 0; $i < count($add_id); $i++) {


                for ($j = 0; $j < count($add_id[$i]); $j++) {

                  $add_key[] = Field::find($add_id[$i][$j]);

                }

            }

            // обойти дополнительные ключи
            // вставить доп ключ и доп дату

            // типа так
            $all_personal[$i]['some'] = 123;

        }

        return $all_personal;


        if (empty($request)) {
            dd('here');
            $current_user = false;
        } else {
            $current_user = $this->getAuthUserHeader($request);
        }

        return response()->json([
            $all_personal,
            'columns' => [],
            'user' => $current_user,
        ], 200);
    }

    public function show(Personal $persona)
    {
        return $persona;
    }

    public function store(Request $request)
    {
        $new_persona = Personal::create($request->all());

        return $new_persona;
    }

    public function update(Request $request, Personal $persona)
    {

        $persona->update($request->all());

        return response()->json($persona, 200);
    }

    public function delete(Personal $persona)
    {

        $persona->delete();

        return response()->json(null, 200);
    }
}
