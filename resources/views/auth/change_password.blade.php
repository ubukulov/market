@extends('layouts.auth')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="login-form">
                <div class="login_elements">
                    <h4>Восстановление пароля</h4>

                    <h6></h6>

                    <form action="" method="post">
                        @csrf
                        <div class="form-group">
                            <input type="password" name="password" class="form-control auth_input_password" placeholder="Введите новый пароль" required>
                        </div>

                        <div class="form-group mb-5">
                            <input type="password" name="password" class="form-control auth_input_password" placeholder="Повторите новый пароль" required>
                        </div>

                        <div class="form-group mb-5">
                            <button type="submit" class="btn btn-success">Далее</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
