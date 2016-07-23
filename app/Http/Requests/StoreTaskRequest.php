<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Auth;

class StoreTaskRequest extends Request
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
//        switch($this->method()) {
//            case 'POST':
//        }
        return [
            'name' => 'required'
        ];
    }

    public function messages(){
        return [
            'required' => 'Pole :attribute je povinné!',
            'unique' => 'Hodnota pole :attribute je již použitá!'
        ];
    }

    public function attributes()
    {
        return [
            'name'=>'Název',
            'key'=>'Klíč',
            'description'=>'Popis'
        ];
    }
}
