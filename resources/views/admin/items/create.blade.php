@php
    /** @var \App\Entity\ItemCategory $category */
    /** @var \Illuminate\Database\Eloquent\Collection $categories */
@endphp

@extends('layouts.app')

@section('content')
    @include('admin.items._nav')
{{--    {{ dump($categories[0]->title)  }}--}}
{{--    {{ dump(old('category_id')) }}--}}
{{--    {{ dump($errors)  }}--}}
{{--    {{ dump($errors->has('img'))  }}--}}
{{--    {{  dump( $errors->first('img')) }}--}}
    <form method="POST" action="{{ route('admin.items.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="title" class="col-form-label">Название</label>
            <input id="title" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" name="title" value="{{ old('title') }}" required>
            @if ($errors->has('title'))
                <span class="invalid-feedback"><strong>{{ $errors->first('title') }}</strong></span>
            @endif
        </div>

        <div class="form-group">
            <label for="note" class="col-form-label">Примечание</label>
            <input id="note" class="form-control{{ $errors->has('note') ? ' is-invalid' : '' }}" name="note" value="{{ old('note') }}">
            @if ($errors->has('note'))
                <span class="invalid-feedback"><strong>{{ $errors->first('note') }}</strong></span>
            @endif
        </div>

        <div class="form-group">
            <label for="article_number" class="col-form-label">Артикул</label>
            <input id="article_number" class="form-control{{ $errors->has('article_number') ? ' is-invalid' : '' }}" name="article_number" value="{{ old('article_number') }}" required>
            @if ($errors->has('article_number'))
                <span class="invalid-feedback"><strong>{{ $errors->first('article_number') }}</strong></span>
            @endif
        </div>

        <div class="form-group">
            <label for="price" class="col-form-label">Цена</label>
            <input id="price" class="form-control{{ $errors->has('price') ? ' is-invalid' : '' }}" name="price" value="{{ old('price') }}" required>
            @if ($errors->has('price'))
                <span class="invalid-feedback"><strong>{{ $errors->first('price') }}</strong></span>
            @endif
        </div>

        <div class="form-check">
            <label class="checkbox-inline" for="is_new" style="padding-left: 5px">
                <input type="checkbox" style="margin-right: 5px" name="is_new" id="is_new" {{ old('is_new') ? 'checked' : '' }}>Новый товар
            </label>
            @if ($errors->has('is_new'))
                <span class="invalid-feedback"><strong>{{ $errors->first('is_new') }}</strong></span>
            @endif

            <label class="checkbox-inline" for="is_hit" style="padding-left: 5px">
                <input type="checkbox" style="margin-right: 5px" name="is_hit" id="is_hit" {{ old('is_hit') ? 'checked' : '' }}>Хит
            </label>
            @if ($errors->has('is_hit'))
                <span class="invalid-feedback"><strong>{{ $errors->first('is_hit') }}</strong></span>
            @endif

            <label class="checkbox-inline" for="is_bestseller" style="padding-left: 5px">
                <input type="checkbox" style="margin-right: 5px" name="is_bestseller" id="is_bestseller" {{ old('is_bestseller') ? 'checked' : '' }}>Бестселлер
            </label>
            @if ($errors->has('is_bestseller'))
                <span class="invalid-feedback"><strong>{{ $errors->first('is_bestseller') }}</strong></span>
            @endif
        </div>

        <div class="form-group">
            {{ Form::label('selectCategory', 'Категория*', ['class' => 'control-label']) }}
            {{ Form::select('category_id', $selectCategory ?? [], '0', ['class' => 'form-control', 'id' => 'selectCategory']) }}
        </div>

        <div class="form-group">
            {{ Form::label('subCategory', 'Подкатегория', ['class' => 'control-label']) }}
            {{ Form::select(
                'sub_category_id',
                Session::get('create_sub_categories')['arr'] ?? $selectSubCategory,
                 old('sub_category_id'),
                    [
                        'class' => 'form-control',
                        'id' => 'subCategory',

                        (isset(Session::get('create_sub_categories')['arr'])
                            ? (count(Session::get('create_sub_categories')['arr']) == 0
                                ? 'disabled'
                                : '')
                            :  (count($selectSubCategory) == 0  ? 'disabled' : '')
                        )
                    ]
                )
            }}
        </div>

        <div class="form-group">
            <label for="img" class="col-form-label">Фото (jpg,png,jpeg,gif,svg)</label>
            <input type="file" name="img" class="form-control{{ $errors->has('img') ? ' is-invalid' : '' }}" id="img" required>
            @if ($errors->has('img'))
                <span class="invalid-feedback"><strong>{{ $errors->first('img') }}</strong></span>
            @endif
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Сохранить</button>
        </div>
    </form>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {

            $('#selectCategory').on('change', function () {
                let idCategory =  $(this).find("option:selected").attr('value');
                if (idCategory !== 0) {

                    let getSubCategories = '{!!route('admin.get_subcategories', ['id' => 'J']) !!}';
                    let url = getSubCategories.replace("J", idCategory);

                    $.ajax({
                        type: "get",
                        url: url,
                        success: function (result) {

                            let items = result.sub_categories;

                            if (items.length > 0) {

                                $('#subCategory').children('option').remove();
                                $('#subCategory').removeAttr('disabled');

                                $('#subCategory').append("<option value='0'>Выберите подкатегорию</option>");
                                $.each(items, function (i, item) {
                                    $('#subCategory').append($('<option>', {
                                        value: item.id,
                                        text : item.title
                                    }));
                                });
                            } else {
                                $('#subCategory').attr('disabled','disabled');
                                $('#subCategory').children('option').remove();
                            }
                        }
                    });
                } else {
                    $('#subCategory').attr('disabled','disabled');
                    $('#subCategory').children('option').remove();
                }
            });
        });
    </script>
@endsection
