<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResearchProposalRequest extends FormRequest
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
            'en_title' => 'required',
            'proposal_type_id' => 'required',
            'proposal_usage_id' => 'required',
            'faculty_id' => 'required',
            'abstract' => 'required',
            'tags'=>'required',
            'introduction' => 'required',
            'problem' => 'required',
            'innovation' => 'required',
            'requirements' => 'required',
            'value' => 'required',
            'budget' =>'required' ,
            'duration' => 'required',
            'project_location' => 'required',
            'authors' => 'required',
            'files.*'=>'mimes:rar,zip,pdf',
            'files'=>'required',
        ];
        if ($this->is('api/researchProposalUpdate/*')) {
            $rules['files'] = 'required_if:fileChangeType,0|required_if:fileChangeType,1';
            $rules['files.*'] = 'sometimes|mimes:rar,zip,pdf';
        }
        return $rules;
    }
    public function messages()
    {
        return [
            'title.required' => 'عنوان فارسی پروپوزال الزامی است.',
            'en_title.required' => 'عنوان انگلیسی پروپوزال الزامی است.',
            'proposal_type_id.required' => 'انتخاب نوع پروپوزال الزامی است.',
            'proposal_usage_id.required' => 'انتخاب نوع کاربرد پروپوزال الزامی است.',
            'faculty_id.required' => 'انتخاب دانشکده مربوطه الزامی است.',
            'abstract.required' => 'چکیده پروپوزال الزامی است.',
            'tags.required' => 'کلمات کلیدی الزامی است.',
            'introduction.required' => 'مقدمه پروپوزال الزامی است.',
            'problem.required' => 'بیان مسئله پروپوزال الزامی است.',
            'innovation.required' => 'نوآوری پروپوزال پیشنهادی الزامی است.',
            'requirements.required' => 'نیازمندی های طرح الزامی است.',
            'value.required' => 'ارزش تخمینی طرح الزامی است.',
            'budget.required' => 'بودجه مورد نیاز پروپوزال الزامی است.',
            'duration.required' => 'مدت زمان مورد نیاز اجرای پروپوزال الزامی است.',
            'project_location.required' => 'محل اجرا و انجام پروپوزال الزامی است.',
            'authors.required' => 'نام اعضای تیم تحقیقاتی الزامی است.',
            'files.required_if' => 'فایل های ضمیمه الزامی است.',
            'files.*' => ' نوع فایل ضمیمه باید یکی از انواع pdf یا zip انتخاب شود.',
        ];
    }
}
