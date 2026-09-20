@extends('layouts.app')

@section('title', 'Restaurant Tables')

@section('content')
    <div class="panel">
        <h2>Tables</h2>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Capacity</th>
                    <th>Location</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach (\App\Models\Table::orderBy('name')->get() as $table)
                    <tr>
                        <td>{{ $table->name }}</td>
                        <td>{{ $table->capacity }}</td>
                        <td>{{ $table->location ?? 'Main Floor' }}</td>
                        <td><span class="tag status-{{ $table->status }}">{{ ucfirst($table->status) }}</span></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
