<?php

namespace App\Http\Controllers;

use App\Addcol;
use App\Field;
use App\UserCore\PersonalHelper\PersonalGet;
use App\UserCore\PersonalHelper\PersonalUpdate;
use ErrorException;
use Illuminate\Http\Request;
use App\Personal;
use Illuminate\Support\Facades\DB;


class PersonalController extends UserController
{

    protected $personal_helper;
    protected $personal_get_helper;

    public function __construct(PersonalUpdate $personal_helper, PersonalGet $personal_get_helper)
    {
        $this->$personal_helper = $personal_helper;
        $this->$personal_get_helper = $personal_get_helper;
    }

    public function index(Request $request = null)
    {
        $a = new $this->$personal_get_helper();
        $all_personal = $a->getInfo();
        $columns = array_keys($all_personal[0]);


        if (empty($request)) {
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
            $a = new $this->personal_helper($request, $new_persona);
            $a->updateCustomKey();
            return $a->infoMerge($new_persona);
        });
    }

    public function update(Request $request, Personal $persona)
    {
        $a = new $this->personal_helper($request, $persona);
        $a->updateCustomKey();
        $persona->update($request->all());
        $edit_persona = $a->infoMerge($persona);
        return response()->json($edit_persona, 200);
    }

    public function delete(Personal $persona)
    {
        return DB::transaction(function () use ($persona){
            Addcol::where('personal_id', $persona->id)->delete();
            $persona->delete();
            return response()->json(null, 200);
        });
    }
}
