@php
    /** @var \App\Models\Admin\Setting $setting */
    /** @var \Illuminate\Database\Eloquent\Collection $settings */
@endphp
@extends('layouts.app')

@section('content')
    @include('admin.settings._nav')
    <h2 class="text-center">Общие настройки</h2>
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if ($settings->isEmpty())
                <h2 style="color: red" class="text-center mt-5">Настройки не заданы!</h2>
            @else
                <div class="card">
                    <div class="card-body">
                        {{ Form::open(['method' => 'post', 'route' => ['admin.settings.update'], 'files' => false, 'class' => 'container']) }}
                            @foreach($settings as $setting)
                                <div class="form-group">

                                        @php
                                            $isRequired = in_array($setting->prop_key, $requiredFields);
                                            $labelTitle = $setting->title . ($isRequired ? '*' : '');
                                        @endphp
                                        {{ Form::label($setting->prop_key, $labelTitle, ['class' => 'col-form-label']) }}

                                        @php $methodName = $setting->prop_key == 'price_increase' || $setting->prop_key == 'min_order_cost' ? 'number' : 'text'; @endphp
                                        {{ Form::{$methodName}($setting->prop_key, old($setting->prop_key, $setting->prop_value),
                                                [
                                                    'class' => 'form-control' . setIsValidField($setting->prop_key, $errors),
                                                    'id' => $setting->prop_key,
                                                    'required' => $isRequired
                                                ])  }}
                                        @if ($errors->has($setting->prop_key))
                                            <span class="invalid-feedback">{!! $errors->first($setting->prop_key) !!}</span>
                                        @endif
                                </div>
                            @endforeach
                            <div class="form-group mb-0">
                                {{ Form::submit('Сохранить', ['class' => 'btn btn-sm btn-primary'])  }}
                            </div>
                        {{ Form::close() }}
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
