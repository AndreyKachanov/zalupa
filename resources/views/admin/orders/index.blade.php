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
            <th>Кол-во</th>
            <th>Сумма заказа</th>
            <th>Имя</th>
            <th>№ телефона</th>
            <th>Email</th>
        </tr>
        </thead>
        <tbody>

        @foreach ($contacts as $contact)
            <tr>
                <td>
                    <a href="{{ route('admin.orders.show', $contact) }}">{{ $contact->created_at->format('d.m.Y H:m') }}</a>
                </td>
                <td>{{ $contact->token->invoice->bill_number ?? '2023-0001' }}</td>
                <td>{{ $contact->orders->sum(fn($item) => $item->cnt) }}</td>
                <td>{{ $contact->orders->sum(fn($item) => $item->item->price * $item->cnt) }}</td>
                <td>{{ $contact->name }}</td>
                <td>{{ $contact->contact }}</td>
                <td>{{ $contact->email }}</td>
            </tr>
        @endforeach

        </tbody>
    </table>

    <div class="pagination justify-content-center">
        {{ $contacts->links() }}
    </div>
@endsection
