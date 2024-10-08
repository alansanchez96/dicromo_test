<?php

namespace Src\Modules\Auth\Infrastructure\Requests;

use Src\Common\Interfaces\Laravel\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:60',
            'email' => 'required|email|string|max:255|unique:users',
            'password' => 'required|min:3|max:16'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'El campo Nombre no puede ir vacío',
            'name.max' => 'El campo Nombre no puede exceder los 60 caracteres',
            'email.required' => 'El campo Email no puede ir vacío',
            'email.email' => 'El Email no es un formato válido',
            'password.min' => 'La contraseña debe contener al menos 3 caracteres',
            'password.max' => 'La contraseña excede el máximo de 16 caracteres',
            'password.required' => 'El campo password no puede ir vacío'
        ];
    }
}