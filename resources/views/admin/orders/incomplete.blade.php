@php
    /** @var \App\Models\Admin\Cart\Token $token */
    /** @var \Illuminate\Pagination\LengthAwarePaginator $tokens */
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
            font-size: 1.8rem;
            font-weight: 500;
            /*margin-bottom: .5rem;*/
            padding: 0 !important;
            caption-side: top;
            text-align: center;
            color: #000;
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

        img {
            vertical-align: middle;
            border-style: none;
            height: auto;
        }

        /*table.bottom tr td:nth-child(2) {*/
        /*    text-align: left;*/
        /*}*/

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
    @include('admin.orders._nav_incomplete')

    <table class="bottom">
        <caption><h2 class="text-center">Не заказанные товары</h2></caption>
        <thead>
        <tr>
            <th scope="col">№ заказа</th>
            <th scope="col">Дата первого входа</th>
            <th scope="col">Кол-во позиций</th>
            <th scope="col">Сумма заказа (₽)</th>
            <th scope="col">Ip адрес</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($tokens as $token)
            <tr>
                <td data-label="№ заказа">
                    <a href="{{ route('admin.orders.incomplete.show', $token) }}">
                        {{ $token->invoice->bill_number ?? null }}
                    </a>
                </td>
                <td data-label="Дата первого входа"> {{ $token->created_at->format('d.m.Y H:i') }}</td>
                <td data-label="Кол-во позиций"> {{ $token->cartItems->count() }}</td>
                <td data-label="Сумма заказа (₽)"> {{ number_format($token->cartItems->sum(fn ($cartItem) =>  $cartItem->cnt * $cartItem->item?->price), 0, ',', ' ') }} ₽</td>
                <td data-label="Ip адрес">
                    {{ filter_var($token->ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6) ? 'ipv6' : $token->ip }}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="pagination justify-content-center mt-3">
        {{ $tokens->links() }}
    </div>
@endsection
