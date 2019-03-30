<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookResquest extends FormRequest
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
            'booktype_id'=>'required',
            'excerpt_id'=>'required|string',
            'title'=>'required',
            'isbn'=>'required',
            'publisher'=>'required',
            'subject'=>'required',
            'edited'=>'required',
            'edited_number'=>'required_if:edited,1',
            'publish_number'=>'required',
            'publish_year' => 'required',
            'pages' => 'required',
            'copy_number' => 'required',
            'authors' => 'required',
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
            'booktype_id.required' => 'نوع کتاب الزامی است.',
            'excerpt_id.required' => 'نوع مستخرج بودن الزامی است.',
            'title.required' => 'عنوان کتاب الزامی است.',
            'isbn.required' => 'شابک کتاب الزامی است.',
            'publisher.required' => 'اطلاعات ناشر الزامی است.',
            'subject.required' => 'موضوع الزامی است.',
            'edited.required' => 'تعیین وضعیت ویرایش الزامی است.',
            'edited_number.required_if'=>'شماره ویرایش الزامی است.',
            'publish_number.required' => 'شماره چاپ کتاب الزامی است.',
            'publish_year.required' => 'سال چاپ کتاب الزامی است.',
            'pages.required' => 'تعداد صفحات کتاب الزامی است.',
            'copy_number.required' => 'تیراژ کتاب الزامی است.',
            'authors.required' => 'نام نویسندگان الزامی است.',
            'authorsjson.min' => 'نام نویسندگان الزامی است.',
            'files.required' => 'فایل های ضمیمه الزامی است.',
            'files.*' => ' نوع فایل ضمیمه باید یکی از انواع pdf یا zip انتخاب شود.',
        ];
    }
}
