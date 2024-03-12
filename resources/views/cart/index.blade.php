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
                            <th scope="col">Кол-во (шт)</th>
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
                                <td>{{ $cartItem['cart']['quantity'] }}</td>
                                <td>{{ $cartItem['product']->getPriceFormatter($cartItem['cart']['price']) }} тг</td>
                                <td>В наличии</td>
                                <td>
                                    <button type="button" class="barcode_btn">
                                        <img src="{{ asset('img/product/barcode.svg') }}" alt="product_barcode">&nbsp;Печать
                                    </button>
                                </td>
                                <td>В упаковке</td>
                                <td>
                                    <div class="product_count_btn">
                                        <img @click="decrementProductCount({{ $cartItem['cart']['id'] }})" src="{{ asset('img/product/minus.svg') }}" alt="">
                                        <input v-model="product_count[getProductIndexInArray({{ $cartItem['cart']['id'] }})].cart.quantity" class="product_count_item" type="text">
                                        <img @click="incrementProductCount({{ $cartItem['cart']['id'] }})" src="{{ asset('img/product/plus.svg') }}" alt="">
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
                        <a href="{{ route('cart.order') }}" class="cart_checkout_btn">Отправить заявку</a>
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
                    product_count: <?php echo json_encode($cart_items); ?>,
                    toastHtml: '',
                    toastSuccess: false
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
                incrementProductCount(product_id){
                    this.product_count.forEach((el) => {
                        if(el.cart.id === product_id) {
                            el.cart.quantity++;
                        }
                    })
                },
                decrementProductCount(product_id){
                    if(this.product_count.findIndex(x => x.cart.id === product_id) >= 0) {
                        this.product_count.forEach((el) => {
                            if(el.cart.id === product_id && el.cart.quantity > 1) {
                                el.cart.quantity--;
                            }
                        })
                    }
                },
                getProductIndexInArray(product_id){
                    for(let i = 0; i < this.product_count.length; i++) {
                        if(this.product_count[i].cart.id === product_id) {
                            return i;
                        }
                    }
                }
            },
            created(){
                console.log(this.product_count)
            }
        });
    </script>
@endpush
