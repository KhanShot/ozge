@extends('layouts.app')

@section('content')


    <div>
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Редактирование приза: {{$product->name}}</h1>
            <div>
                <a href="{{route('prizes.index')}}" class="btn btn-success">Назад</a>
            </div>
        </div>
        @include('inc.alert')
        <div class="card ">
            <div class="card-body col-md-4">
                <form action="{{route('prizes.update', $product->id)}}" method="post" enctype="multipart/form-data">
                    @csrf @method('PUT')
                    <div class="form-group mb-3">
                        <label>Название</label>
                        <input type="text" class="form-control" value="{{$product->name}}" required name="name">
                    </div>
                    <div class="form-group mb-3">
                        <label>Описание</label>
                        <input type="text" class="form-control" value="{{$product->description}}" name="description">
                    </div>
                    <div class="form-group mb-3">
                        <label>Количество</label>
                        <input type="number" step="1" min="0" max="500" value="{{$product->quantity}}" class="form-control" required name="quantity">
                    </div>
                    <div class="form-group mb-3">
                        <label>Количество за день</label>
                        <input type="number" step="1" min="0" max="500" value="{{$product->quantity_day}}" class="form-control" required name="quantity_day">
                    </div>
                    <div class="form-group mb-3">
                        <label>Вероятность (уже есть: {{$probability}})</label>
                        <input type="number" step="1" min="0" max="100" class="form-control" value="{{$product->probability}}" required name="probability">
                    </div>
                    <div class="form-group mb-3">
                        <label>Цвет заднего фона</label>
                        <input type="color" class="form-control-color" name="bgColor" value="{{$product->bgColor}}">
                    </div>
                    <div class="form-group mb-3">
                        <label>Цвет шрифта</label>
                        <input type="color" class="form-control-color" name="color" value="{{$product->color}}">
                    </div>
                    <div class="form-group mb-3">
                        <label>Изображение</label>
                        <input type="file" class="form-control" accept="image/*" name="image" alt="">
                    </div>
                    <div class="form-group mb-3">
                        <label>Отображать</label>
                        <select class="form-select" required name="is_active">
                            <option value="1" @if($product->is_active) selected @endif>Да</option>
                            <option value="0" @if(!$product->is_active) selected @endif>Нет</option>
                        </select>
                    </div>
                    <div class="form-group mb-3 d-flex justify-content-end">
                        <button type="submit" class="btn btn-outline-success">Редактировать</button>
                    </div>

                </form>
            </div>
        </div>


    </div>



@endsection
