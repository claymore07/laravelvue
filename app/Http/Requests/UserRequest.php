<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        $rules = [
            //
            'name' =>'required|string|max:191',
            'email' => 'required|email|string|max:191|unique:users',

            'type' => 'required',
            'password' => 'required|string|min:6',

            'Fname'=>'required',
            'Lname'=>'required',
            'siba'=>'required|numeric',
            'phone'=>'required|numeric',
            'personal_id'=>'required|numeric',
            //'role_id'=>'required',
            'position_id'=>'required',
            'member_id'=>'required',
            'faculty_id'=>'required',
            'rank_id'=>'required',
            'degree_id'=>'required',
            'department_id'=>'required',


        ];

        switch($this->method()) {
            case 'PUT':
            case 'PATCH':
                $rules['email']    = 'email|required|unique:users,email,' . $this->id;
                $rules['password'] = 'sometimes|required|string|min:6';
                break;
        }

        return $rules;
    }
}
