<?php

namespace App\Http\Controllers;

use App\Models\Table;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TableController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => Table::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'capacity' => ['required', 'integer', 'min:1'],
            'status' => ['required', 'in:available,reserved,occupied'],
            'location' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string'],
        ]);

        $table = Table::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Table created successfully.',
            'data' => $table,
        ], 201);
    }

    public function show(Table $table): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $table,
        ]);
    }

    public function update(Request $request, Table $table): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'capacity' => ['sometimes', 'required', 'integer', 'min:1'],
            'status' => ['sometimes', 'required', 'in:available,reserved,occupied'],
            'location' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string'],
        ]);

        $table->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Table updated successfully.',
            'data' => $table->fresh(),
        ]);
    }

    public function destroy(Table $table): JsonResponse
    {
        $table->delete();

        return response()->json([
            'success' => true,
            'message' => 'Table deleted successfully.',
        ]);
    }
}
