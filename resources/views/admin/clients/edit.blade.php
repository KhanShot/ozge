@extends('layouts.app')

@section('content')


    <div>
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Редактирование товара: {{$product->name}}</h1>
            <div>
                <a href="{{route('products.index')}}" class="btn btn-success">Назад</a>
            </div>
        </div>
        <div class="card ">
            <div class="card-body col-md-4">
                <form action="{{route('products.update', $product->id)}}" method="post">
                    @csrf @method('PUT')
                    <div class="form-group mb-3">
                        <label>Название товара</label>
                        <input type="text" class="form-control" value="{{$product->name}}" required name="name">
                    </div>
                    <div class="form-group mb-3">
                        <label>Описание товара</label>
                        <input type="text" class="form-control" value="{{$product->description}}" name="description">
                    </div>
                    <div class="form-group mb-3">
                        <label>Количество</label>
                        <input type="number" step="1" min="0" max="500" value="{{$product->quantity}}" class="form-control" required name="quantity">
                    </div>
                    <div class="form-group mb-3">
                        <label>Вероятность</label>
                        <input type="number" step="1" min="0" max="100" class="form-control" value="{{$product->probability}}" required name="probability">
                    </div>
                    <div class="form-group mb-3">
                        <label>Отображать</label>
                        <select class="form-select" required name="is_active">
                            <option value="1" @if($product->is_active) selected @endif>Да</option>
                            <option value="0" @if(!$product->is_active) selected @endif>Нет</option>
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
