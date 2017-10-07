<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Personal;
use App\User;
use App\Http\Controllers\UserController;

class PersonalController extends Controller
{
    public function index(Request $request) {
        $all_personal = Personal::all();
        $columns = \Schema::getColumnListing('personals');

        // Логика проверки авторизации
        $token = $request->header('x-custom-head');
        $current_user = (new UserController(new User()))->checkHeaders($token);

        return $current_user;


        return response()->json([
            $all_personal,
            'columns' => $columns,
            'admin' => $admin,
        ], 200);
    }

    public function show(Personal $persona) {
        return $persona;
    }

    public function store(Request $request) {
        $new_persona = Personal::create($request->all());

        return $new_persona;
    }

    public function update(Request $request, Personal $persona) {

        $persona->update($request->all());

        return response()->json($persona, 200);
    }

    public function  delete(Personal $persona) {

        $persona->delete();

        return response()->json(null, 200);
    }
}
