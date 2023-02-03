@php
    /** @var \App\Models\Admin\Item\Category $category */

@endphp

@extends('layouts.app')

@section('content')
    @include('admin.subcategories._nav')

    <div class="d-flex flex-row mb-3">
        <a href="{{ route('admin.subcategories.edit', $category) }}" class="btn btn-primary mr-1">Редактировать</a>
        <form method="POST" action="{{ route('admin.subcategories.destroy', $category) }}" class="mr-1">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger">Удалить</button>
        </form>
    </div>

    <table class="table table-bordered table-striped">
        <tbody>
            <tr>
                <th>Родитель</th><td>{{ $category->parent->title ?? 'нет родителя' }}</td>
            </tr>
            <tr>
                <th>Название</th><td>{{ $category->title }}</td>
            </tr>
        <tbody>
        </tbody>
    </table>
@endsection
