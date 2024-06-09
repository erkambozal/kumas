<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContentFormRequest extends FormRequest
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

            'name'=>'required|string|min:3',
            'email'=>'required|email',
            'phone'=>'required|phone',
            'subject'=>'required',
            'message'=>'required',


        ];
    }

    public function messages(): array
    {
        return [
            'name.required'=>'İsim zorunludur.',
            'name.string'=>'İsim karakterlerden oluşmalı.',
            'name.min'=>'İsim minimum 3 karakter olmalı.',
            'email.required'=>'Eposta zorunlu.',
            'email.email'=>'Geçersiz email.',
            'subject.required'=>'Konu zorunlu.',
            'message.required'=>'Mesaj zorunlu.',

        ];
    }
}
