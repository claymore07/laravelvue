<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InventionRequest extends FormRequest
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
            'invention_types_id' => 'required',
            'post' => 'required',
            'authorities' =>'required',
            'license' =>'required_if:invention_types_id,9' ,
            'license_number' =>'required_if:invention_types_id,9' ,
            'affiliation' =>'required_if:invention_types_id,9' ,
            'registration_number' =>'required_if:invention_types_id,8' ,
            'company_name' =>'required_if:invention_types_id,8' ,
            'company_type' =>'required_if:invention_types_id,8' ,
            'company_address' =>'required_if:invention_types_id,8' ,
            'submit_date' => 'required|date_format:Y-m-d',
            'files.*'=>'mimes:rar,zip,pdf',
            'files'=>'required',
        ];
        if ($this->is('api/inventionUpdate/*')) {
            $rules['files'] = 'required_if:fileChangeType,0|required_if:fileChangeType,1';
            $rules['files.*'] = 'sometimes|mimes:rar,zip,pdf';
        }
        return $rules;
    }
    public function messages()
    {
        return [
            'title.required' => 'عنوان اختراع یا تولید دانش الزامی است.',
            'invention_types_id.required' => 'نوع اختراع یا تولید دانش الزامی است.',
            'post.required' => 'نوع سمت در اختراع یا تولید دانش الزامی است.',
            'authorities.required' => 'نام سازمان صادر کننده تاییدیه الزامی است.',
            'license.required_if' => 'تعیین به فروش رفتن یا لیسان شدن پتنت الزامی است.',
            'license_number.required_if' => 'شماره ثبت پتنت الزامی است.',
            'affiliation.required_if' => 'تعیین نام موسسه ای که پتنت به نام آن ثبت شده، الزامی است.',
            'registration_number.required_if' => 'شماره ثبت شرکت الزامی است.',
            'company_name.required_if' => 'نام شرکت الزامی است.',
            'company_type.required_if' => 'نوع شخصیت حقوقی شرکت الزامی است.',
            'company_address.required_if' => 'آدرس شرکت الزامی است.',
            'submit_date.required' => 'تاریخ صدور تاییدیه یا مجوز الزامی است.',
            'submit_date.date_format' => 'تاریخ صدور تاییدیه یا مجوز باید در قالب مشخص(Y-m-d) شده باشد.',
            'files.required_if' => 'فایل های ضمیمه الزامی است.',
            'files.*' => ' نوع فایل ضمیمه باید یکی از انواع pdf یا zip انتخاب شود.',
        ];
    }
}
