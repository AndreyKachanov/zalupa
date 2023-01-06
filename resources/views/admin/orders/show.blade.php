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
        <table class="table table-bordered table-striped">
            <thead>
            <tr>
                <th>Название</th>
                <th>Кол-во</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($order->orders as $ord)
                <tr>
                    <td>{{ $ord->item->title }}</td>
                    <td>{{ $ord->cnt }}</td>
                </tr>
            @endforeach
            <tbody>
            </tbody>
        </table>
@endsection
