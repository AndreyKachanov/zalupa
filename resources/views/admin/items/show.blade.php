@php
    /** @var \App\Entity\Item $item */

@endphp

@extends('layouts.app')

@section('content')
    @include('admin.items._nav')

    <div class="d-flex flex-row mb-3">
        <a href="{{ route('admin.items.edit', $item) }}" class="btn btn-primary mr-1">Edit</a>
        <form method="POST" action="{{ route('admin.items.destroy', $item) }}" class="mr-1">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger">Delete</button>
        </form>
    </div>
    <div class="row">
        <div style="margin: 20px auto;">
            <img src="{{ Storage::disk('uploads')->url($item->img) }}" alt="" width="300" height="350">
        </div>
    </div>
    <table class="table table-bordered table-striped">
        <tbody>
            <tr>
                <th>ID</th><td>{{ $item->id }}</td>
            </tr>
            <tr>
                <th>Title</th><td>{{ $item->title }}</td>
            </tr>
            <tr>
                <th>Article number</th><td>{{ $item->article_number }}</td>
            </tr>
            <tr>
                <th>Price 1</th><td>{{ $item->price1 }}</td>
            </tr>
            <tr>
                <th>Price 2</th><td>{{ $item->price2 }}</td>
            </tr>
            <tr>
                <th>Price 3</th><td>{{ $item->price3 }}</td>
            </tr>
            <tr>
                <th>Link</th><td>{{ $item->link }}</td>
            </tr>
            <tr>
                <th>Category</th><td>{{ $item->rCategory->title ?? 'Без категории' }}</td>
            </tr>
        <tbody>
        </tbody>
    </table>
@endsection
