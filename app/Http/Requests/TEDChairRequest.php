<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TEDChairRequest extends FormRequest
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
            'ted_types_id' => 'required',
            'location' => 'required',
            'presentation_date' => 'required|date_format:Y-m-d',
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
            'title.required' => 'عنوان کرسی نظریه پردازی الزامی است.',
            'ted_types_id.required' => 'نوع کرسی نظریه پردازی الزامی است.',
            'location.required' => 'محل برگزاری الزامی است.',
            'presentation_date.required' => 'تاریخ ارائه الزامی است.',
            'presentation_date.date_format' => 'تاریخ ارائه باید در قالب مشخص(Y-m-d) شده باشد.',
            'files.required_if' => 'فایل های ضمیمه الزامی است.',
            'files.*' => ' نوع فایل ضمیمه باید یکی از انواع pdf یا zip انتخاب شود.',
        ];
    }
}
