<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MenuItemController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => MenuItem::with('category')->orderBy('name')->get(),
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'cost_price' => ['nullable', 'numeric', 'min:0'],
            'stock_quantity' => ['nullable', 'integer', 'min:0'],
            'is_available' => ['boolean'],
            'image_url' => ['nullable', 'string', 'max:255'],
        ]);

        $validated['slug'] = strtolower(str_replace(' ', '-', $validated['name']));

        $menuItem = MenuItem::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Menu item created successfully.',
            'data' => $menuItem->load('category'),
        ], 201);
    }

    public function show(MenuItem $menuItem): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $menuItem->load('category'),
        ]);
    }

    public function update(Request $request, MenuItem $menuItem): JsonResponse
    {
        $validated = $request->validate([
            'category_id' => ['sometimes', 'required', 'exists:categories,id'],
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['sometimes', 'required', 'numeric', 'min:0'],
            'cost_price' => ['nullable', 'numeric', 'min:0'],
            'stock_quantity' => ['nullable', 'integer', 'min:0'],
            'is_available' => ['sometimes', 'boolean'],
            'image_url' => ['nullable', 'string', 'max:255'],
        ]);

        if (isset($validated['name'])) {
            $validated['slug'] = strtolower(str_replace(' ', '-', $validated['name']));
        }

        $menuItem->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Menu item updated successfully.',
            'data' => $menuItem->fresh()->load('category'),
        ]);
    }

    public function destroy(MenuItem $menuItem): JsonResponse
    {
        $menuItem->delete();

        return response()->json([
            'success' => true,
            'message' => 'Menu item deleted successfully.',
        ]);
    }
}
