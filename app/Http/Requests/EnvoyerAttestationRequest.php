<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EnvoyerAttestationRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nomFichier' => 'required|max:100',
            'contenu' => 'required|file|mimes:pdf'
        ];
    }

    public function message()
    {
        return [
            'nomFichier.required' => 'Nom du fichier obligatoire',
            'contenu.required' => 'Vous devez ajouter le fichier au format (PDF)',
        ];
    }
}
