@extends('layouts.app')

@section('title', 'Restaurant ERP Dashboard')

@section('content')
    <div class="actions" style="margin-bottom: 1.5rem;">
        <a href="{{ route('orders') }}" class="pill">Open Order Board</a>
    </div>

    <div class="card-grid">
        <div class="card">
            <h3>Revenue Today</h3>
            <p class="metric">$ {{ number_format((float) $stats['revenue_today'], 2) }}</p>
        </div>
        <div class="card">
            <h3>Pending Orders</h3>
            <p class="metric">{{ $stats['pending_orders'] }}</p>
        </div>
        <div class="card">
            <h3>Occupied Tables</h3>
            <p class="metric">{{ $stats['occupied_tables'] }}</p>
        </div>
        <div class="card">
            <h3>Available Tables</h3>
            <p class="metric">{{ $stats['available_tables'] }}</p>
        </div>
    </div>

    <div class="grid-2">
        <div class="panel">
            <h3>Recent Orders</h3>
            <table>
                <thead>
                    <tr>
                        <th>Order</th>
                        <th>Table</th>
                        <th>Status</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($recentOrders as $order)
                        <tr>
                            <td>#{{ $order->id }}</td>
                            <td>{{ $order->table?->name ?? 'N/A' }}</td>
                            <td><span class="tag status-{{ $order->status }}">{{ ucfirst(str_replace('_', ' ', $order->status)) }}</span></td>
                            <td>$ {{ number_format((float) $order->total_amount, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="panel">
            <h3>Top Selling Items</h3>
            <ul class="list">
                @foreach ($topSellingItems as $item)
                    <li>
                        <strong>{{ $item->menuItem?->name ?? 'Item' }}</strong><br>
                        <span class="muted">{{ $item->total_quantity }} sold</span>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endsection
