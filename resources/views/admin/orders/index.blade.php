@php
    /** @var \App\Models\Admin\Cart\Order\Contact $contact */
    /** @var \App\Models\Admin\Cart\Order\Order $order */
    /** @var \Illuminate\Pagination\LengthAwarePaginator $contacts */
@endphp

@extends('layouts.app')
@section('custom_css')
    <style>
        table.bottom {
            font-size: 12px;
            border: 1px solid #ccc;
            border-collapse: collapse;
            margin: 0;
            padding: 0;
            width: 100%;
            table-layout: fixed;
        }


        caption {
            font-size: 1.5em;
            margin: .5em 0 .75em;
        }

        table.bottom tr {
            background-color: #f8f8f8;
            border: 1px solid #ddd;
            padding: .35em;
        }

        table.bottom th,
        table.bottom td {
            padding: .625em;
            text-align: center;
        }

        table.bottom th {
            font-size: .85em;
            letter-spacing: .1em;
            text-transform: uppercase;
        }

        .img-thumbnail {
            padding: 0.25rem;
            background-color: #fff;
            border: 1px solid #dee2e6;
            border-radius: 0.25rem;
            max-width: 100%;
            height: auto;
        }

        /*.img-fluid {*/
        /*    max-width: 100%;*/
        /*    height: auto;*/
        /*}*/
        img {
            vertical-align: middle;
            border-style: none;
            height: auto;
        }

        table.bottom tr td:nth-child(2) {
            text-align: left;
        }

        tr.all_sum td:first-child {
            padding-left: 23px;
        }
        tr.all_sum td:last-child {
            padding-right: 34px;
        }

        @media screen and (max-width: 600px) {

            tr.all_sum td:first-child {
                padding-left: 0;
            }
            tr.all_sum td:last-child {
                padding-right: 0;
            }

            table.bottom tr td:first-child {
                display: flex !important;
                align-items: center !important;
                justify-content: space-between !important;
            }

            img {
                max-width: 35% !important;
                vertical-align: middle !important;
                border-style: none !important;
            }


            table.bottom {
                border: 0;
            }

            table.bottom tr td:nth-child(2) {
                text-align: right;
            }

            caption {
                font-size: 1.3em;
            }

            table.bottom thead {
                border: none;
                clip: rect(0 0 0 0);
                height: 1px;
                margin: -1px;
                overflow: hidden;
                padding: 0;
                position: absolute;
                width: 1px;
            }

            table.bottom tr {
                border-bottom: 3px solid #ddd;
                display: block;
                margin-bottom: .625em;
            }

            table.bottom td {
                border-bottom: 1px solid #ddd;
                display: block;
                font-size: 1em;
                text-align: right;
            }

            table.bottom td::before {
                /*
                * aria-label has no advantage, it won't be read inside a table
                content: attr(aria-label);
                */
                content: attr(data-label);
                float: left;
                font-weight: bold;
                text-transform: uppercase;
            }

            table.bottom td:last-child {
                border-bottom: 0;
            }
        }
    </style>
@endsection

@section('content')
    @include('admin.orders._nav')

{{--    <table class="table table-bordered table-striped">--}}
{{--        <thead>--}}
{{--        <tr>--}}
{{--            <th>№ заказа</th>--}}
{{--            <th>Дата заказа</th>--}}
{{--            <th>Кол-во</th>--}}
{{--            <th>Сумма заказа</th>--}}
{{--            <th>Имя</th>--}}
{{--            <th>№ телефона</th>--}}
{{--            <th>Ip адрес</th>--}}
{{--        </tr>--}}
{{--        </thead>--}}
{{--        <tbody>--}}

{{--        @foreach ($contacts as $contact)--}}
{{--            <tr>--}}
{{--                <td>--}}
{{--                    <a href="{{ route('admin.orders.show', $contact) }}">--}}
{{--                        {{ $contact->token->invoice->bill_number }}--}}
{{--                    </a>--}}
{{--                </td>--}}
{{--                <td>--}}
{{--                    {{ $contact->created_at->format('d.m.Y H:m') }}--}}
{{--                </td>--}}
{{--                <td>{{ $contact->orders->sum(fn($item) => $item->cnt) }}</td>--}}
{{--                <td>{{ $contact->orders->sum(fn($item) => $item->item->price * $item->cnt) }} ₽</td>--}}
{{--                <td>{{ $contact->orders->sum(fn($item) => $item->item->price * $item->cnt) }} ₽</td>--}}
{{--                <td>{{ $contact->name }}</td>--}}
{{--                <td>{{ $contact->phone }}</td>--}}
{{--                <td>{{ $contact->token->ip }}</td>--}}
{{--            </tr>--}}
{{--        @endforeach--}}

{{--        </tbody>--}}
{{--    </table>--}}

    <table class="bottom">
        <caption style="caption-side: top; text-align: center; color: #000">Список заказов</caption>
        <thead>
        <tr>
            <th scope="col">№ заказа</th>
            <th scope="col">Дата заказа</th>
            <th scope="col">Кол-во</th>
            <th scope="col">Сумма заказа</th>
            <th scope="col">Имя</th>
            <th scope="col">№ телефона</th>
            <th scope="col">Ip адрес</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($contacts as $contact)
            <tr>
                <td data-label="№ заказа">
                    <a href="{{ route('admin.orders.show', $contact) }}">
                        {{ $contact->token->invoice->bill_number }}
                    </a>
                </td>
                <td data-label="Дата заказа">
                    {{ $contact->created_at->format('d.m.Y H:m') }}
                </td>
                <td data-label="Кол-во">{{ $contact->orders->sum(fn($item) => $item->cnt) }}</td>
                <td data-label="Сумма заказа">{{ $contact->orders->sum(fn($item) => $item->item->price * $item->cnt) }} ₽</td>
                <td data-label="Имя">{{ $contact->name }}</td>
                <td data-label="№ телефона">{{ $contact->phone }}</td>
                <td data-label="Ip адрес">{{ $contact->token->ip }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="pagination justify-content-center mt-3">
        {{ $contacts->links() }}
    </div>
@endsection
