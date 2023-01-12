@php
    /** @var \App\Models\Admin\Item\Item $item */
    /** @var \App\Models\Admin\Item\Category $category */

    /** @var \Illuminate\Database\Eloquent\Collection $categories */
@endphp
@extends('layouts.app')

@section('content')
    @include('admin.items._nav')
    <form method="POST" action="{{ route('admin.items.update', $item) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="title" class="col-form-label">Название</label>
            <input id="title" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" name="title" value="{{ old('title', $item->title) }}" required>
            @if ($errors->has('title'))
                <span class="invalid-feedback"><strong>{{ $errors->first('title') }}</strong></span>
            @endif
        </div>

        <div class="form-group">
            <label for="note" class="col-form-label">Примечание</label>
            <input id="note" class="form-control{{ $errors->has('note') ? ' is-invalid' : '' }}" name="note" value="{{ old('note', $item->note) }}">
            @if ($errors->has('note'))
                <span class="invalid-feedback"><strong>{{ $errors->first('note') }}</strong></span>
            @endif
        </div>

        <div class="form-group">
            <label for="article_number" class="col-form-label">Артикул</label>
            <input id="article_number" class="form-control{{ $errors->has('article_number') ? ' is-invalid' : '' }}" name="article_number" value="{{ old('article_number', $item->article_number) }}" required>
            @if ($errors->has('article_number'))
                <span class="invalid-feedback"><strong>{{ $errors->first('article_number') }}</strong></span>
            @endif
        </div>

        <div class="form-group">
            <label for="price" class="col-form-label">Цена оригинал</label>
            <input id="price" class="form-control{{ $errors->has('price') ? ' is-invalid' : '' }}" name="price" value="{{ old('price', $item->getRawOriginal('price')) }}" required>
            @if ($errors->has('price'))
                <span class="invalid-feedback"><strong>{{ $errors->first('price') }}</strong></span>
            @endif
        </div>

        <div class="form-check">
            <label class="checkbox-inline" for="is_new" style="padding-left: 5px">
                <input type="checkbox" style="margin-right: 5px" name="is_new" id="is_new" {{ $item->is_new ? 'checked' : '' }}>Новый товар
            </label>
            @if ($errors->has('is_new'))
                <span class="invalid-feedback"><strong>{{ $errors->first('is_new') }}</strong></span>
            @endif

            <label class="checkbox-inline" for="is_hit" style="padding-left: 5px">
                <input type="checkbox" style="margin-right: 5px" name="is_hit" id="is_hit" {{ $item->is_hit ? 'checked' : '' }}>Хит
            </label>
            @if ($errors->has('is_hit'))
                <span class="invalid-feedback"><strong>{{ $errors->first('is_hit') }}</strong></span>
            @endif

            <label class="checkbox-inline" for="is_bestseller" style="padding-left: 5px">
                <input type="checkbox" style="margin-right: 5px" name="is_bestseller" id="is_bestseller" {{  $item->is_bestseller ? 'checked' : '' }}>Бестселлер
            </label>
            @if ($errors->has('is_bestseller'))
                <span class="invalid-feedback"><strong>{{ $errors->first('is_bestseller') }}</strong></span>
            @endif
        </div>

        <div class="form-group">
            <label for="category" class="col-form-label">Категория</label>
            <select id="category" class="form-control{{ $errors->has('category') ? ' is-invalid' : '' }}" name="category_id">
                @foreach ($categories as $category)
                    <option
                        value="{{ $category->id }}"
                        {{ (string)$category->id === old('category_id', (string)$item->category_id) ? ' selected' : ''}}>
                        {{ $category->title }}
                    </option>
                @endforeach
            </select>
            @if ($errors->has('category_id'))
                <span class="invalid-feedback"><strong>{{ $errors->first('category_id') }}</strong></span>
            @endif
        </div>

        <div class="row">
            <div style="margin: 20px auto;">
                <img src="{{ Storage::disk('uploads')->url($item->img) }}" alt="" width="300" height="350">
            </div>
        </div>
        <div class="form-group">
            <label for="img" class="col-form-label">Image (jpg,png,jpeg,gif,svg)</label>
            <input type="file" name="img" class="form-control{{ $errors->has('img') ? ' is-invalid' : '' }}" id="img">
            @if ($errors->has('img'))
                <span class="invalid-feedback"><strong>{{ $errors->first('img') }}</strong></span>
            @endif
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
    </form>
@endsection
