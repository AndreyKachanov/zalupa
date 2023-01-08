@php
    //dump(old('price_increase'));
@endphp

@extends('layouts.app')

@section('content')
    @include('admin.settings._nav')

        <div>
{{--            <a href="{{ route('admin.settings.edit-price') }}" class="btn btn-success">Изменить цену товаров</a>--}}
            <form method="POST" action="{{ route('admin.settings.store-price') }}">
                @csrf
                    <div class="container">
                        <div class="form-group row">
                            <label for="price_increase" class="col-form-label col-sm-12">Увеличить цену на %: </label>
                            <input
                                id="price_increase"
                                class="col-sm-9 form-control{{ $errors->has('price_increase') ? ' is-invalid' : '' }}"
                                name="price_increase"
                                value="{{ old('price_increase', $priceIncrease) }}" required>
{{--                            @if ($errors->has('price_increase'))--}}
{{--                                <span class="invalid-feedback"><strong>{{ $errors->first('price_increase') }}</strong></span>--}}
{{--                            @endif--}}

                            <div class="form-group col-sm-3">
                                <button type="submit" class="btn btn-primary col">Сохранить</button>
                            </div>

                        </div>
                    </div>
            </form>
        </div>

@endsection
