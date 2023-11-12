<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UsuariosRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {

        $rules = [
            'name' => 'string|required',
            'password' => 'string|required',
        ];

        if (request()->id) {
            $rules['email']  = 'email|max:200';
        } else {
            $rules['email'] = 'email|required|unique:usuario,email|max:200';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'integer' => 'O campo deve ser do tipo INT',
            'required' => 'O campo deve ser obrigatorio',
            'nome.max' => 'O campo nome deve possuir ate 200 caracteres',
            'nome.min' => 'O campo nome deve possuir no minimo 2 caracteres',
            'date' => 'O campo deve ser uma data valida',
            'email' => 'Favor forneca um email valido',
        ];
    }
}
