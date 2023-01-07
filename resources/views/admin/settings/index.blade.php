@php
    /** @var \App\Models\Admin\Cart\Order\Contact $contact */
    /** @var \App\Models\Admin\Cart\Order\Order $order */
    /** @var \Illuminate\Pagination\LengthAwarePaginator $contacts */
@endphp

@extends('layouts.app')

@section('content')
    @include('admin.settings._nav')

        <p><a href="{{ route('admin.settings.price') }}" class="btn btn-success">Изменить цену</a></p>

@endsection
