<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Field;

class FieldController extends Controller
{
    public function index() {

        return Field::all();

    }

    public function show (Field $field) {

        return $field;

    }

    public function store(Request $request) {

        $new_field = Field::create($request->all());

        return $new_field;

    }

    public function update(Request $request, Field $field) {

        $field->update($request->all());

        return response()->json($field, 200);

    }

    public function delete(Field $field) {

        $field->delete();

        return response()->json(null, 200);

    }
}
