@extends('layouts.app')

@section('content')


            <div>
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Призы</h1>
                    <div>
                        <a href="{{route('prizes.create')}}" class="btn btn-success">Добавить</a>
                    </div>
                </div>
                @include('inc.alert')
                <div class="table-responsive">
                    <table class="display nowrap" id="dataTable" style="width:100%">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Название</th>
                            <th scope="col">Количество</th>
                            <th scope="col">Вероятность ({{$products->where('is_active',1)->sum('probability')}})</th>
                            <th scope="col">Отображено</th>
                            <th scope="col">Уже выпало</th>
                            <th scope="col">Действия</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($products as $product)
                            <tr>
                                <td>{{$product->id}}</td>
                                <td>{{$product->name}}</td>
                                <td>{{$product->quantity}}</td>
                                <td>{{$product->probability}}</td>
                                <td>{!! $product->is_active ? "<span style='color:green'>Да</span>" : "<span style='color:red'>Нет</span>"!!}</td>
                                <td>{{ $product->clients_count }}</td>
                                <td class="d-flex">
                                    <a href="{{route('prizes.edit', $product->id)}}" class="btn btn-warning"><span data-feather="edit"></span></a>
                                    <form action="{{route('prizes.destroy', $product->id)}}" method="post"\
                                        onsubmit="confirm('Вы действительно хотите навсегда удалить этот приз?!')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-danger"> <span data-feather="trash"></span></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                </div>



@endsection
