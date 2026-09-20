<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Table;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DashboardController extends Controller
{
    protected function hasRestaurantData(): bool
    {
        return Schema::hasTable('orders') && Schema::hasTable('tables') && Schema::hasTable('order_items') && Schema::hasTable('menu_items');
    }

    public function apiIndex(): \Illuminate\Http\JsonResponse
    {
        if (! $this->hasRestaurantData()) {
            return response()->json([
                'success' => true,
                'data' => [
                    'revenue_today' => 0,
                    'pending_orders' => 0,
                    'occupied_tables' => 0,
                    'available_tables' => 0,
                    'recent_orders' => [],
                    'top_selling_items' => [],
                ],
            ]);
        }

        $todayRevenue = Order::whereDate('created_at', today())->sum('total_amount');
        $pendingOrders = Order::whereIn('status', ['pending', 'in_progress', 'ready'])->count();
        $occupiedTables = Table::where('status', 'occupied')->count();
        $availableTables = Table::where('status', 'available')->count();

        $recentOrders = Order::with(['table', 'items.menuItem'])
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        $topSellingItems = OrderItem::select('menu_item_id', DB::raw('SUM(quantity) as total_quantity'), DB::raw('SUM(quantity * unit_price) as revenue'))
            ->with('menuItem')
            ->groupBy('menu_item_id')
            ->orderByDesc('total_quantity')
            ->limit(5)
            ->get();

        return response()->json([
            'success' => true,
            'data' => [
                'revenue_today' => round((float) $todayRevenue, 2),
                'pending_orders' => $pendingOrders,
                'occupied_tables' => $occupiedTables,
                'available_tables' => $availableTables,
                'recent_orders' => $recentOrders,
                'top_selling_items' => $topSellingItems,
            ],
        ]);
    }

    public function index(): \Illuminate\View\View
    {
        if (! $this->hasRestaurantData()) {
            $stats = [
                'revenue_today' => 0,
                'pending_orders' => 0,
                'occupied_tables' => 0,
                'available_tables' => 0,
            ];

            return view('erp.dashboard', [
                'stats' => $stats,
                'recentOrders' => [],
                'topSellingItems' => [],
            ]);
        }

        $stats = [
            'revenue_today' => Order::whereDate('created_at', today())->sum('total_amount'),
            'pending_orders' => Order::whereIn('status', ['pending', 'in_progress', 'ready'])->count(),
            'occupied_tables' => Table::where('status', 'occupied')->count(),
            'available_tables' => Table::where('status', 'available')->count(),
        ];

        $recentOrders = Order::with(['table', 'items.menuItem'])
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        $topSellingItems = OrderItem::select('menu_item_id', DB::raw('SUM(quantity) as total_quantity'), DB::raw('SUM(quantity * unit_price) as revenue'))
            ->with('menuItem')
            ->groupBy('menu_item_id')
            ->orderByDesc('total_quantity')
            ->limit(5)
            ->get();

        return view('erp.dashboard', compact('stats', 'recentOrders', 'topSellingItems'));
    }
}
