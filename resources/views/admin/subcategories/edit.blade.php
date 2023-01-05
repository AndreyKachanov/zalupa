@php
    /** @var \App\Models\Admin\Item\Category $category */
@endphp

@extends('layouts.app')

@section('content')
    @include('admin.subcategories._nav')

    <form method="POST" action="{{ route('admin.subcategories.update', $category) }}">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="title" class="col-form-label">Title</label>
            <input id="title" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" name="title" value="{{ old('title', $category->title) }}" required>
            @if ($errors->has('title'))
                <span class="invalid-feedback"><strong>{{ $errors->first('title') }}</strong></span>
            @endif
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
    </form>
@endsection
