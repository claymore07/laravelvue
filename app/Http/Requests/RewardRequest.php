<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RewardRequest extends FormRequest
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
            'name' => 'required',
            'title' => 'required',
            'type' => 'required',
            'place' => 'required',
            'period' =>'required' ,
            'holding_date' => 'required',
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
            'name.required' => 'نام جشنوار یا مسابقه الزامی است.',
            'title.required' => 'عنوان جایزه الزامی است.',
            'type.required' => 'نوع جشنواره یا مسابقه الزامی است.',
            'place.required' => 'رتبه کسب شده الزامی است.',
            'period.required' => 'دوره جشنواره یا مسابقه الزامی است. در صورت نبود مقدار 1 را استفاده کنید.',
            'holding_date.required' => 'تاریخ برگزاری جشنواره یا مسابقه الزامی است.',
            'files.required_if' => 'فایل های ضمیمه الزامی است.',
            'files.*' => ' نوع فایل ضمیمه باید یکی از انواع pdf یا zip انتخاب شود.',
        ];
    }
}
