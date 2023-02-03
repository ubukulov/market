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

    <div class="main_content">

        @include('partials.advantages')

        @include('partials.popular_cats')

        @include('partials.slider')

        <div class="p40_200 f3f5f9">
            <h4>О компании</h4>
        </div>

        <div class="our_company f3f5f9 p40_200">
            <img style="margin-right: 40px; height: 350px;" src="{{ asset('img/main/our_company.svg') }}" alt="our company" align="left">
            <br><br>
            <p>
                Предлагаем полный спектр товаров для дома, офиса и <br> промышленности. Компьютерные комплектующие, <br> сетевое, охранное и монтажное оборудование мировых
                <br> брендов по самым выгодным ценам. <br>
            </p>

            <p>
                Высокая скорость работы, индивидуальный подход, <br>рекламная поддержка, партнëрские программы, семинары
                <br> и тренинги - мы предоставляем обслуживание самого высокого уровня.
            </p>
        </div>

        @include('partials.footer')
    </div>
@stop
