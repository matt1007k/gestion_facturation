<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GenerarRequest extends FormRequest
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
        return [
            'tipo' => 'required',
            'tipo_doc' => 'required',
            'fecha_emision' => 'required',
            'num_serie' => 'required',
            'num_emision' => 'required|numeric',
            'cliente.nombre' => 'required',
            'details' => 'required',
            'tipo_operacion' => 'required',
        ];
    }
}
