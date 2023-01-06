@php
    /** @var \App\Models\Admin\Cart\Order\Contact $order */
    /** @var \App\Models\Admin\Cart\Order\Order $ord */
@endphp

@extends('layouts.app')

@section('content')
    @include('admin.orders._nav')
        <div class="d-flex flex-row mb-3">
            <form method="POST" action="{{ route('admin.orders.destroy', $order) }}" class="mr-1">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger">Delete</button>
            </form>
        </div>
        <table class="table table-bordered table-striped table-image">
            <thead>
            <tr>
                <th style="text-align: right">Продукт</th>
                <th>Артикул</th>
                <th>Цена</th>
                <th>Кол-во</th>
                <th>Сумма</th>
            </tr>
            </thead>
            <tbody>
            <?php $allPrice = 0; ?>
            @foreach ($order->orders as $ord)
                <tr>
                    <td>
                        <img
                            src="{{ Storage::disk('uploads')->url($ord->item->img) }}"
                            class="img-fluid img-thumbnail"
                            style="max-width: 15%; margin-right: 15px;"
                            alt="{{ $ord->item->title }}"
                        >
                        {{ $ord->item->title }}
                    </td>
                    <td>{{ $ord->item->article_number }}</td>
                    <td>{{ $ord->item->price }}</td>
                    <td>{{ $ord->cnt }}</td>

                    <td>{{ $ord->item->price * $ord->cnt }}</td>
                </tr>
            @endforeach
            <tr>
                <td>Всего:</td>
                <td style="text-align:right;" colspan="5">
                    {{ $order->orders->sum(fn($item) => $item->item->price * $item->cnt) }}
                </td>
            </tr>
            <tbody>
            </tbody>
        </table>
@endsection
