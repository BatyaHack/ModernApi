<?php

namespace App\Http\Controllers;

use App\UserCore\PersonalHelper\PersonalUpdate;
use App\Field;
use Illuminate\Http\Request;
use App\Personal;
use Illuminate\Support\Facades\DB;


class PersonalController extends UserController
{

    public function index(Request $request = null)
    {
        $all_personal = Personal::with('data.field')->get();

        $columns = \Schema::getColumnListing('personals');
        $helper_columns = Field::all()->pluck('name')->toArray();
        $full_columns = array_merge($columns, $helper_columns);

        if (empty($request)) {
            dd('here');
            $current_user = false;
        } else {
            $current_user = $this->getAuthUserHeader($request);
        }

        return response()->json([
            $all_personal,
            'columns' => $full_columns,
            'user' => $current_user,
        ], 200);
    }

    public function show(Personal $persona)
    {
        return $persona;
    }

    public function store(Request $request)
    {
        return DB::transaction(function () use ($request) {
            $new_persona = Personal::create($request->all());

            return $new_persona;
        });
    }

    public function update(Request $request, Personal $persona)
    {
        $a = new PersonalUpdate($request, $persona);
        $a->updateCustomKey();

        $persona->update($request->all());

        return response()->json($persona, 200);
    }

    public function delete(Personal $persona)
    {

        $persona->delete();

        return response()->json(null, 200);
    }
}
