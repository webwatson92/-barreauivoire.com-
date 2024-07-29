<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RechercheAudienceRequest extends FormRequest
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
            "ville_id" => 'required|integer',
            "date_conseil" => 'required|date',
            "tribunal_id" => 'required|integer',
            "plage_horaire" => 'required',
        ];
    }

    public function messages()
    {

        return [
            'ville_id.required' => 'Veuillez selectionner une ville',
            'tribunal_id.required' => 'Veuillez selectionner un tribunal',
            'date_conseil.required' => 'Veuillez choisir la date',
            'plage_horaire.required' => "Veuillez selectionner une plage d'horaire", // Correction ici
            'date_conseil.date_format' => 'Le format de la date doit être JJ/MM/AAAA',
            'plage_horaire.date_format' => 'Le format de la plage horaire doit être HH:MM',
        ];

    }

}
