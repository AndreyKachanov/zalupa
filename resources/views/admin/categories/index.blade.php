@php
    /** @var \App\Models\Admin\Item\Category $category */
    /** @var \Illuminate\Pagination\LengthAwarePaginator $categories */
@endphp

@extends('layouts.app')
{{--@section('custom_css')--}}
{{--    <style>--}}
{{--        .test th, .test td {--}}
{{--            vertical-align: middle;--}}
{{--        }--}}
{{--    </style>--}}
{{--@endsection--}}

@section('content')
    @include('admin.categories._nav')

    <p><a href="{{ route('admin.categories.create') }}" class="btn btn-sm btn-success">Добавить</a></p>

{{--    <table class="table table-hover table-responsive table-responsive-sm">--}}
{{--        <thead>--}}
{{--        <tr>--}}
{{--            <th>№ п/п</th>--}}
{{--            <th>Название категории</th>--}}
{{--            <th>Подкатегории</th>--}}
{{--            <th>Все подкатегории</th>--}}
{{--            <th>Товары</th>--}}
{{--            <th>Товары из подкатегорий</th>--}}
{{--        </tr>--}}
{{--        </thead>--}}
{{--        <tbody>--}}
{{--            @foreach ($categories as $category)--}}
{{--                <tr>--}}
{{--                    <td>{{ $category->sorting }}</td>--}}
{{--                    <td><a href="{{ route('admin.categories.show', $category) }}">{{ $category->title }}</a></td>--}}
{{--                    <td>{{ $category->children_count }}</td>--}}
{{--                    <td>{{ $category->descendants_count }}</td>--}}
{{--                    <td>{{ $category->items_count }}</td>--}}
{{--                    <td>{{ $category->recursive_items_count }}</td>--}}
{{--                </tr>--}}
{{--            @endforeach--}}
{{--        </tbody>--}}
{{--    </table>--}}

    <table class="categories-table table table-sm">
        <thead>
            <tr>
                <th scope="col">№</th>
                <th scope="col">Имя</th>
                <th scope="col">Дети</th>
{{--                <th scope="col">Все подкатегории</th>--}}
                <th scope="col">Товары</th>
                <th scope="col">Товары с подкатегорий</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categories as $category)
                <tr>
                    <th scope="row">{{ $category->sorting }}</th>
                    <td><a href="{{ route('admin.categories.show', $category) }}">{{ $category->title }}</a></td>
                    <td>{{ $category->children_count }}</td>
{{--                    <td>{{ $category->descendants_count }}</td>--}}
                    <td>{{ $category->items_count }}</td>
{{--                    <td>{{ $category->recursive_items_count }}</td>--}}
{{--                    <td>{{ dump($category->children->values()->get(0)->id) }}</td>--}}
                    <td>{{ $category->children->sum(fn($category) => $category->items_count) }}</td>
                </tr>
            @endforeach
{{--        <tr>--}}
{{--            <th scope="row">1</th>--}}
{{--            <td>Bootstrap 4 CDN and Starter Template</td>--}}
{{--            <td>Cristina</td>--}}
{{--            <td>913</td>--}}
{{--            <td>2.846</td>--}}
{{--        </tr>--}}
{{--        <tr>--}}
{{--            <th scope="row">2</th>--}}
{{--            <td>Bootstrap Grid 4 Tutorial and Examples</td>--}}
{{--            <td>Cristina</td>--}}
{{--            <td>1.434</td>--}}
{{--            <td>3.417</td>--}}
{{--        </tr>--}}

{{--        <tr>--}}
{{--            <th scope="row">3</th>--}}
{{--            <td>Bootstrap Flexbox Tutorial and Examples</td>--}}
{{--            <td>Cristina</td>--}}
{{--            <td>1.877</td>--}}
{{--            <td>1.234</td>--}}
{{--        </tr>--}}
        </tbody>
    </table>

    <div class="pagination justify-content-center">
        {{ $categories->links() }}
    </div>
@endsection
{{--@section('scripts')--}}
{{--    <script>--}}
{{--        $(document).ready(function() {--}}
{{--            // $('tbody').sortable();--}}
{{--            // $('tbody').disableSelection();--}}
{{--        });--}}
{{--    </script>--}}
{{--@endsection--}}
