<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientEmployeeRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'client_id' => 'required|exists:clients,id',
            'email' => 'email|unique:client_employees,email',
            'position' => 'nullable|string|max:255',
            'project_id' => 'exists:projects,id',
        ];
    }

    // public function messages()
    // {
    //     return [
    //         'name.required' => 'Employee name is required',
    //         'client_id.required' => 'Please select a client company',
    //         'email.required' => 'Email address is required',
    //         'email.unique' => 'This email is already registered',
    //         'mobile_number.required' => 'Mobile number is required',
    //         'mobile_number.regex' => 'Please enter a valid mobile number',
    //         'project_id.required' => 'Please select a project',
    //         'client_receives.*.mimes' => 'Receiving documents must be PDF or Word files',
    //         'client_gallary.*.image' => 'Gallery uploads must be images'
    //     ];
    // }
}
