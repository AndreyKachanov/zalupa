@php
    /** @var \App\Models\Admin\Cart\Order\Contact $contact */
    /** @var \App\Models\Admin\Cart\Order\Order $order */
    /** @var \Illuminate\Pagination\LengthAwarePaginator $contacts */
@endphp

@extends('layouts.app')

@section('content')
    @include('admin.orders._nav')

{{--    <p><a href="{{ route('admin.categories.create') }}" class="btn btn-success">Add Category</a></p>--}}

    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th>Дата заказа</th>
            <th>№ заказа</th>
            <th>Имя</th>
            <th>Контакты</th>
            <th>Заказ</th>
        </tr>
        </thead>
        <tbody>

        @foreach ($contacts as $contact)
            <tr>
                <td>{{ $contact->created_at->format('d.m.Y H:m') }}</td>
                <td>{{ $contact->token->invoice->bill_number ?? '2023-0001' }}</td>

                <td>{{ $contact->name }}</td>
                <td>{{ $contact->contact }}</td>
                <td>
                    <table class="table table-bordered">
{{--                        <th>Название</th>--}}
{{--                        <th>Кол-во</th>--}}
                        @foreach ( $contact->orders as $order)
                            <tr>
                                <td>{{ $order->item->title }}</td>
                                <td>{{ $order->cnt }}</td>
                            </tr>
                        @endforeach
                    </table>
                </td>
{{--                <td><a href="{{ route('admin.categories.show', $category) }}">{{ $category->title }}</a></td>--}}
{{--                <td>{{ $category->items->count() }}</td>--}}
            </tr>
        @endforeach

        </tbody>
    </table>

    <div class="pagination justify-content-center">
        {{ $contacts->links() }}
    </div>
@endsection
