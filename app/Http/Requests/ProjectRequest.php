<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectRequest extends FormRequest
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
            'project_types_id' => 'required',
            'organization' => 'required',
            'budget' =>'required' ,
            'council_aprovedate' => 'required|date_format:Y-m-d',
            'defense_date' => 'required|date_format:Y-m-d',
            'authors' => 'required',
            'isresponsible' => 'required',
            //'files.*'=>'mimes:rar,zip,pdf',
            'files'=>'required',
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
            'title.required' => 'عنوان جایزه الزامی است.',
            'project_types_id.required' => 'انتخاب نوع طرح الزامی است.',
            'organization.required' => 'سازمان طرف قرارداد الزامی است.',
            'budget.required' => 'بودجه طرح الزامی است.',
            'council_aprovedate.required' => 'تاریخ تصویب طرح الزامی است.',
            'council_aprovedate.date_format' => 'تاریخ تصویب طرح باید در قالب مشخص(Y-m-d) شده باشد.',
            'defense_date.required' => 'تاریخ دفاع طرح الزامی است.',
            'defense_date.date_format' => 'تاریخ دفاع طرح باید در قالب مشخص(Y-m-d) شده باشد.',
            'isresponsible.required'=>'انتخاب مسئول طرح الزامی است.',
            'authors.required' => 'نام اعضای تیم تحقیقاتی الزامی است.',
            'files.required_if' => 'فایل های ضمیمه الزامی است.',
            'files.*' => ' نوع فایل ضمیمه باید یکی از انواع pdf یا zip انتخاب شود.',
        ];
    }
}
