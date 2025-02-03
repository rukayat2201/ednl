<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'bvn' => 'required|string',
            'telephone' => 'required|string|min:11,max:11',
            'dob' => 'required|string',
            'residential_address' => 'required|string',
            'state' => 'required|string',
            'bank_code' => 'required|string',
            'accountnumber' => 'required|string|min:10,max:10',
            'company_id' => 'required|string',
            'email' => 'required|email|unique:customers',
            'city' => 'required|string',
            'country' =>  'required|string',
            'id_card' => 'nullable|string',
            'voters_card' => 'nullable|string',
            'drivers_license' => 'nullable|string'
        ];
    }
}
