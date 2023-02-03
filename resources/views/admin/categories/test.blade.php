@php
    /** @var \App\Models\Admin\Item\Category $category */
    /** @var \Illuminate\Database\Eloquent\Collection $categories */
@endphp

@extends('layouts.app')

@section('content')
    @foreach ($categories as $category)
        <div>
            {{ $category->title }} ({{ $category->id }})

            @foreach ($category->children as $child)
                <div style="margin-left: 20px;">
                    {{ $child->title }} ({{ $child->id }})
                </div>
            @endforeach
        </div>
    @endforeach
@endsection
