@extends('layouts.app')
@section('content')
    <div class="main_section">
        <div class="main_title">
            Стать нашим партнером <br>
            очень легко!
        </div>

        <div class="main_sub_title">
            Оставьте нам заявку <br> и мы с вами свяжемся
        </div>

        <div class="main_btn_div">
            <a class="main_btn" href="{{ route('registerForm') }}">Оставить заявку</a>
        </div>

        <h4>Наши преимущества</h4>
    </div>

    <div class="our_advantages_section">
        <div>
            <img src="{{ asset('img/main/mobile.png') }}" alt="mobile">
            <span>Мобильные телефоны</span>
        </div>

        <div>
            <img src="{{ asset('img/main/laptop.png') }}" alt="laptop">
            <span>Ноутбуки</span>
        </div>

        <div>
            <img src="{{ asset('img/main/home.png') }}" alt="home">
            <span>Дом и офис</span>
        </div>

        <div>
            <img src="{{ asset('img/main/desktop.png') }}" alt="desktop">
            <span>ПК и комплектующие</span>
        </div>
    </div>
@stop
