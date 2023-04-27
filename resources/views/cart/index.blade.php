@extends('layouts.app')
@section('content')
    <div class="main_content">
        <div class="content-title">
            <h4>Корзина</h4>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="cart_table">
                    <div class="mb-2 text-right">
                        <a style="color: #EF5755;" href="{{ route('cart.empty') }}">
                            <img src="{{ asset('img/main/destroy.svg') }}" alt="">&nbsp;Очистить корзину
                        </a>
                    </div>
                    <table class="table table-borderless">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Фото</th>
                            <th scope="col">Название</th>
                            <th scope="col">Остаток(шт)</th>
                            <th scope="col">Цена(тг)</th>
                            <th scope="col">Статус</th>
                            <th scope="col">Штрих-код</th>
                            <th scope="col">В упаковке(шт)</th>
                            <th scope="col" colspan="2"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($cart_items as $cartItem)
                            <tr>
                                <th>{{ $loop->iteration }}</th>
                                <td>
                                    <a href="{{ $cartItem['product']->getLink() }}">
                                        <img width="100" src="{{ $cartItem['product']->getThumb() }}" alt="">
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ $cartItem['product']->getLink() }}">
                                        {{ $cartItem['cart']['title'] }}
                                    </a>
                                </td>
                                <td>{{ $cartItem['product']->getQuantity() }}</td>
                                <td>{{ $cartItem['product']->getPriceFormatter() }} / {{ $cartItem['product']->getPriceFormatter(2) }}</td>
                                <td>В наличии</td>
                                <td>
                                    <button type="button" class="barcode_btn">
                                        <img src="{{ asset('img/product/barcode.svg') }}" alt="product_barcode">&nbsp;Печать
                                    </button>
                                </td>
                                <td>В упаковке</td>
                                <td>
                                    <div class="product_count_btn">
                                        <img @click="decrementProductCount()" src="{{ asset('img/product/minus.svg') }}" alt="">
                                        <input v-model="product_count" class="product_count_item" type="text">
                                        <img @click="incrementProductCount()" src="{{ asset('img/product/plus.svg') }}" alt="">
                                    </div>
                                </td>
                                <td>
                                    <a title="Удалить из корзины" href="{{ route('cart.delete', ['hash' => $cartItem['cart']['hash']]) }}">
                                        <img src="{{ asset('img/main/destroy.svg') }}" alt="">
                                    </a>

                                </td>
                            </tr>
                        @endforeach
                            <tr style="font-size: 20px; font-weight: bold;background-color: #F0F0F6;color: #6D6F80;">
                                <td colspan="8">Итого</td>
                                <td colspan="2">{{ number_format(\Cart::name('cart')->getSubtotal(),0, ',', ' ') }} тг</td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="mt-3 text-right">
                        <a href="#" class="cart_checkout_btn">Отправить заявку</a>
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
                    product_count: 1,
                }
            },
            methods: {
                cartAdd(){
                    let formData = new FormData();
                    formData.append('product_id', this.product_id);
                    formData.append('product_count', this.product_count);
                    axios.post('/cart/add', formData)
                        .then(res => {
                            console.log(res);
                        })
                        .catch(err => {
                            console.log(err);
                        })
                },
                incrementProductCount(){
                    this.product_count++;
                },
                decrementProductCount(){
                    if(this.product_count !== 1) {
                        this.product_count--;
                    }
                },
            }
        });
    </script>
@endpush
