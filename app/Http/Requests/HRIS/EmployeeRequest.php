<?php

namespace App\Http\Requests\HRIS;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeRequest extends FormRequest
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
        return [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'mobile' => 'required|max:12',
            'address' => 'required|max:255',
            'dept_id' => 'required|integer',
            'designation_id' => 'required|integer',
            'shift_id' => 'required|integer',
            'is_login' => 'required|max:255',
        ];
    }
}
