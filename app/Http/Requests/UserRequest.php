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
            'base' => 'required_if:position_id,1|required_if:position_id,2|required_if:position_id,3',


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
    public function messages()
    {
        return [
            'Fname.required' => 'نام باید وارد شود.',
            'Lname.required' => 'نام خانوادگی باید وارد شود.',
            'name.required' => 'نام کاربری باید وارد شود.',
            'siba.required' => 'شماره حساب باید وارد شود.',
            'siba.numeric' => 'شماره حساب باید عدد باشد.',
            'phone.numeric' => 'شماره تماس باید عدد باشد.',
            'phone.required' => 'شماره تماس باید وارد شود.',
            'personal_id.required' => 'شماره پرسنلی باید وارد شود.',
            'email.required' => 'رایان نامه باید وارد شود.',
            'email.email' => 'رایان نامه باید در فرمت صحیح باشد شود.',
            'password.required' => 'کلمه عبور باید وارد شود.',
            'password.min' => 'کلمه عبور باید حداقل 6 کاراکتر باشد شود.',
            'base.required' => 'پایه باید وارد شود.',
            'role_id.required' => 'نوع دسترسی باید انتخاب شود.',
            'position_id.required' => 'نوع همکاری باید انتخاب شود.',
            'member_id.required' => 'نوع عضویت در باشگاه پژوهشگران باید انتخاب شود.',
            'faculty_id.required' => 'نام دانشکده باید انتخاب شود.',
            'rank_id.required' => 'مرتبه علمی باید انتخاب شود.',
            'degree_id.required' => 'مدرک تحصیلی باید انتخاب شود.',
            'department_id.required' => 'نام گروه آموزشی باید انتخاب شود.',

        ];
    }
}
