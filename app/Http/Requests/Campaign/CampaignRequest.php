<?php

namespace App\Http\Requests\Campaign;

use Illuminate\Foundation\Http\FormRequest;

class CampaignRequest extends FormRequest
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
            'name'=>'required'
        ];
        return $rules;
    }

    public function data(){

        $inputs=[
            'name' => $this->get('name'),
            'alias'   => $this->get('alias'),
            'details'   => $this->get('details'),
            'starts'   => $this->get('starts'),
            'ends'   => $this->get('ends'),
            'success_message'   => $this->get('success_message'),
            'email_success'   => $this->get('email_success'),
            'sms_message'   => $this->get('sms_message'),
            'coupon_codes'   => $this->get('coupon_codes'),
            'url'   => $this->get('url'),
            'keywords'   => $this->get('keywords'),
            'ogtags'   => $this->get('ogtags'),
            'headers'   => $this->get('headers'),
            'description'   => $this->get('description'),
            'status' => ($this->get('status') ? $this->get('status') : '') == 'on' ? 'active' : 'in_active',
            'created_by'   => Auth()->user()->id,
        ];

        if($this->get('offered_course')) {
            $offered_course = collect($this->get('offered_course'));
        }

        if(isset($offered_course)) {
            $inputs['offered_course'] = $offered_course->implode(',');
        }

        if($this->get('keywords')) {
            $keywords = collect($this->get('keywords'));
        }

        if(isset($keywords)) {
            $inputs['keywords'] = $keywords->implode(',');
        }

        if ($this->has('status')) {
            $inputs['status'] = "active";
        }

        return $inputs;
    }
}
