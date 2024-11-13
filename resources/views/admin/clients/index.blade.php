@extends('layouts.app')

@section('content')


            <div>
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Клиенты</h1>
                    <div>
                        <a href="{{route('clients.create')}}" class="btn btn-success">Добавить</a>
                    </div>
                </div>
                @include('inc.alert')
                <div class="table-responsive">
                    <table class="display nowrap" id="dataTable" style="width:100%">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Имя</th>
                            <th scope="col">Телефон</th>
                            <th scope="col">Промокод</th>
                            <th scope="col">Продукт </th>
                            <th scope="col">Время когда выпал</th>
                            <th scope="col">Действия</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($clients as $client)
                            <tr>
                                <td>{{$client->id}}</td>
                                <td>{{"$client->name $client->surname"}}</td>
                                <td>{{$client->phone}}</td>
                                <td>{{$client->promo}}</td>
                                <td>{{$client->product->name ?? '-' }}</td>
                                <td>{{ $client->used_date }}</td>
                                <td class="d-flex">
                                    <form action="{{route('clients.destroy', $client->id)}}" method="post"\
                                        onsubmit="return confirm('Вы действительно хотите навсегда удалить этого клиента ?!')">
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
