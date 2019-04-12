<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GeneratedNotaRequest extends FormRequest
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
            'tipo_operacion' => 'required',
            'description' => 'required|min:5',
            'fecha_emision' => 'required',
            'num_serie' => 'required',
            'num_emision' => 'required',
            'cliente' => 'required',
            'details' => 'required'
        ];
    }
}
