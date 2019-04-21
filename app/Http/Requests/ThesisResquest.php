<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ThesisResquest extends FormRequest
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
            'theses_types_id'=>'required',
            'title'=>'required',
            'group_aprovedate'=>'required',
            'council_aprovedate'=>'required',
            'code_date'=>'required',
            'defense_date'=>'required',
        ];
        switch ($this->method()) {
            case 'PUT':
            case 'PATCH':
                break;
        }
        return $rules;
    }
    public function messages()
    {
        return [
            'theses_types_id.required' => 'نوع مسئولیت در پایان نامه الزامی است.',
            'title.required' => 'عنوان پایان نامه الزامی است.',
            'group_aprovedate.required' => 'تاریخ تصویب در گروه الزامی است.',
            'council_aprovedate.required' => 'تاریخ تصویب در شورای پژوهشی الزامی است.',
            'code_date.required' => 'تاریخ دریافت کد پایان نامه الزامی است.',
            'defense_date.required' => 'تاریخ دفاع پایان نامه الزامی است.',
        ];
    }
}
