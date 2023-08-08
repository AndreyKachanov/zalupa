@php
    /** @var \App\Models\Admin\Item\Item $item */

@endphp

@extends('layouts.app')

@section('content')
    @include('admin.items._nav')

    <h2 class="text-center mt-3 mb-3">{{ $item->title }}</h2>

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
                <th>Кол-во минимального заказа</th><td> {{ $item->min_order_amount }}</td>
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
                <th>Категория</th><td>{{ $item->category->title }}</td>
            </tr>
        <tbody>
        </tbody>
    </table>
    <div class="col-12 d-flex justify-content-center mt-3">
        <a href="{{ route('admin.items.edit', $item) }}" class="btn btn-sm btn-primary mr-1 pl-4 pr-4">Изменить</a>
        {{ Form::open(['method' => 'delete', 'route' => ['admin.items.destroy', $item], 'class' => 'ml-5']) }}
            {{ Form::submit('Удалить', ['class' => 'btn btn-sm btn-danger pl-4 pr-4'])  }}
        {{ Form::close() }}
    </div>
@endsection
