<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class registrationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|min:8|max:16|',
            'email' => 'required|email',
            'password' => 'required|min:8|max:16|regex:/(?=.*[0-9])(?=.*[!@#$%^&*])(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z!@#$%^&*]/|testPopularPassword',
        ];
    }
}
