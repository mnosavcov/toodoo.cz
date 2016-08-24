<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class StoreProjectRequest extends FormRequest
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
            'name' => 'required|unique:projects,name,'.$this->input('project_id').',id,user_id,'.Auth::user()->id,
            'key' => 'required|unique:projects,key,'.$this->input('project_id').',id,user_id,'.Auth::user()->id
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
