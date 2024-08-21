<?php

namespace Src\Modules\Auth\Infrastructure\Requests;

use Src\Common\Interfaces\Laravel\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email' => 'required|string|email|max:60',
            'password' => 'required|string|min:6'
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'El campo Email no puede ir vacío',
            'email.email' => 'El Email no es un formato válido',
            'password.min' => 'La contraseña debe contener al menos 6 caracteres',
            'password.required' => 'El campo password no puede ir vacío'
        ];
    }
}