<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CourseRequest extends FormRequest
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
            'title' => 'required|string',
            'role' => 'required|string',
            'organization' => 'required|string',
            'duration' =>'sometimes|required|integer' ,
            'holding_date' => 'required|date_format:Y-m-d',
            'files.*'=>'mimes:rar,zip,pdf',
            'files'=>'required',
        ];
        if ($this->is('api/courseUpdate/*')) {
            $rules['files'] = 'required_if:fileChangeType,0|required_if:fileChangeType,1';
            $rules['files.*'] = 'sometimes|mimes:rar,zip,pdf';
        }
        return $rules;
    }
    public function messages()
    {
        return [
            'title.required' => 'عنوان دوره الزامی است.',
            'role.required' => 'نقش شما در دوره الزامی است.',
            'organization.required' => 'سازمان یا موسسه برگزارکننده الزامی است.',
            'duration.required' => 'مدت زمان الزامی است. ',
            'holding_date.required' => 'تاریخ برگزاری دوره الزامی است.',
            'files.required_if' => 'فایل های ضمیمه الزامی است.',
            'files.*' => ' نوع فایل ضمیمه باید یکی از انواع pdf یا zip انتخاب شود.',
        ];
    }
}
