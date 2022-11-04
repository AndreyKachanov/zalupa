@php
    /** @var \App\Models\Admin\Item\Category $category */
    /** @var \Illuminate\Database\Eloquent\Collection $categories */
@endphp

@extends('layouts.app')

@section('content')
    @include('admin.categories._nav')

    <p><a href="{{ route('admin.categories.create') }}" class="btn btn-success">Add Category</a></p>

    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Count items</th>
        </tr>
        </thead>
        <tbody>

        @foreach ($categories as $category)
            <tr>
                <td>{{ $category->id }}</td>
                <td><a href="{{ route('admin.categories.show', $category) }}">{{ $category->title }}</a></td>
                <td>{{ $category->rItems->count() }}</td>
            </tr>
        @endforeach

        </tbody>
    </table>

    <div class="pagination justify-content-center">
        {{ $categories->links() }}
    </div>
@endsection
