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
                        <div class="form-group row">
                            <label for="site" class="col-sm-2 col-form-label text-md-right">Site: </label>
                            <div class="col-md-6">
                                <input
                                    type="text"
                                    id="site"
                                    class="form-control{{ $errors->has('site') ? ' is-invalid' : '' }}"
                                    name="site"
                                    value="{{ old('site', $site) }}"
                                    required
                                >
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="viber" class="col-sm-2 col-form-label text-md-right">Viber: </label>
                            <div class="col-md-6">
                                <input
                                    type="text"
                                    id="viber"
                                    class="form-control{{ $errors->has('viber') ? ' is-invalid' : '' }}"
                                    name="viber"
                                    value="{{ old('viber', $viber) }}"
                                    required
                                >
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="tiktok" class="col-sm-2 col-form-label text-md-right">Tiktok: </label>
                            <div class="col-md-6">
                                <input
                                    type="text"
                                    id="tiktok"
                                    class="form-control{{ $errors->has('tiktok') ? ' is-invalid' : '' }}"
                                    name="tiktok"
                                    value="{{ old('tiktok', $tiktok) }}"
                                    required
                                >
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="youtube" class="col-sm-2 col-form-label text-md-right">Youtube: </label>
                            <div class="col-md-6">
                                <input
                                    type="text"
                                    id="youtube"
                                    class="form-control{{ $errors->has('youtube') ? ' is-invalid' : '' }}"
                                    name="youtube"
                                    value="{{ old('youtube', $youtube) }}"
                                    required
                                >
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="customText" class="col-sm-2 col-form-label text-md-right">Общий текст: </label>
                            <div class="col-md-6">
                                <input
                                    type="text"
                                    id="customText"
                                    class="form-control{{ $errors->has('custom_text') ? ' is-invalid' : '' }}"
                                    name="custom_text"
                                    value="{{ old('custom_text', $customText) }}"
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
