<?php

namespace App\UserCore\PersonalHelper;


use App\Addcol;
use App\Field;
use App\Personal;
use Illuminate\Http\Request;


class PersonalUpdate
{

    private $request;
    private $personal;
    private $keys;
    private $STANDART_KEY = [
        'name' => 0,
        'family' => 0,
        'patronymic' => 0,
        'created_at' => 0,
        'updated_at' => 0,
    ];

    public function __construct(Request $request, Personal $personal)
    {
        $this->request = $request;
        $this->personal = $personal;
    }

    private function filterUselessKey()
    {
        $key_list = $this->STANDART_KEY;

        $this->keys = array_filter($this->request->all(), function ($k) use ($key_list) {
            return !isset($key_list[$k]);
        }, ARRAY_FILTER_USE_KEY);

        return $this->keys;
    }

    private function getField()
    {
        $keys = array_keys($this->filterUselessKey());
        return Field::find($keys)->pluck('id');
    }

    public function updateCustomKey()
    {
        $keys_id = $this->getField();

        foreach ($keys_id as $id) {
            Addcol::updateOrCreate(
                ['field_id' => $id, 'personal_id' => $this->personal->id],
                ['data' => $this->keys[Field::where('id', $id)->value('name')]]
            );
        }
    }

    public function infoMerge(Personal $personal) {
        return array_merge($personal->toArray(), $this->filterUselessKey());
    }
}