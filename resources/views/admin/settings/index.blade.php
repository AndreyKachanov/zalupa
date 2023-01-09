@extends('layouts.app')

@section('content')
    @include('admin.settings._nav')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h2>Общие настройки</h2>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.settings.update') }}">
                        @csrf
                        <div class="form-group row">
                            <label for="price_increase" class="col-sm-2 col-form-label text-md-right">Увеличить цену на %: </label>
                            <div class="col-md-6">
                                <input
                                    type="number"
                                    min="0"
                                    max="1000"
                                    id="price_increase"
                                    class="form-control{{ $errors->has('price_increase') ? ' is-invalid' : '' }}"
                                    name="price_increase"
                                    value="{{ old('price_increase', $priceIncrease) }}"
                                    required
                                >
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="phone_number" class="col-sm-2 col-form-label text-md-right">Номер телефона: </label>
                            <div class="col-md-6">
                                <input
                                    type="text"
                                    id="phone_number"
                                    class="form-control{{ $errors->has('phone_number') ? ' is-invalid' : '' }}"
                                    name="phone_number"
                                    value="{{ old('phone_number', $phoneNumber) }}"
                                    required
                                >
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="instagram" class="col-sm-2 col-form-label text-md-right">Instagram: </label>
                            <div class="col-md-6">
                                <input
                                    type="text"
                                    id="instagram"
                                    class="form-control{{ $errors->has('instagram') ? ' is-invalid' : '' }}"
                                    name="instagram"
                                    value="{{ old('instagram', $instagram) }}"
                                    required
                                >
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="whatsapp" class="col-sm-2 col-form-label text-md-right">Whatsapp: </label>
                            <div class="col-md-6">
                                <input
                                    type="text"
                                    id="whatsapp"
                                    class="form-control{{ $errors->has('whatsapp') ? ' is-invalid' : '' }}"
                                    name="whatsapp"
                                    value="{{ old('whatsapp', $whatsapp) }}"
                                    required
                                >
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-2">
                                <button type="submit" class="btn btn-primary">Сохранить</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
