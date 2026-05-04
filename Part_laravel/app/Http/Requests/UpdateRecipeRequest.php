<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRecipeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->recipe->user_id == $this->user()->id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'sometimes|string|min:1|max:191',
            'desc' => 'sometimes|nullable|string|min:4',
            'pic' => 'sometimes|nullable|string',
            'difficulty' => 'sometimes|in:beginner,medium,advanced,chef',
            'prep_time' => 'sometimes|integer|min:1',
            'recipe_category_id' => 'sometimes|nullable|integer|exists:recipe_categories,id',
            'ingredients' => 'sometimes|array|min:1',
            'ingredients.*.id' => 'required_with:ingredients|exists:ingredients,id',
            'ingredients.*.amount' => 'required_with:ingredients|numeric|min:0',
            'ingredients.*.unit' => 'required_with:ingredients|in:g,kg,l,ml,piece',
            'instructions' => 'sometimes|nullable|array',
            'instructions.*.desc' => 'required_with:instructions|string'
        ];
    }
}
