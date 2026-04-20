<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreIngredientRequest extends FormRequest
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
            'name' => 'required|string|max:191|unique:ingredients,name',
            'pic' => 'nullable|string|max:191',
            'ingredient_category_id' => 'sometimes|integer|exists:ingredient_categories,id',

            'calories_per_100' => 'nullable|numeric|min:0',
            'protein_per_100'  => 'nullable|numeric|min:0',
            'carbs_per_100'    => 'nullable|numeric|min:0',
            'fat_per_100'      => 'nullable|numeric|min:0',

            'mg_to_ml'   => 'nullable|numeric|min:0',
            'piece_to_g' => 'nullable|numeric|min:0'
        ];
    }
}
