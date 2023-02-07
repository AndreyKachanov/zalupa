@php
    /** @var \App\Models\Admin\Item\Item $item */
    /** @var \Illuminate\Pagination\LengthAwarePaginator $items */
    $priceIncrease = \App\Models\Admin\Setting::firstWhere('prop_key', 'price_increase')->prop_value;
    $th = 'Цена + ' . $priceIncrease . ' %';
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
    @include('admin.items._nav')
    <p><a href="{{ route('admin.items.create') }}" class="btn btn-sm btn-success">Добавить</a></p>
    <div class="card mb-3">
        <div class="card-header">Поиск товара</div>
        <div class="card-body">
            <form action="?" method="GET">
                <div class="form-check" style="padding-left: 0">
                    <label class="checkbox-inline" for="search_title" style="padding-left: 5px">
                        <input
                            type="checkbox"
                            style="margin-right: 5px"
                            name="checkbox_title"
                            id="search_title"
                            {{ old('checkbox_title') !== null ? 'checked' : '' }}
                        >Название
                    </label>
                    <label class="checkbox-inline" for="search_article" style="padding-left: 5px">
                        <input
                            type="checkbox"
                            style="margin-right: 5px"
                            name="checkbox_article_number"
                            id="search_article"
                            {{ old('checkbox_article_number') !== null ? 'checked' : '' }}
                        >
                        Артикул
                    </label>
                    <label class="checkbox-inline" for="search_category" style="padding-left: 5px">
                        <input
                            type="checkbox"
                            style="margin-right: 5px"
                            name="checkbox_category"
                            id="search_category"
                            {{ old('checkbox_category') !== null ? 'checked' : '' }}
                        >Категория
                    </label>
                </div>

                <div class="row">
                    <div class="col-sm-11">
                        <input id="search" type="search" class="form-control" name="search_input"
                               value="{{ old('search_input') }}" required>
                    </div>
                    <div class="col-sm-1 mt-3">
                        <button type="submit" name="find" class="btn btn-sm btn-primary" value="Find">Поиск</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <table class="bottom">
        <caption style="caption-side: top; text-align: center; color: #000">Список товаров</caption>
        <thead>
        <tr>
            <th scope="col">Фото</th>
            <th scope="col">Название</th>
            <th scope="col">Примечание</th>
            <th scope="col">Артикул</th>
            <th scope="col">Цена оригинал</th>
            <th scope="col">{{ $th }}</th>
            <th scope="col">Новый</th>
            <th scope="col">Хит</th>
            <th scope="col">Бест</th>
            <th scope="col">Категория</th>
        </tr>
        </thead>
        <tbody>
            @foreach ($items as $item)
                <tr>
                    <td data-label="Фото">
                        <a href="{{ route('admin.items.show', $item) }}">
                            <img
                                src="{{ Storage::disk('uploads')->url($item->img) }}"
                                class="img-thumbnail"
                                alt="{{ $item->title }}"
                            >
                        </a>
                    </td>
                    <td data-label="Название">
                        <a href="{{ route('admin.items.show', $item) }}">{{ $item->title }}</a>
                    </td>
                    <td data-label="Примечание">
                        {{ $item->note }}
                    </td>
                    <td data-label="Артикул">
                        {{ $item->article_number }}
                    </td>
                    <td data-label="Цена оригинал">
                        {{ $item->getRawOriginal('price') }} руб
                    </td>
                    <td data-label="{{ $th }}">
                        {{ $item->price }} руб
                    </td>
                    <td data-label="Новый">
                        {!! $item->is_new ? '&#x2705;' : '&nbsp;' !!}
                    </td>
                    <td data-label="Хит">
                        {!! $item->is_hit ? '&#x2705;' : '&nbsp;' !!}
                    </td>
                    <td data-label="Бест">
                        {!! $item->is_bestseller ? '&#x2705;' : '&nbsp;' !!}
                    </td>
                    <td data-label="Категория">
                        {{ $item->rCategory->title ?? 'Без категории' }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="pagination justify-content-center mt-3">
        {{ $items->appends(request()->except('page'))->links() }}
    </div>
@endsection
