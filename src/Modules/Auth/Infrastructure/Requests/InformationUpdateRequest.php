<?php

namespace Src\Modules\Auth\Infrastructure\Requests;

use Src\Common\Interfaces\Laravel\FormRequest;

class InformationUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'string|max:60',
            'email' => "email|string|max:255|unique:users,email,{$this->id}",
            'password' => 'min:3|max:16'
        ];
    }

    public function messages()
    {
        return [
            'name.max' => 'El campo Nombre no puede exceder los 60 caracteres',
            'email.email' => 'El Email no es un formato válido',
            'password.min' => 'La contraseña debe contener al menos 3 caracteres',
            'password.max' => 'La contraseña excede el máximo de 16 caracteres',
        ];
    }
}