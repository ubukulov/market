@extends('layouts.app')
@section('content')
    <div class="main_content">
        <div class="category-title">
            <h4>Личный кабинет</h4>
        </div>

        <div class="row">
            <div class="col-md-12">
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
                            <div class="row">
                                <div class="col-md-6">
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
                            </div>

                        </div>
                        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                            <div class="row">
                                <div class="col-md-9">
                                    <br>
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
                                                    <div class="order_status">{{ __('cabinet.order.'.$order->status) }}</div>
                                                </td>
                                                <td class="text-right">
                                                    <button @click="getOrderItems({{ $order->id }})" class="cabinet_open_order" type="button" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Открыть счет</button>
                                                </td>
                                                <td>
                                                    <a title="Отправить на e-mail" class="send_invoice" href="#">
                                                        <svg width="18" height="18" viewBox="0 0 18 18">
                                                            <path d="M17.3571 1.92578H0.642857C0.287277 1.92578 0 2.21306 0 2.56864V15.4258C0 15.7814 0.287277 16.0686 0.642857 16.0686H17.3571C17.7127 16.0686 18 15.7814 18 15.4258V2.56864C18 2.21306 17.7127 1.92578 17.3571 1.92578ZM16.5536 4.15167V14.6222H1.44643V4.15167L0.891964 3.71975L1.68147 2.70525L2.54129 3.37422H15.4607L16.3205 2.70525L17.11 3.71975L16.5536 4.15167ZM15.4607 3.37221L9 8.39453L2.53929 3.37221L1.67946 2.70324L0.889955 3.71775L1.44442 4.14967L8.30692 9.48538C8.50428 9.6387 8.74707 9.72193 8.99699 9.72193C9.2469 9.72193 9.4897 9.6387 9.68705 9.48538L16.5536 4.15167L17.108 3.71975L16.3185 2.70525L15.4607 3.37221Z"/>
                                                        </svg>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>

                                    <!-- Modal -->
                                    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content" style="width: 800px">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="staticBackdropLabel">@{{ orderName }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <table class="table table-borderless">
                                                        <thead>
                                                        <th>Фото</th>
                                                        <th>Название</th>
                                                        <th>Штрих-код</th>
                                                        <th>Кол-во</th>
                                                        <th>Цена(тг)</th>
                                                        <th>Сумма(тг)</th>
                                                        </thead>

                                                        <tbody>
                                                        <tr v-for="(item) in items" :key="item">
                                                            <td width="100">
                                                                <img width="100" :src="item.path" alt="">
                                                            </td>
                                                            <td width="270">
                                                                <a class="modal_link" href="#">@{{ item.name }}</a>
                                                            </td>
                                                            <td>
                                                                <div class="product_page_barcode_btn">
                                                                    <button style="width: 120px;" type="button">
                                                                        <img src="{{ asset('img/product/barcode.svg') }}" alt="product_barcode">&nbsp;Печать
                                                                    </button>
                                                                </div>
                                                            </td>
                                                            <td width="70" class="text-center">
                                                                @{{ item.quantity }}
                                                            </td>
                                                            <td>
                                                                @{{ item.price.toLocaleString('ru') }}
                                                            </td>
                                                            <td class="text-center">
                                                                @{{ (item.quantity * item.price).toLocaleString('ru') }}
                                                            </td>
                                                        </tr>
                                                        <tr style="font-size: 16px; font-weight: bold;background-color: #F0F0F6;color: #6D6F80;">
                                                            <td colspan="5" class="text-right">Итого</td>
                                                            <td colspan="2">@{{ getAmount() }} тг</td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="modal-footer">
                                                    <button style="background-color: #39C874;border-color: #39C874;border-radius: 10px;width: 30%;" type="button" class="btn btn-primary">Повторить заказ</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <br>
                                    <div class="product_filter_block">
                                        <div class="product_filter_header">
                                            <div class="p__filter_title">Фильтр</div>
                                            <div class="p__filter_reset">
                                                <a href="#">Сбросить</a>
                                            </div>
                                        </div>
                                        <div class="product_filter_content">
                                            <div class="form-check">
                                                <input type="checkbox" value="1" id="flexCheckDefault1" class="form-check-input">
                                                <label for="flexCheckDefault1" class="form-check-label">Новые</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" value="2" id="flexCheckDefault1" class="form-check-input">
                                                <label for="flexCheckDefault1" class="form-check-label">Оплаченные</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" value="3" id="flexCheckDefault2" class="form-check-input">
                                                <label for="flexCheckDefault2" class="form-check-label">Отгруженные</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" value="4" id="flexCheckDefault3" class="form-check-input">
                                                <label for="flexCheckDefault3" class="form-check-label">Доставленные</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" value="4" id="flexCheckDefault3" class="form-check-input">
                                                <label for="flexCheckDefault3" class="form-check-label">Отмененные</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@push('scripts')
    <script>
        new Vue({
            el: '#wrap',
            data () {
                return {
                    toastHtml: '',
                    toastSuccess: false,
                    items: [],
                    orderName: 'Заказ № '
                }
            },
            methods: {
                getOrderItems(orderId){
                    axios.get(`/cabinet/order/${orderId}/items`)
                    .then(res => {
                        console.log(res);
                        this.orderName += orderId;
                        this.items = res.data;
                    })
                    .catch(err => {
                        console.log(err);
                    })
                },
                getAmount(){
                    let amount = 0;
                    for(let i = 0; i < this.items.length; i++) {
                        amount += this.items[i].quantity * this.items[i].price;
                    }
                    return amount.toLocaleString('ru');
                }
            }
        });
    </script>
@endpush
