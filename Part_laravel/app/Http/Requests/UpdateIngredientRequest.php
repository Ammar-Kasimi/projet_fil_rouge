<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateIngredientRequest extends FormRequest
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
            'name' => 'sometimes|string|min:1|max:35|unique:ingredients,name,' . $this->ingredient->id,
            'pic' => 'sometimes|string|min:1',
            'ingredient_category_id' => 'sometimes|integer|exists:ingredient_categories,id',

            'calories_per_100' => 'sometimes|numeric|min:0',
            'protein_per_100'  => 'sometimes|numeric|min:0',
            'carbs_per_100'    => 'sometimes|numeric|min:0',
            'fat_per_100'      => 'sometimes|numeric|min:0',

            'ml_to_g'   => 'nullable|numeric|min:0',
            'piece_to_g' => 'nullable|numeric|min:0'
        ];
    }
}
