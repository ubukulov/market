@extends('layouts.auth')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="login-form">
                <div class="login_elements">
                    <h4>Регистрация</h4>

                    <h6>Заполните личные данные</h6>

                    <form action="" method="post">
                        @csrf
                        <div class="form-group mb-4">
                            <input type="text" name="email" class="form-control" placeholder="ФИО" required>
                        </div>

                        <div class="form-group mb-4">
                            <input type="email" name="email" class="form-control" placeholder="E-mail" required>
                        </div>

                        <div class="form-group mb-4">
                            <input type="text" name="password" class="form-control" placeholder="Номер телефона" required>
                        </div>


                        <div class="form-group mb-2">
                            <button type="submit" class="btn btn-success">Далее</button>
                        </div>

                        <div class="form-group">
                            <p><span>Есть аккаунт?</span>&nbsp;<a href="{{ route('loginForm') }}" class="auth_a_links">Войти</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
