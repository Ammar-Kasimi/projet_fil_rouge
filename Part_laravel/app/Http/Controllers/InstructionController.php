<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInstructionRequest;
use App\Http\Requests\UpdateInstructionRequest;
use App\Models\Instruction;
use App\Models\Recipe;
use Illuminate\Http\Request;

class InstructionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInstructionRequest $request, Recipe $recipe)
    {
        $validated = $request->validated();
        $instruction = $recipe->instructions()->create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Instruction added successfully',
            'data' => $instruction
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Instruction $instruction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInstructionRequest $request, Instruction $instruction)
    {
        $instruction->update($request->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'Instruction updated successfully',
            'data' => $instruction
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Instruction $instruction)
    {
        $instruction->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Instruction  deleted successfully'
        ]);
    }
}
