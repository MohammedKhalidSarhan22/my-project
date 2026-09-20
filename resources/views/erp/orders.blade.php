@extends('layouts.app')

@section('title', 'Orders Board')

@section('content')
    <div class="panel">
        <h2>Orders</h2>
        <table>
            <thead>
                <tr>
                    <th>Order</th>
                    <th>Customer</th>
                    <th>Table</th>
                    <th>Status</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach (\App\Models\Order::with('table')->orderByDesc('created_at')->get() as $order)
                    <tr>
                        <td>#{{ $order->id }}</td>
                        <td>{{ $order->customer_name }}</td>
                        <td>{{ $order->table?->name ?? 'N/A' }}</td>
                        <td><span class="tag status-{{ $order->status }}">{{ ucfirst(str_replace('_', ' ', $order->status)) }}</span></td>
                        <td>$ {{ number_format((float) $order->total_amount, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
