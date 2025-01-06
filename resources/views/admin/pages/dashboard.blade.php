@extends('layouts.app')

@section('content')


            <div class="container">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Статистика</h1>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <form action="">
                            <div class="form-group">
                                <label for="date">Дата</label>
                                <input type="date" class="form-control" name="date" value="{{ request()->get('date') }}">
                            </div>
                            <div class="form-group mt-2">
                                <button class="btn btn-primary w-100">Список</button>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-3">
                        @foreach($data['list'] as $list)
                            <span>{{$list->product_name}}</span> : <b>{{$list->clients_today}}</b>
                            <br>
                        @endforeach
                    </div>
                </div>
                <hr>
                <div class="d-flex justify-content-between flex-wrap">
                    <div class="col-md-3 mt-3">
                        <div class="card bg-warning-subtle">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-5">
                                        <div class="icon-big text-center">
                                            <i style="width:48px;height:48px;" data-feather="gift"></i>
                                        </div>
                                    </div>
                                    <div class="col-7 d-flex align-items-center">
                                        <div class="numbers">
                                            <p class="card-category">Кол-во подарков</p>
                                            <h4 class="card-title">{{$data['prizes'] ?? 0}}</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mt-3">
                        <div class="card bg-secondary-subtle">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-5">
                                        <div class="icon-big text-center">
                                            <i style="width:48px;height:48px;" data-feather="circle"></i>
                                        </div>
                                    </div>
                                    <div class="col-7 d-flex align-items-center">
                                        <div class="numbers">
                                            <p class="card-category">Кол-во спинов</p>
                                            <h4 class="card-title">{{$data['spins'] ?? 0}}</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mt-3">
                        <div class="card bg-danger-subtle">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-5">
                                        <div class="icon-big text-center">
                                            <i style="width:48px;height:48px;" data-feather="users"></i>
                                        </div>
                                    </div>
                                    <div class="col-7 d-flex align-items-center">
                                        <div class="numbers">
                                            <p class="card-category">Кол-во клиентов</p>
                                            <h4 class="card-title">{{$data['clients'] ?? 0}}</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>



@endsection
