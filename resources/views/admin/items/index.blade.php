@php
    /** @var \App\Models\Admin\Item\Item $item */
    /** @var \App\Models\Admin\Item\Category $category */

    /** @var \Illuminate\Pagination\LengthAwarePaginator $items */
    /** @var \Illuminate\Database\Eloquent\Collection $categories */
        //dump(  in_array('title',old('search_checkbox') ) );
    //dump(in_array('title', old('search_checkbox')));
    //dump(old('checkbox_title') !== null);

@endphp

@extends('layouts.app')

@section('content')
    @include('admin.items._nav')
    <p><a href="{{ route('admin.items.create') }}" class="btn btn-success">Добавить</a></p>
    <div class="card mb-3">

        <div class="card-header">Поиск</div>

        <div class="card-body">
            <form action="?" method="GET">
                <div class="form-check">
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
                    <div class="col-sm-1">
                        <button type="submit" name="find" class="btn btn-primary" value="Find">Search</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th>Название</th>
            <th>Примечание</th>
            <th>Артикул</th>
            <th>Цена оригинал</th>
            <th>Цена (<strong>{{ \App\Models\Admin\Setting::firstWhere('prop_key', 'price_increase')->prop_value }} %</strong></th>
            <th>Новый</th>
            <th>Хит</th>
            <th>Бестселлер</th>
            <th>Категория</th>
        </tr>
        </thead>
        <tbody>

        @foreach ($items as $item)
            <tr>
                <td><a href="{{ route('admin.items.show', $item) }}">{{ $item->title }}</a></td>
                <td>{{ $item->note }}</td>
                <td>{{ $item->article_number }}</td>
                <td>{{ $item->getRawOriginal('price') }} ₽</td>
                <td>{{ $item->price }} ₽</td>
                <td>{{ $item->is_new }}</td>
                <td>{{ $item->is_hit }}</td>
                <td>{{ $item->is_bestseller }}</td>
                <td>{{ $item->rCategory->title ?? 'Без категории' }}</td>
            </tr>
        @endforeach

        </tbody>
    </table>
    <div class="pagination justify-content-center">
        {{--        {{ $items->links() }}--}}
        {{ $items->appends(request()->except('page'))->links() }}
    </div>
@endsection
