<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FacultyResust extends FormRequest
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
        $rules=[
            'name' => 'required|unique:faculties',
        ];
        switch($this->method()) {
            case 'PUT':
            case 'PATCH':
                $rules['name']    = 'required|unique:faculties,name,' . $this->id;
                break;
        }
        return $rules;
    }
    public function messages()
    {
        return [
            'name.required' => 'نام دانشکده باید وارد شود.',
            'name.unique' => 'نام دانشکده باید مخحصربفرد باشد، دانشکده ای با این نام وجود دارد!',
            ];

    }
}
