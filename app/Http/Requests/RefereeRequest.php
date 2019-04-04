<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RefereeRequest extends FormRequest
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
            'title' => 'required',
            'referee_types_id' => 'required',
            'journal_name' => 'required_if:referee_types_id,1|required_if:referee_types_id,2',
            'journal_issn' =>'required_if:referee_types_id,1|required_if:referee_types_id,2' ,
            'referee_date' => 'sometimes|required|date_format:Y-m-d',
            //'files.*'=>'mimes:rar,zip,pdf',
            // 'files'=>'required',
        ];
        switch ($this->method()) {
            case 'PUT':
            case 'PATCH':
                $rules['files'] = 'required_if:fileChangeType,0|required_if:fileChangeType,1';
                $rules['files.*'] = 'sometimes|mimes:rar,zip,pdf';
                break;
        }
        return $rules;
    }
    public function messages()
    {
        return [
            'title.required' => 'عنوان اثر داوری شده الزامی است.',
            'referee_types_id.required' => 'نوع داوری الزامی است.',
            'journal_name.required_if' => 'عنوان مجله الزامی است.',
            'journal_issn.required_if' => 'شماره ISSN مجله الزامی است.',
            'referee_date.required' => 'تاریخ داوری در صورت وارد شدن الزامی است.',
            'referee_date.date_format' => 'تاریخ داوری باید در قالب مشخص(Y-m-d) شده باشد.',
            'files.required_if' => 'فایل های ضمیمه الزامی است.',
            'files.*' => ' نوع فایل ضمیمه باید یکی از انواع pdf یا zip انتخاب شود.',
        ];
    }
}
