<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AudienceRequest extends FormRequest
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
            "audience" => "required|min:10|string",
            "tribunal_id" => "required|integer",
            "ville_id" => "required|integer",
            "date_conseil" => "required|date",
            "heure_debut" => "required",
            "heure_fin" => "required|after:initial_time",
        ];
    }

    public function messages()
    {

        return [
            'audience.required' => 'Veuillez renseigne le message de votre audience',
            'tribunal_id.required' => 'Renseignez le tribunal dans lequel vous avez une audience.',
            'ville_id.required' => 'Renseignez la ville dans lequel vous avez une audience.',
            'date_conseil.required' => 'Veuillez renseigne la date de votre audience.',
            'heure_debut' => "Veuillez renseigne l'heure de début de votre audience.",
            'heure_fin.required' => "Veuillez renseigne l'heure de fin de votre audience.",
            'heure_fin.after' => "L'heure de fin devra être supérieur à l'heure de début"
        ];

    }

}
