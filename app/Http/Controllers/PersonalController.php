<?php

namespace App\Http\Controllers;

use App\Addcol;
use App\UserCore\PersonalHelper\PersonalUpdate;
use App\Field;
use ErrorException;
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
        $all_personal = Personal::all()->toArray();
        $fields = Field::all()->toArray();
        $add_column = Addcol::all();

        //немного проблемно с производительностью, но это не точно!
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

        $columns = array_keys($all_personal[0]);


        if (empty($request)) {
            dd('here');
            $current_user = false;
        } else {
            $current_user = $this->getAuthUserHeader($request);
        }

        return response()->json([
            $all_personal,
            'columns' => $columns,
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
