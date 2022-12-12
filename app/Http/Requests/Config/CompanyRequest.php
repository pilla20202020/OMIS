<?php

namespace App\Http\Requests\Config;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules;


class CompanyRequest extends FormRequest
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
        return  [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'mobile' => ['required', 'max:15'],
            'company_name' => ['required', 'max:255'],
            'company_email' => ['required', 'max:255', 'email','unique:companies']
        ];
    }

    // public function messages()
    // {
    //     return [
    //         'country_name.required' => 'Country Name is required!',
    //         'capital.required' => 'Country Capital is required!',
    //         'currency_name.required' => 'Country Currency Name is required!',
    //         'currency_code.required' => 'Country Currency Code is required!',
    //         'inr_value.required' => 'Country INR value is required!',
    //         'about_country.required' => 'About the Country is required!',
    //         'edu_system.required' => 'Country education system is required!',
    //         'fwas.required' =>   "Country finding work as a Student is required!",
    //         'emp_opr.required' => "Country Employment opportunity is required!",
    //         'pswo.required' => "Countryt Post study work option is required!",
    //         'ptwo.required' => "Country Post time work option is required!",
    //         'visa_fees.required' => "Country visa fees amount is required!",
    //         'popular_states.required' => "Country popular states is required!",
    //         'inv_exp.required' => "Country Individual Expenses is required!",
    //         'spouse_exp.required' => "Country Spouse Expenses is required!",
    //         'child_exp.required' => "Country Child Expenses is required!",
    //         'child_school_fees.required' => "Country Spouse Expenses is required!",
    //         'travel_exp.required' => "Country Travel Expenses is required!",
    //         'tot_exp.required' => "Country Total Expenses is required!",
    //     ];
    // }
}
