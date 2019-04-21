<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GrantRequest extends FormRequest
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
            'type' => 'required|string',
            'budget' => 'required',
            'submit_date' => 'required|date_format:Y-m-d',
            'files.*'=>'mimes:rar,zip,pdf',
            'files'=>'required',
        ];
        if ($this->is('api/grantUpdate/*')) {
            $rules['files'] = 'required_if:fileChangeType,0|required_if:fileChangeType,1';
            $rules['files.*'] = 'sometimes|mimes:rar,zip,pdf';
        }
        return $rules;
    }
    public function messages()
    {
        return [
            'title.required' => 'عنوان بودجه جذب شده الزامی است.',
            'type.required' => 'نوع بودجه جذب شده الزامی است.',
            'budget.required' => 'میزان بودجه جذب شده الزامی است.',
            'submit_date.required' => 'تاریخ جذب بودجه الزامی است.',
            'files.required_if' => 'فایل های ضمیمه الزامی است.',
            'files.*' => ' نوع فایل ضمیمه باید یکی از انواع pdf یا zip انتخاب شود.',
        ];
    }
}
