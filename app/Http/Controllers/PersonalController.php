<?php

namespace App\Http\Controllers;

use App\UserCore\PersonalHelper\PersonalUpdate;
use App\Field;
use Illuminate\Http\Request;
use App\Personal;
use Illuminate\Support\Facades\DB;


class PersonalController extends UserController
{

    protected $personalHelper;

    public function __construct(PersonalUpdate $personalHelper)
    {
        $this->personalHelper = $personalHelper;
    }

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

            $a = new $this->personalHelper($request, $new_persona);
            $a->updateCustomKey();
            return $a->infoMerge($new_persona);
        });
    }

    public function update(Request $request, Personal $persona)
    {
        $a = new $this->personalHelper($request, $persona);
        $a->updateCustomKey();
        $persona->update($request->all());
        $edit_persona = $a->infoMerge($persona);
        return response()->json($edit_persona, 200);
    }

    public function delete(Personal $persona)
    {
        $persona->delete();
        return response()->json(null, 200);
    }
}
