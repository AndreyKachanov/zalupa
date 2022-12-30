@php
    /** @var \App\Models\Admin\Cart\Order\Contact $contact */
    /** @var \Illuminate\Pagination\LengthAwarePaginator $contacts */
@endphp

@extends('layouts.app')

@section('content')
    @include('admin.orders._nav')

{{--    <p><a href="{{ route('admin.categories.create') }}" class="btn btn-success">Add Category</a></p>--}}

    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Contact</th>
        </tr>
        </thead>
        <tbody>

        @foreach ($contacts as $contact)
            <tr>
                <td>{{ $contact->created_at }}</td>
                <td>{{ $contact->name }}</td>
                <td>{{ $contact->contact }}</td>
{{--                <td><a href="{{ route('admin.categories.show', $category) }}">{{ $category->title }}</a></td>--}}
{{--                <td>{{ $category->items->count() }}</td>--}}
            </tr>
        @endforeach

        </tbody>
    </table>

    <div class="pagination justify-content-center">
        {{ $contacts->links() }}
    </div>
@endsection
