@extends('layouts.app')
@section('content')
    <div class="main_content">
        <div class="category-title">
            <h4>Личный кабинет</h4>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="cabinet_profile">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Информация</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">История заказов</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                            <h4 class="mt-3">Основная информация</h4>
                            <div class="form-group">
                                <label>ФИО</label>
                                <input type="text" class="form-control" value="{{ $user->full_name }}">
                            </div>
                            <div class="form-group mt-2">
                                <label>Email</label>
                                <input type="text" class="form-control" value="{{ $user->email }}">
                            </div>
                            <div class="form-group mt-2">
                                <label>Номер телефона</label>
                                <input type="text" class="form-control" value="{{ $user->phone }}">
                            </div>
                            <div class="form-group mt-2">
                                <label>Название компании</label>
                                <input type="text" class="form-control" value="">
                            </div>

                            <h4 class="mt-3">Дополнительные данные</h4>
                            <div class="form-group mt-2">
                                <label>Сфера деятельности</label>
                                <input type="text" class="form-control" value="">
                            </div>
                            <div class="form-group mt-2">
                                <label>Должность</label>
                                <input type="text" class="form-control" value="">
                            </div>
                            <div class="form-group mt-2">
                                <label>Сайт компании</label>
                                <input type="text" class="form-control" value="">
                            </div>

                            <h4 class="mt-3">Данные для договора</h4>
                            <div class="form-group mt-2">
                                <label>БИН</label>
                                <input type="text" class="form-control" value="{{ $user->bin }}">
                            </div>
                            <div class="form-group mt-2">
                                <label>Юридический адрес (полный)</label>
                                <input type="text" class="form-control" value="{{ $user->legal_address }}">
                            </div>
                            <div class="form-group mt-2">
                                <label>БИК</label>
                                <input type="text" class="form-control" value="{{ $user->bik }}">
                            </div>
                            <div class="form-group mt-2">
                                <label>Банк</label>
                                <input type="text" class="form-control" value="{{ $user->bank }}">
                            </div>
                            <div class="form-group mt-2">
                                <label>ИИК (номер счета)</label>
                                <input type="text" class="form-control" value="{{ $user->iik }}">
                            </div>
                            <div class="form-group mt-2">
                                <label>ФИО Директора</label>
                                <input type="text" class="form-control" value="{{ $user->full_name_director }}">
                            </div>
                        </div>
                        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                            <table class="table table-borderless">
                                <thead>
                                    <th>№</th>
                                    <th>Дата создания</th>
                                    <th>Сумма(тг)</th>
                                    <th>Статус</th>
                                    <th colspan="2"></th>
                                </thead>

                                <tbody>
                                @foreach($user->orders as $order)
                                <tr>
                                    <td>{{ $order->id }}</td>
                                    <td>{{ $order->order_date }}</td>
                                    <td>{{ number_format($order->sum, 0, ',', ' ') }} тг</td>
                                    <td>

                                    </td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
