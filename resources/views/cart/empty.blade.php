@extends('layouts.app')
@section('content')
    <div class="main_content">
        <div class="content-title">
            <h4>Корзина</h4>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="cart_empty text-center">
                    <div>
                        <img src="{{ asset('img/main/check.svg') }}" alt="">
                    </div>

                    <div style="margin-bottom: 20px">
                        <span>Заявка отправлена! </span>
                        <br>
                        <br>
                        <p>Менеджер свяжется с Вами в течение 15 минут. </p>
                    </div>

                    <div style="margin-top: 30px">
                        <a href="#">В категории</a>

                        <a href="#">История заказов</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
