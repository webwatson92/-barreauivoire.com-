<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ModificationCompteUserRequest extends FormRequest
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
            // 'matricule' => ['required', 'unique:users'],
            // 'name' => ['required', 'string', 'max:10'],
            'prenom' => ['required', 'string', 'max:255'],
            'date_naissance' => ['required'],
            'sexe' => ['required', 'string', 'max:1'],
            'lieu_structure' => ['required', 'string'],
            'telephone' => ['required', 'string'],
            'role' => ['required', 'string']
        ];
    }
}
