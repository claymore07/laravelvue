<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResearchActivityRequest extends FormRequest
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
            'research_activity_types_id'=>'required',

            'title'=>'required',
            'authorities'=>'required',
            'start_date' => 'required|date_format:Y-m-d',
            'end_date' => 'required|date_format:Y-m-d',
            'files.*'=>'mimes:rar,zip,pdf',
            'files'=>'required',
        ];
        if ($this->is('api/researchActivityUpdate/*')) {
            $rules['files'] = 'required_if:fileChangeType,0|required_if:fileChangeType,1';
            $rules['files.*'] = 'sometimes|mimes:rar,zip,pdf';
        }
        return $rules;
    }
    public function messages()
    {
        return [
            'research_activity_types_id.required' => 'نوع سمت یا مسئولیت فعالیت پژوهشی الزامی است.',
            'title.required' => 'عنوان سمت یا مسئولیت پژوهشی الزامی است.',
            'authorities.required' => 'نام مرجع تایید کننده الزامی است.',
            'start_date.required' => 'تاریخ شروع فعالیت پژوهشی الزامی است.',
            'start_date.date_format' => 'تاریخ شروع فعالیت پژوهشی باید در قالب مشخص(Y-m-d) شده باشد.',
            'end_date.required' => 'تاریخ اتمام فعالیت پژوهشی الزامی است.',
            'end_date.date_format' => 'تاریخ اتمام فعالیت پژوهشی باید در قالب مشخص(Y-m-d) شده باشد.',
            'files.required' => 'فایل های ضمیمه الزامی است.',
            'files.*' => ' نوع فایل ضمیمه باید یکی از انواع pdf یا zip انتخاب شود.',
        ];
    }
}
