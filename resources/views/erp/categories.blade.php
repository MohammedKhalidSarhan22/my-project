@extends('layouts.app')

@section('title', 'Restaurant Categories')

@section('content')
    <div class="panel">
        <h2>Categories</h2>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Slug</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach (\App\Models\Category::orderBy('name')->get() as $category)
                    <tr>
                        <td>{{ $category->name }}</td>
                        <td>{{ $category->slug }}</td>
                        <td><span class="tag {{ $category->is_active ? 'status-ready' : 'status-cancelled' }}">{{ $category->is_active ? 'Active' : 'Inactive' }}</span></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
