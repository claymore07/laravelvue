<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DepartmentResust extends FormRequest
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
            'name' => 'required|unique:departments',
        ];
        switch($this->method()) {
            case 'PUT':
            case 'PATCH':
                $rules['name']    = 'required|unique:departments,name,' . $this->id;
                break;
        }
        return $rules;
    }
    public function messages()
    {
        return [
            'name.required' => 'نام گروه آموزشی باید وارد شود.',
            'name.unique' => 'نام گروه آموزشی  باید مخحصربفرد باشد، گروه آموزشی  ای با این نام وجود دارد!',
        ];

    }
}
