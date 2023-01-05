@php
    /** @var \App\Models\Admin\Item\Category $category */
    /** @var \Illuminate\Database\Eloquent\Collection $subCategories */
@endphp

@extends('layouts.app')

@section('content')
    @include('admin.subcategories._nav')

    <p><a href="{{ route('admin.subcategories.create') }}" class="btn btn-success">Добавить подкатегорию</a></p>

    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th>Title</th>
            <th>Родитель</th>
            <th>Count items</th>
        </tr>
        </thead>
        <tbody>

        @foreach ($subCategories as $category)
            <tr>
                <td><a href="{{ route('admin.subcategories.show', $category) }}">{{ $category->title }}</a></td>
                <td>{{ $category->parent->title }}</td>
                <td>{{ $category->items->count() }}</td>
            </tr>
        @endforeach

        </tbody>
    </table>

    <div class="pagination justify-content-center">
        {{ $subCategories->links() }}
    </div>
@endsection
