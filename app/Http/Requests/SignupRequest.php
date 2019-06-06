<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SignupRequest extends FormRequest
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
            'name' => 'required|min:6',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed'
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'نام کاربری باید وارد شود.',
            'email.required' => 'رایانامه باید وارد شود.',
            'email.unique' => 'رایانامه وارد شده قبلا در سامانه ثبت نامه کرده است.',
            'email.email' => 'رایانامه باید در فرمت صحیح باشد شود.',
            'password.required' => 'کلمه عبور باید وارد شود.',
            'password.confirmed' => 'تکرار کلمه عبور با کلمه عبور برار نیست.',
            'password.min' => 'کلمه عبور باید حداقل 6 کاراکتر باشد شود.',
        ];
    }
}
