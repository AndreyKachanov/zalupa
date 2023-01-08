@php
    /** @var \App\Models\Admin\Item\Item $item */

@endphp

@extends('layouts.app')

@section('content')
    @include('admin.items._nav')

    <div class="d-flex flex-row mb-3">
        <a href="{{ route('admin.items.edit', $item) }}" class="btn btn-primary mr-1">Edit</a>
        <form method="POST" action="{{ route('admin.items.destroy', $item) }}" class="mr-1">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger">Delete</button>
        </form>
    </div>
    <div class="row">
        <div style="margin: 20px auto;">
            <img src="{{ Storage::disk('uploads')->url($item->img) }}" alt="" width="300" height="350">
        </div>
    </div>
    <table class="table table-bordered table-striped">
        <tbody>
            <tr>
                <th>Название</th><td>{{ $item->title }}</td>
            </tr>
            <tr>
                <th>Артикул</th><td>{{ $item->article_number }}</td>
            </tr>
            <tr>
                <th>Цена оригинал</th><td>{{ $item->getRawOriginal('price') }} &#8381</td>
            </tr>
            <tr>
                <th>Цена c {{ \App\Models\Admin\Setting::firstWhere('prop_key', 'price_increase')->prop_value }} % </th><td>{{ $item->price }} &#8381</td>
            </tr>
            <tr>
                <th>Новый</th><td>{{ $item->is_new }}</td>
            </tr>
            <tr>
                <th>Хит</th><td>{{ $item->is_hit }}</td>
            </tr>
            <tr>
                <th>Бестселлер</th><td>{{ $item->is_bestseller }}</td>
            </tr>
            <tr>
                <th>Категория</th><td>{{ $item->rCategory->title ?? 'Без категории' }}</td>
            </tr>
        <tbody>
        </tbody>
    </table>
@endsection
