@extends('layouts.app')

@section('content')


    <div>
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Добавление клиента</h1>
            <div>
                <a href="{{route('clients.index')}}" class="btn btn-success">Назад</a>
            </div>
        </div>
        <div class="card ">
            <div class="card-body col-md-4">
                <form action="{{route('clients.store')}}" method="post">
                    @csrf
                    <div class="form-group mb-3">
                        <label>Имя *</label>
                        <input type="text" class="form-control" required name="name">
                    </div>
                    <div class="form-group mb-3">
                        <label>Фамилия</label>
                        <input type="text" class="form-control" name="surname">
                    </div>
                    <div class="form-group mb-3">
                        <label>Телефон</label>
                        <input type="tel" id="phone" class="form-control" name="phone">
                    </div>
                    <div class="form-group mb-3">
                        <label>Промокод *</label>
                        <div class="d-flex justify-content-between">
                            <div class="col-md-7">
                                <input type="text" minlength="7" id="promo" class="form-control" required name="promo">
                            </div>

                            <div class="col-md-3">
                                <button type="button" onclick="putPromo()" class="btn btn-outline-primary">Сгенерировать</button>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-3 d-flex justify-content-end">
                        <button type="submit" onclick="copy()" class="btn btn-outline-success">Добавить и скоприовать</button>
                    </div>
                </form>
            </div>
        </div>


    </div>



@endsection
@section('js')
    <script>
        function generatePromoCode(length = 7) {
            const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
            let promoCode = '';
            for (let i = 0; i < length; i++) {
                const randomIndex = Math.floor(Math.random() * characters.length);
                promoCode += characters[randomIndex];
            }
            return promoCode;
        }

        function putPromo() {
            let promo = document.getElementById('promo');
            promo.value = ''
            promo.value = generatePromoCode(7)
        }
        putPromo()


        function copy() {
            let text = '';
            let promo = document.getElementById('promo');
            text = text+promo.value;

            navigator.clipboard.writeText(text);
            console.log(text)
        }
    </script>
@endsection
