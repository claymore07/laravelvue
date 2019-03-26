<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaperRequest extends FormRequest
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

            'lang'=>'required',
            'link'=>'required',
            'title'=>'required|string',
            'abstract'=>'required',
            'excerpt_id'=>'required',
            'tags'=>'required',
            'license_to'=>'required_if:excerpt_id,1',
            'license'=>'required_if:excerpt_id,3',
            'accept_date' => 'required',
            'publish_date' => 'required',
            //'files'=>'required',
            //'files.*'=>'mimes:zip,pdf',
            'confname'=>'required_if:paperType,==,conf',
            'confcity'=>'required_if:paperType,==,conf',
            'conforganizer'=>'required_if:paperType,==,conf',
            'conftype_id'=>'required_if:paperType,==,conf',
            'confperiod'=>'required_if:paperType,==,conf',
            'jtype_id'=>'required_if:paperType,==,jur',
            'jname'=>'required_if:paperType,==,jur',
            'jpublisher'=>'required_if:paperType,==,jur',
            'jISSN'=>'required_if:paperType,==,jur',
            'isresponsible'=>'required',
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
            'title.required' => 'عنوان مقاله الزامی است.',
            'abstract.required' => 'چکیده مقاله الزامی است.',
            'link.required' => 'لینک مقاله الزامی است.',
            'tags.required' => 'کلمات کلیدی الزامی است.',
            'excerpt_id.required' => 'نوع مستخرج بودن الزامی است.',
            'license_to.required_if'=>'نوع مقاله باید مشخص شود که جزو موظفی طرح می باشد یا مازاد موظفی!',
            'license.required_if'=>'توضیحات مجوز شورای پژوهش باید درج شود!',
            'files.required' => 'فایل های ضمیمه الزامی است.',
            'files.*' => ' نوع فایل ضمیمه باید یکی از انواع pdf یا zip انتخاب شود.',
            'accept_date.required' => 'تاربخ پذیرش الزامی است.',
            'publish_date.required' => 'تاربخ چاپ الزامی است.',
            'confname.required_if'=>'نام کنفرانس الزامی است.',
            'confcity.required_if'=>'شهر کنفرانس الزامی است.',
            'conforganizer.required_if'=>'برگزار کننده کنفرانس الزامی است.',
            'conftype_id.required_if'=>'نوع کنفرانس الزامی است.',
            'confperiod.required_if'=>'دوره برگزاری کنفرانس الزامی است.',
            'jtype_id.required_if'=>'نوع مجله الزامی است.',
            'jpublisher.required_if'=>'نام ناشر الزامی است.',
            'jname.required_if'=>'نام مجله الزامی است.',
            'jISSN.required_if'=>'شماره ISSN الزامی است.',
            'isresponsible.required'=>'انتخاب نویسنده مسئول الزامی است.',
            'authors.required' => 'نام نویسندگان الزامی است.',
            'authorsjson.min' => 'نام نویسندگان الزامی است.',

        ];
    }
}
