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

    </div>
@stop
