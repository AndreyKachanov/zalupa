@php
    /** @var \App\Entity\ItemCategory $category */
    /** @var \Illuminate\Database\Eloquent\Collection $categories */
@endphp

@extends('layouts.app')

@section('content')
    @include('admin.items._nav')
{{--    {{ dump($categories[0]->title)  }}--}}
{{--    {{ dump(old('category_id')) }}--}}
{{--    {{ dump($errors)  }}--}}
{{--    {{ dump($errors->has('img'))  }}--}}
{{--    {{  dump( $errors->first('img')) }}--}}
    <form method="POST" action="{{ route('admin.items.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="title" class="col-form-label">Title</label>
            <input id="title" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" name="title" value="{{ old('title') }}" required>
            @if ($errors->has('title'))
                <span class="invalid-feedback"><strong>{{ $errors->first('title') }}</strong></span>
            @endif
        </div>

        <div class="form-group">
            <label for="article_number" class="col-form-label">Article number</label>
            <input id="article_number" class="form-control{{ $errors->has('article_number') ? ' is-invalid' : '' }}" name="article_number" value="{{ old('article_number') }}" required>
            @if ($errors->has('article_number'))
                <span class="invalid-feedback"><strong>{{ $errors->first('article_number') }}</strong></span>
            @endif
        </div>

        <div class="form-group">
            <label for="price1" class="col-form-label">Price 1</label>
            <input id="price1" class="form-control{{ $errors->has('price1') ? ' is-invalid' : '' }}" name="price1" value="{{ old('price1') }}" required>
            @if ($errors->has('price1'))
                <span class="invalid-feedback"><strong>{{ $errors->first('price1') }}</strong></span>
            @endif
        </div>

        <div class="form-group">
            <label for="price2" class="col-form-label">Price 2</label>
            <input id="price2" class="form-control{{ $errors->has('price2') ? ' is-invalid' : '' }}" name="price2" value="{{ old('price2') }}" required>
            @if ($errors->has('price2'))
                <span class="invalid-feedback"><strong>{{ $errors->first('price2') }}</strong></span>
            @endif
        </div>

        <div class="form-group">
            <label for="price3" class="col-form-label">Price 3</label>
            <input id="price3" class="form-control{{ $errors->has('price3') ? ' is-invalid' : '' }}" name="price3" value="{{ old('price3') }}" required>
            @if ($errors->has('price3'))
                <span class="invalid-feedback"><strong>{{ $errors->first('price3') }}</strong></span>
            @endif
        </div>

        <div class="form-group">
            <label for="link" class="col-form-label">Link</label>
            <input id="link" class="form-control{{ $errors->has('link') ? ' is-invalid' : '' }}" name="link" value="{{ old('link') }}" required>
            @if ($errors->has('link'))
                <span class="invalid-feedback"><strong>{{ $errors->first('link') }}</strong></span>
            @endif
        </div>

        <div class="form-group">
            <label for="category" class="col-form-label">Category</label>
            <select id="category" class="form-control{{ $errors->has('category') ? ' is-invalid' : '' }}" name="category_id">

                @foreach ($categories as $category)
{{--                    <option value="{{ $category->id }}">{{ $category->title }}</option>--}}
                    <option
                        value="{{ $category->id }}"
                        {{ (string)$category->id === old('category_id') ? ' selected' : ''}}>
                        {{ $category->title }}
                    </option>
                @endforeach;
            </select>
            @if ($errors->has('category_id'))
                <span class="invalid-feedback"><strong>{{ $errors->first('category_id') }}</strong></span>
            @endif
        </div>

        <div class="form-group">
            <label for="img" class="col-form-label">Image (jpg,png,jpeg,gif,svg)</label>
            <input type="file" name="img" class="form-control{{ $errors->has('img') ? ' is-invalid' : '' }}" id="img" required>
            @if ($errors->has('img'))
                <span class="invalid-feedback"><strong>{{ $errors->first('img') }}</strong></span>
            @endif
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
    </form>
@endsection
