@php
    /** @var \App\Models\Admin\Item\Category $category */
@endphp

@extends('layouts.app')

@section('custom_css')
    <style>
        .wrapper {
            position: relative;
            margin: 20px;
            padding: 20px 5px 10px 5px;
        }

        section, input {
            border: 1px solid #ccc;
            padding: 1ex;
        }

        /* Needs reset */
        h4, p {
            margin: 0;
        }

        /* Fieldset */
        fieldset {
            border: 1px solid #ccc;
        }

        /* Generic floating style */
        .float {
            position: absolute;
            top: -1.8ex;
            left: 20%;
            padding: 0 10px;
            background: #f0f0f0;
            z-index: 1;
        }

        /* Single element */
        .float-title {
            border: 1px solid #ccc;
            padding: 1ex;
        }

        .float-title::after {
            content: attr(title);
            position: absolute;
            top: -1.8ex;
            left: 10px;
            padding: 0 10px;
            background: white;
            z-index: 1;
        }

        .list-group-item {
            padding: .5rem .5rem .5rem .2rem;
            font-size: 11px;
            align-items: center;
        }

        ul.sub-categories:before{
            content:attr(aria-label);
            font-size:120%;
            font-weight:bold;
            margin-left:-15px;
        }

        table.bottom {
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
            font-size: .8em;
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
                font-size: .8em;
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
    @include('admin.categories._nav')

    <h2 class="text-center mt-3 mb-3"><strong>{{ $category->title }}</strong></h2>

        <section class="wrapper">
            <header class="float">
                <h4>Подкатегории</h4>
            </header>
            <div class="row">
                <div class="col-12 mb-2">
                    <a href="{{ route('admin.subcategories.create', $category) }}" class="btn btn-sm btn-success">Добавить</a>
                </div>
                <div class="col-12">

{{--                    <div class="col-12 mb-2 d-flex justify-content-around align-items-center">--}}
{{--                        <a href="{{ route('admin.subcategories.create', $category) }}" class="btn btn-sm btn-success">Добавить</a>--}}
{{--                        <h5 class="text-center mb-0">Подкатегории:</h5>--}}
{{--                    </div>--}}
                    @if($category->children()->exists())
                        <div class="list-group d-flex flex-row flex-wrap">
                            @foreach($category->children->sortBy('sorting') as $children)
                                @php $children->loadCount('items'); @endphp
                                <a href="{{ route('admin.subcategories.show', $children) }}" class="list-group-item w-50 list-group-item-action d-flex justify-content-between">
                                    <img
                                        class="img-thumbnail"
                                        style="width: 25%; height: 100%"
                                        src="{{ is_null($children->img) ?  asset('/assets/no-image.png') : Storage::disk('uploads')->url($children->img) }}"
                                        alt="{{ $children->title }}"
                                    >
                                    <div style="word-break: break-all">
{{--                                        <span class="mr-2">--}}
{{--                                            {{ $children->sorting }}--}}
{{--                                        </span>--}}
                                        {{ $children->title }}
                                    </div>
                                    <div><strong>{{ $children->items_count }}</strong></div>
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </section>



    <div class="row mt-5">
        <div class="col-12">
            <h5 class="text-center">Общая информация</h5>
                <table class="bottom">
                    <thead>
                    <tr>
                        <th scope="col">№ п/п</th>
                        <th scope="col">Фото</th>
                        <th scope="col">Название</th>
                        <th scope="col">Подкатегории</th>
                        <th scope="col">Прямые товары</th>
                        <th scope="col">Товары из подкатегорий</th>
{{--                        <th scope="col">Все подкатегории</th>--}}
                    </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td data-label="№ п/п">
                                {{ $category->sorting }}
                            </td>
                            <td data-label="Фото">
                                <img
                                    src="{{ is_null($category->img) ?  asset('/assets/no-image.png') : Storage::disk('uploads')->url($category->img) }}"
                                    class="img-thumbnail"
                                    alt="{{ $category->title }}"
                                >
                            </td>
                            <td data-label="Название">
                                {{ $category->title }}
                            </td>
                            <td data-label="Подкатегории">
                                {{ $category->children_count }}
                            </td>
                            <td data-label="Товары">
                                {{ $category->items_count }}
                            </td>
                            <td data-label="Товары из подкатегорий">
{{--                                {{ $category->recursive_items_count }}--}}
                                {{ $category->children->sum(fn($category) => $category->items_count) }}
                            </td>

{{--                            <td data-label="Все подкатегории">--}}
{{--                                {{ $category->descendants_count }}--}}
{{--                            </td>--}}
                        </tr>
                    </tbody>
                </table>
        </div>
        <div class="col-12 d-flex justify-content-center mt-3">
            <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-sm btn-primary mr-1 pl-4 pr-4">Изменить</a>
            <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" class="ml-5">
                @csrf
                @method('DELETE')
                <button class="btn btn-sm btn-danger pl-4 pr-4">Удалить</button>
            </form>
        </div>
    </div>
@endsection
