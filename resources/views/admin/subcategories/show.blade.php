@php
    /** @var \App\Models\Admin\Item\Category $category */

@endphp

@extends('layouts.app')

@section('content')
    @include('admin.subcategories._nav')

    <div class="d-flex flex-row mb-3">
        <a href="{{ route('admin.subcategories.edit', $category) }}" class="btn btn-primary mr-1">Edit</a>
        <form method="POST" action="{{ route('admin.subcategories.destroy', $category) }}" class="mr-1">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger">Delete</button>
        </form>
    </div>

    <table class="table table-bordered table-striped">
        <tbody>
            <tr>
                <th>ID</th><td>{{ $category->id }}</td>
            </tr>
            <tr>
                <th>Title</th><td>{{ $category->title }}</td>
            </tr>
        <tbody>
        </tbody>
    </table>
@endsection
