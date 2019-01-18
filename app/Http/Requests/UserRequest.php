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
            'bio' => 'required',
            'type' => 'required',
            'password' => 'required|string|min:6'
        ];
        switch($this->method()) {
            case 'PUT':
            case 'PATCH':
                $rules['email']    = 'email|required|unique:users,email,' . $this->route("user");
                $rules['password'] = 'sometimes|string|min:6';
                break;
        }

        return $rules;
    }
}
