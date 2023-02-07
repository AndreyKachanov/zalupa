@php
    /** @var \App\Models\Admin\Item\Item $item */

@endphp

@extends('layouts.app')

@section('content')
    @include('admin.items._nav')

    <div class="d-flex flex-row mb-1">
        <a href="{{ route('admin.items.edit', $item) }}" class="btn btn-sm btn-primary mr-1">Изменить</a>
        <form method="POST" action="{{ route('admin.items.destroy', $item) }}" class="mr-1">
            @csrf
            @method('DELETE')
            <button class="btn btn-sm btn-danger">Удалить</button>
        </form>
    </div>
    <div class="row">
        <div style="margin: 10px auto;">
            <img src="{{ Storage::disk('uploads')->url($item->img) }}" alt="{{ $item->title }}">
        </div>
    </div>
    <table class="table table-bordered table-striped">
        <tbody>
            <tr>
                <th>Название</th><td>{{ $item->title }}</td>
            </tr>
            <tr>
                <th>Примечание</th><td>{{ $item->note }}</td>
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
                <th>Новый</th><td>{!! $item->is_new ? '&#x2705;' : '&nbsp;' !!}</td>

            </tr>
            <tr>
                <th>Хит</th><td>{!! $item->is_hit ? '&#x2705;' : '&nbsp;' !!}</td>
            </tr>
            <tr>
                <th>Бестселлер</th><td>{!! $item->is_bestseller ? '&#x2705;' : '&nbsp;' !!}</td>
            </tr>
            <tr>
                <th>Категория</th><td>{{ $item->rCategory->title ?? 'Без категории' }}</td>
            </tr>
        <tbody>
        </tbody>
    </table>
@endsection
