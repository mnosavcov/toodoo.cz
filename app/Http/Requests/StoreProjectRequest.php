<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;
use Route;

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
        if(Route::current()->getParameter('owner')) return [];
        return [
            'name' => 'required|unique:projects,name,'.$this->input('project_id').',id,user_id,'.Auth::id(),
            'key' => 'required|unique:projects,key,'.$this->input('project_id').',id,user_id,'.Auth::id()
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
