@php
    /** @var \App\Models\Admin\Item\Category $category */
    /** @var \Illuminate\Pagination\LengthAwarePaginator $categories */
@endphp

@extends('layouts.app')

@section('content')
    @include('admin.categories._nav')

    <p><a href="{{ route('admin.categories.create') }}" class="btn btn-success">Добавить</a></p>

    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th>№ п/п</th>
            <th>Название категории</th>
            <th>Прямые товары</th>
            <th>Все товары</th>
            <th>Прямые подкатегории</th>
            <th>Все подкатегории</th>
        </tr>
        </thead>
        <tbody>
            @foreach ($categories as $category)
                <tr>
                    <td>{{ $category->sorting }}</td>
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
@section('scripts')

    <script>
        $(document).ready(function() {
            // $('tbody').on('click', function () {
            //     console.log(1);
            // });
            $('tbody').sortable();
            // $('tbody').disableSelection();
        });
    </script>
@endsection
