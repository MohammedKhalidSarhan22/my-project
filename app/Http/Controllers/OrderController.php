<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => Order::with(['table', 'items.menuItem'])->orderByDesc('created_at')->get(),
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'table_id' => ['required', 'exists:tables,id'],
            'customer_name' => ['nullable', 'string', 'max:255'],
            'status' => ['nullable', 'in:pending,in_progress,ready,served,paid,cancelled'],
            'notes' => ['nullable', 'string'],
            'items' => ['required', 'array'],
            'items.*.menu_item_id' => ['required', 'exists:menu_items,id'],
            'items.*.quantity' => ['required', 'integer', 'min:1'],
            'items.*.notes' => ['nullable', 'string'],
        ]);

        $order = DB::transaction(function () use ($validated) {
            $order = Order::create([
                'table_id' => $validated['table_id'],
                'customer_name' => $validated['customer_name'] ?? 'Walk-in Guest',
                'status' => $validated['status'] ?? 'pending',
                'notes' => $validated['notes'] ?? null,
                'total_amount' => 0,
                'paid_amount' => 0,
            ]);

            $total = 0;

            foreach ($validated['items'] as $item) {
                $menuItem = MenuItem::findOrFail($item['menu_item_id']);
                $unitPrice = (float) $menuItem->price;
                $quantity = (int) $item['quantity'];

                $orderItem = OrderItem::create([
                    'order_id' => $order->id,
                    'menu_item_id' => $menuItem->id,
                    'quantity' => $quantity,
                    'unit_price' => $unitPrice,
                    'notes' => $item['notes'] ?? null,
                ]);

                $total += $quantity * $unitPrice;
            }

            $order->update([
                'total_amount' => $total,
                'paid_amount' => $total,
            ]);

            return $order->fresh()->load(['table', 'items.menuItem']);
        });

        return response()->json([
            'success' => true,
            'message' => 'Order created successfully.',
            'data' => $order,
        ], 201);
    }

    public function show(Order $order): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $order->load(['table', 'items.menuItem']),
        ]);
    }

    public function update(Request $request, Order $order): JsonResponse
    {
        $validated = $request->validate([
            'status' => ['sometimes', 'required', 'in:pending,in_progress,ready,served,paid,cancelled'],
            'paid_amount' => ['nullable', 'numeric', 'min:0'],
            'notes' => ['nullable', 'string'],
        ]);

        $order->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Order updated successfully.',
            'data' => $order->fresh()->load(['table', 'items.menuItem']),
        ]);
    }

    public function destroy(Order $order): JsonResponse
    {
        $order->delete();

        return response()->json([
            'success' => true,
            'message' => 'Order deleted successfully.',
        ]);
    }
}
