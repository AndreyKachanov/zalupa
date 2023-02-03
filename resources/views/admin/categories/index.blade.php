@php
    /** @var \App\Models\Admin\Item\Category $category */
    /** @var \Illuminate\Database\Eloquent\Collection $categories */
@endphp

@extends('layouts.app')

@section('content')
    @include('admin.categories._nav')

    <p><a href="{{ route('admin.categories.create') }}" class="btn btn-success">Добавить категорию</a></p>

    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th>Название категории</th>
            <th>Прямые товары</th>
            <th>Все товары </th>
            <th>Прямые подкатегорий</th>
            <th>Все подкатегорий</th>
        </tr>
        </thead>
        <tbody>

        @foreach ($categories as $category)
            <tr>
                <td><a href="{{ route('admin.categories.show', $category) }}">{{ $category->title }}</a></td>
                <td>{{ $category->items_count }}</td>
                <td>{{ $category->recursive_items_count }}</td>
                <td>{{ $category->children_count }}</td>
                <td>{{ $category->descendants_count }}</td>
            </tr>
        @endforeach

        </tbody>
    </table>

    <div class="pagination justify-content-center">
        {{ $categories->links() }}
    </div>
@endsection
