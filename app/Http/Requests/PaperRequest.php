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
            //'link'=>'required',
            'title'=>'required|string',
            'abstract'=>'required',
            'excerpt_id'=>'required',
            'tags'=>'required',
            'license_to'=>'required_if:excerpt_id,1',
            'license'=>'required_if:excerpt_id,3',
            'accept_date' => 'required',
            'publish_date' => 'required',
            'files'=>'required',
            'files.*'=>'mimes:rar,zip,pdf',
            'confname'=>'required_if:paperType,==,conf',
            'city'=>'required_if:paperType,==,conf',
            'organizer'=>'required_if:paperType,==,conf',
            'conftype_id'=>'required_if:paperType,==,conf',
            'period'=>'required_if:paperType,==,conf',
            'jtype_id'=>'required_if:paperType,==,jur',
            'jname'=>'required_if:paperType,==,jur',
            'publisher'=>'required_if:paperType,==,jur',
            'issn'=>'required_if:paperType,==,jur',
            'isresponsible'=>'required',
            'author_count'=>'required',
            'author_place'=>'required',
            'authors' => 'required',


        ];
        if ($this->is('api/paperUpdate/*')) {
            $rules['files'] = 'required_if:fileChangeType,0|required_if:fileChangeType,1';
            $rules['files.*'] = 'sometimes|mimes:rar,zip,pdf';
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
            'city.required_if'=>'شهر کنفرانس الزامی است.',
            'organizer.required_if'=>'برگزار کننده کنفرانس الزامی است.',
            'conftype_id.required_if'=>'نوع کنفرانس الزامی است.',
            'period.required_if'=>'دوره برگزاری کنفرانس الزامی است.',
            'jtype_id.required_if'=>'نوع مجله الزامی است.',
            'publisher.required_if'=>'نام ناشر الزامی است.',
            'jname.required_if'=>'نام مجله الزامی است.',
            'issn.required_if'=>'شماره ISSN الزامی است.',
            'isresponsible.required'=>'انتخاب نویسنده مسئول الزامی است.',
            'author_count.required'=>'تعداد نویسندگان الزامی است.',
            'author_place.required'=>'جایگاه شما در میان نویسندگان الزامی است.',
            'authors.required' => 'نام نویسندگان الزامی است.',
            'authorsjson.min' => 'نام نویسندگان الزامی است.',

        ];
    }
}
