<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SocieteRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "nom" => 'required|max:255',
//            "logo_file" => 'max:255',
            "telephone" => 'nullable|string|max:255',
            "email" => 'nullable|string|max:255',
            "nif" => 'nullable|string|max:255',
            "stat" => 'nullable|string|max:255',
            "rcs" => 'nullable|string|max:255',
            "cif" => 'nullable|string|max:255',
            "numero_compte" => 'nullable|string|max:255',
            "activite" => 'nullable|string|max:255',
            "adresse" => "nullable|string:255",
            "ville" => "nullable|string:255",
            "code_postal" => "nullable|string:255",
            "pays" => "nullable|string:255",
        ];
    }
}
