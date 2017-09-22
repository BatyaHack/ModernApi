<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Mockery\Exception;

class FiledController extends Controller
{
    const NAME_TABLE = 'users'; // в какой тайблице добавляются столбцы

    public function index() {

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function add(Request $request) {

        $test = $request->get('test');
        if($this->addColumn($test))
            return response()->json([], 201);
        else
            return response()->json([], 500);
    }


    /**
     * Добавлемя поле в бд. Все поля string типа и null
     * Можно сделать через eval() более крутую генерацию
     * Но это пиздец как опасненько
     * @param $column
     * @return bool
     */
    private function addColumn($column) {

        try
        {
            Schema::table(self::NAME_TABLE, function ($table) use ($column) {
                $table->string($column)->nullable();
            });
        }
        catch (Exception $ex)
        {
            return false;
        }
        return true;
    }
}
