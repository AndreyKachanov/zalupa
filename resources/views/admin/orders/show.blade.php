@php
    /** @var \App\Models\Admin\Cart\Order\Contact $order */
    /** @var \App\Models\Admin\Cart\Order\Order $ord */
    $allPrice = 0;
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
        <table class="table table-bordered table-striped">
            <thead>
            <tr>
                <th>Название</th>
                <th>Цена</th>
                <th>Кол-во</th>
                <th>Сумма</th>
            </tr>
            </thead>
            <tbody>
            <?php $allPrice = 0; ?>
            @foreach ($order->orders as $ord)
                <tr>
                    <td>{{ $ord->item->title }}</td>
                    <td>{{ $ord->item->price }}</td>
                    <td>{{ $ord->cnt }}</td>

                    <td>{{ $cnt = $ord->item->price * $ord->cnt }}</td>
                    <?php  $allPrice += $cnt ?>
                </tr>
            @endforeach
            <tr>
                <td>Всего:</td>
                <td style="text-align:right;" colspan="3">
                    {{ $allPrice }}
                </td>
            </tr>
            <tbody>
            </tbody>
        </table>
@endsection
