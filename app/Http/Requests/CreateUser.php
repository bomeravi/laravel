<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUser extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'string|required',
            'email' => 'email|required',
            'password' => 'string|required|min:8|max:24',
            'age' => 'integer|required|between:10,90',
            'gender' => 'required|string|in:male,female',
            'lat' =>'numeric|required|between:-90.0,90.0',
            'lng' =>'numeric|required|between:-90.0,90.0'


            //
        ];
    }


}
