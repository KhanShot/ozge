@extends('layouts.app')

@section('content')


    <div>
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Добавление приза</h1>
            <div>
                <a href="{{route('prizes.index')}}" class="btn btn-success">Назад</a>
            </div>
        </div>
        @include('inc.alert')
        <div class="card ">
            <div class="card-body col-md-4">
                <form action="{{route('prizes.store')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group mb-3">
                        <label>Название</label>
                        <input type="text" class="form-control" required name="name" value="{{old('name')}}">
                    </div>
                    <div class="form-group mb-3">
                        <label>Описание</label>
                        <input type="text" class="form-control" name="description" value="{{old('description')}}">
                    </div>
                    <div class="form-group mb-3">
                        <label>Количество</label>
                        <input type="number" step="1" min="0" max="500" class="form-control" required name="quantity" value="{{old('quantity')}}">
                    </div>
                    <div class="form-group mb-3">
                        <label>Вероятность (уже есть: {{$probability}})</label>
                        <input type="number" step="1" min="0" max="100" class="form-control" required name="probability" value="{{old('probability')}}">
                    </div>
                    <div class="form-group mb-3">
                        <label>Цвет заднего фона</label>
                        <input type="color" class="form-control-color" name="bgColor" value="{{old('bgColor', '#dd8888')}}">
                    </div>
                    <div class="form-group mb-3">
                        <label>Цвет шрифта</label>
                        <input type="color" class="form-control-color" name="color"  value="{{old('color')}}">
                    </div>
                    <div class="form-group mb-3">
                        <label>Изображение</label>
                        <input type="file" class="form-control" accept="image/*" name="image" alt="">
                    </div>
                    <div class="form-group mb-3">
                        <label>Отображать</label>
                        <select class="form-select" required name="is_active">
                            <option value="1">Да</option>
                            <option value="0">Нет</option>
                        </select>
                    </div>
                    <div class="form-group mb-3 d-flex justify-content-end">
                        <button type="submit" class="btn btn-outline-success">Добавить</button>
                    </div>

                </form>
            </div>
        </div>


    </div>



@endsection
