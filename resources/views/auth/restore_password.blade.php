@extends('layouts.auth')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="login-form">
                <div class="login_elements">
                    <h4>Восстановить пароль</h4>

                    <h6>Подтвердите e-mail</h6>

                    <form action="" method="post">
                        @csrf
                        <div class="form-group">
                            <span class="auth_email_icon"></span>
                            <input type="email" name="email" class="form-control auth_input_email" placeholder="Введите e-mail" required>
                        </div>

                        <div class="form-group mb-5">
                            <button type="submit" class="btn btn-success">Далее</button>
                        </div>

                        <div class="form-group text-center">
                            <p><a href="{{ route('loginForm') }}" class="auth_a_links restore_a_link">Отмена</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
