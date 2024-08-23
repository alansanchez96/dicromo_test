<?php

namespace Src\Modules\Tasks\Infrastructure\Requests;

use Src\Common\Interfaces\Laravel\FormRequest;

class TaskUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'string|max:60',
            'description' => 'string|max:255',
            'status' => 'boolean',
        ];
    }

    public function messages()
    {
        return [
            'name.max' => 'El campo Nombre no puede exceder los 60 caracteres',
        ];
    }
}