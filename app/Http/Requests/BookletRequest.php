<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookletRequest extends FormRequest
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
            'degree_id'=>'required',
            'title'=>'required',
            'name'=>'required',
            'booklet_type'=>'required',
            'compilation_date'=>'required',
            'files'=>'required',
            'files.*'=>'mimes:rar,zip,pdf',

        ];
        if ($this->is('api/bookletUpdate/*')) {
                $rules['files'] = 'required_if:fileChangeType,0|required_if:fileChangeType,1';
                $rules['files.*'] = 'sometimes|mimes:rar,zip,pdf';
        }
        return $rules;
    }
    public function messages()
    {
        return [
            'degree_id.required' => 'مقطع تدریس الزامی است.',
            'title.required' => 'عنوان جزوه یا اسلاید الزامی است.',
            'name.required' => 'نام درس الزامی است.',
            'booklet_type.required' => 'نوع جزوه یا اسلاید الزامی است.',
            'compilation_date.required' => 'تاریخ تالیف یا تنظیم الزامی است.',
            'files.required' => 'فایل های ضمیمه الزامی است.',
            'files.*' => ' نوع فایل ضمیمه باید یکی از انواع pdf یا zip انتخاب شود.',
        ];
    }
}
