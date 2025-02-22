<?php

namespace App\Http\Requests\Employee;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEmployeeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            
           
                'user_id' => 'sometimes|exists:users,id',  // اجعل `user_id` اختياريًا
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',  // اجعل `image` اختياريًا
            
            'specialization' => 'nullable|string|max:255',

       
    ];
    }
}
