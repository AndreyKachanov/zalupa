@php
    /** @var \App\Models\Admin\Item\Item $item */
    /** @var \App\Models\Admin\Item\Category $category */

    /** @var \Illuminate\Pagination\LengthAwarePaginator $items */
    /** @var \Illuminate\Database\Eloquent\Collection $categories */
@endphp

@extends('layouts.app')

@section('content')
    @include('admin.items._nav')
    <p><a href="{{ route('admin.items.create') }}" class="btn btn-success">Add Item</a></p>
    <div class="card mb-3">
        <div class="card-header">Search</div>
        <div class="card-body">
            <form action="?" method="GET">
                <div class="row">
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label for="title" class="col-form-label">Title</label>
                            <input id="title" class="form-control" name="title"
                                   value="{{ request('title') }}">
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label for="article_number" class="col-form-label">Article number</label>
                            <input id="article_number" class="form-control" name="article_number"
                                   value="{{ request('article_number') }}">
                        </div>
                    </div>
                    <div class="col-sm-1">
                        <div class="form-group">
                            <label for="price1" class="col-form-label">Price 1</label>
                            <input id="price1" class="form-control" name="price1"
                                   value="{{ request('price1') }}">
                        </div>
                    </div>
                    <div class="col-sm-1">
                        <div class="form-group">
                            <label for="price2" class="col-form-label">Price 2</label>
                            <input id="price2" class="form-control" name="price2"
                                   value="{{ request('price2') }}">
                        </div>
                    </div>
                    <div class="col-sm-1">
                        <div class="form-group">
                            <label for="price3" class="col-form-label">Price 3</label>
                            <input id="price3" class="form-control" name="price3"
                                   value="{{ request('price3') }}">
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label for="categories" class="col-form-label">Categories</label>
                            <select id="categories" class="form-control" name="category_id">
                                <option value=""></option>
                                @isset($categories)
                                    @forelse ($categories as $key => $category)
                                        <option
                                                {{ $category->id === (int)request('category_id') ? ' selected' : '' }}
                                                value="{{ $category->id }}"
                                        >
                                            {{ $category->title }}
                                        </option>
                                    @empty
                                        <option value="">No categories</option>
                                    @endforelse;
                                @endisset
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-1">
                        <button type="submit" class="btn btn-primary">Search</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Article number</th>
            <th>Price 1</th>
            <th>Price 2</th>
            <th>Price 3</th>
            <th>Link</th>
            <th>Category</th>
        </tr>
        </thead>
        <tbody>

        @foreach ($items as $item)
            <tr>
                <td>{{ $item->id }}</td>
                <td><a href="{{ route('admin.items.show', $item) }}">{{ $item->title }}</a></td>
                <td>{{ $item->article_number }}</td>
                <td>{{ $item->price1 }}</td>
                <td>{{ $item->price2 }}</td>
                <td>{{ $item->price3 }}</td>
                <td>{{ $item->link }}</td>
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
