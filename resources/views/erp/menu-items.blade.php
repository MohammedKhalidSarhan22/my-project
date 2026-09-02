@extends('layouts.app')

@section('title', 'Menu Items')

@section('content')
    <div class="panel">
        <h2>Menu Items</h2>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Available</th>
                    <th>Stock</th>
                </tr>
            </thead>
            <tbody>
                @foreach (\App\Models\MenuItem::with('category')->orderBy('name')->get() as $item)
                    <tr>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->category?->name ?? 'General' }}</td>
                        <td>$ {{ number_format((float) $item->price, 2) }}</td>
                        <td><span class="tag {{ $item->is_available ? 'status-ready' : 'status-cancelled' }}">{{ $item->is_available ? 'Yes' : 'No' }}</span></td>
                        <td>{{ $item->stock_quantity }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
