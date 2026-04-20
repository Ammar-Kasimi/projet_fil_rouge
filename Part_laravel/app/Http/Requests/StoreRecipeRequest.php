<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRecipeRequest extends FormRequest
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
            'name' => 'required|string|max:191',
            'pic' => 'nullable|string|max:191',
            'difficulty' => 'nullable|in:beginner,medium,advanced,chef',
            'prep_time' => 'required|integer|min:1',
            'ingredients.*.id' => 'required|exists:ingredients,id',
            'ingredients.*.amount' => 'required|numeric|min:0',
            'ingredients.*.unit' => 'required|in:g,kg,l,ml,piece|string',
            'recipe_category_id' => 'sometimes|nullable|integer|exists:recipe_categories,id',
            'ingredients' => 'required|array|min:1'
        ];
    }
}
