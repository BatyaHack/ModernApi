<?php

namespace App\Http\Controllers;

use Error;
use Illuminate\Http\Request;
use App\Personal;
use App\User;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Cookie;
use Mockery\Exception;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class PersonalController extends Controller
{
    public function index(Request $request)
    {
        $all_personal = Personal::all();
        $columns = \Schema::getColumnListing('personals');


        try {

            $header = $request->header('x-custom-token');
            $current_user = (new UserController(new User()))->checkHeaders($header);

        } catch (TokenInvalidException $error) {

            $current_user = false;

        } catch (TokenExpiredException $ex) {

            $current_user = false;

        }

        return response()->json([
            $all_personal,
            'columns' => $columns,
            'admin' => true,
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
