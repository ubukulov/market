@extends('layouts.auth')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="login-form">
                <div class="login_elements">
                    <h4>Вход</h4>
                    <form action="{{ route('authentication') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <span class="auth_email_icon"></span>
                            <input type="email" name="email" class="form-control auth_input_email" placeholder="Введите e-mail" required>
                        </div>

                        <div class="form-group">
                            <input type="password" name="password" class="form-control auth_input_password" placeholder="Введите пароль" required>
                        </div>

                        <div class="auth_form_links">
                            <div class="forget_password">
                                <a href="{{ route('restorePassword') }}" class="auth_a_links">Забыли пароль?</a>
                            </div>

                            <div class="remember_me">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        Запомнить меня
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-5">
                            <button type="submit" class="btn btn-success">Войти</button>
                        </div>

                        <div class="form-group">
                            <p><span>Нет аккаунта?</span>&nbsp;<a href="{{ route('registerForm') }}" class="auth_a_links">Оставить заявку</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
