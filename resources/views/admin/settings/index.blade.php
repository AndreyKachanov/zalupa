@php
    /** @var \App\Models\Admin\Setting $setting */
@endphp
@extends('layouts.app')

@section('content')
    @include('admin.settings._nav')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h2>Общие настройки:</h2>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.settings.update') }}">
                        @csrf
                        @foreach($settings as $setting)
                            <div class="form-group row">
                                <label for="{{ $setting->prop_key }}"
                                       class="col-sm-2 col-form-label text-md-right">
                                    {{ $setting->title }}:
                                </label>
                                <div class="col-md-6">
                                    <input
                                        type="{{ $setting->prop_key == 'price_increase' ? 'number' : 'text' }}"
                                        {{ $setting->prop_key == 'price_increase' ? 'min=0 max=1000' : 'maxlength=255' }}
                                        id="{{ $setting->prop_key }}"
                                        class="form-control{{ $errors->has($setting->prop_key) ? ' is-invalid' : '' }}"
                                        name="{{ $setting->prop_key }}"
                                        value="{{ $setting->prop_value }}"
                                    >
                                </div>
                            </div>
                        @endforeach
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
