@extends('layouts.app')
@section('content')
    <div class="main_content">
        <div class="category-title">
            <h4>{{ $category->name }}</h4>
        </div>

        <div class="row">
            <div class="col-md-9" id="categoryProductsList">
                @foreach($products as $product)
                    <div class="product_card">
                        <a href="{{ route('product.page', ['slug' => $product->slug]) }}">
                            <div class="product_img">
                                <img src="{{ $product->getThumb() }}" alt="">
                            </div>

                            <div class="product_title">
                                <span>{{ $product->name }}</span>
                            </div>

                            <div class="product_info">
                                <p>Артикуль: {{ $product->article }}</p>
                                <p>в наличии: {{ $product->getQuantity() }}</p>
                                <p>549 990 тг / 468 000 тг (шт)</p>
                            </div>
                        </a>

                        <div class="product_count_cart_btns">
                            <div class="product_count_btn">
                                <img @click="decrementProductCount({{ $product }})" src="{{ asset('img/product/minus.svg') }}" alt="">
                                <input v-model="product_count[getProductIndexInArray({{$product}})].count" readonly class="product_count_item" type="text">
                                <img @click="incrementProductCount({{ $product }})" src="{{ asset('img/product/plus.svg') }}" alt="">
                            </div>

                            <div class="product_cart_add_btn">
                                <button @click="cartAdd({{ $product->id }})" type="button">В корзину</button>
                            </div>
                        </div>

                        <div class="product_barcode_print_btn">
                            <button type="button">
                                <img src="{{ asset('img/product/barcode.svg') }}" alt="product_barcode">&nbsp;Печать
                            </button>
                        </div>
                    </div>
                @endforeach

                <div class="product_content_pagination">
                    {{ $products->links() }}
                </div>
            </div>

            <div class="col-md-3">
                <div class="product_filter_block">
                    <div class="product_filter_header">
                        <div class="p__filter_title">Фильтр</div>
                        <div class="p__filter_reset">
                            <a href="#">Сбросить</a>
                        </div>
                    </div>

                    <div class="product_filter_content">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" v-model="isNew" @change="getProductsByFilter()" id="flexCheckDefault1">
                            <label class="form-check-label" for="flexCheckDefault1">
                                Новинки
                            </label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" v-model="isHit" @change="getProductsByFilter()" id="flexCheckDefault2">
                            <label class="form-check-label" for="flexCheckDefault2">
                                Хиты продаж
                            </label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" v-model="isPromo" @change="getProductsByFilter()" id="flexCheckDefault3">
                            <label class="form-check-label" for="flexCheckDefault3">
                                Новое поступление
                            </label>
                        </div>
                    </div>
                </div>

                <div class="product_filter_block">
                    <div class="product_filter_header">
                        <div class="p__filter_title">Сортировка</div>
                        <div class="p__filter_reset">
                            <a href="#">Сбросить</a>
                        </div>
                    </div>

                    <div class="product_filter_content">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="1" id="flexCheckDefault11">
                            <label class="form-check-label" for="flexCheckDefault11">
                                Название
                            </label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="2" id="flexCheckDefault22">
                            <label class="form-check-label" for="flexCheckDefault22">
                                Артикуль
                            </label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="3" id="flexCheckDefault33">
                            <label class="form-check-label" for="flexCheckDefault33">
                                Цена
                            </label>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    @include('partials.toast')

@stop
@push('scripts')
    <script>
        new Vue({
            el: '#wrap',
            data () {
                return {
                    product_count: [],
                    toastHtml: '',
                    toastSuccess: false,
                    isNew: false,
                    isHit: false,
                    isPromo: false,
                    listProductsByFilter: []
                }
            },
            methods: {
                cartAdd(product_id){
                    let formData = new FormData();
                    formData.append('product_id', product_id);
                    this.product_count.forEach((el) => {
                        if(el.id === product_id) {
                            formData.append('product_count', el.count);
                        }
                    });

                    axios.post('/cart/add', formData)
                        .then(res => {
                            console.log(res);
                            this.toastHtml = res.data;
                            this.toastSuccess = true;
                        })
                        .catch(err => {
                            console.log(err);
                        })
                },
                incrementProductCount(product){
                    if(this.product_count.findIndex(x => x.id === product.id) < 0) {
                        this.product_count.push({id: product.id, count: 1});
                    } else {
                        this.product_count.forEach((el) => {
                            if(el.id === product.id) {
                                el.count++;
                            }
                        })
                    }
                },
                decrementProductCount(product){
                    if(this.product_count.findIndex(x => x.id === product.id) >= 0) {
                        this.product_count.forEach((el) => {
                            if(el.id === product.id && el.count > 1) {
                                el.count--;
                            }
                        })
                    }
                },
                getProductIndexInArray(product){
                    if(this.product_count.findIndex(x => x.id === product.id) < 0) {
                        this.product_count.push({id: product.id, count: 1});
                    }
                    for(let i = 0; i < this.product_count.length; i++) {
                        if(this.product_count[i].id === product.id) {
                            return i;
                        }
                    }
                },
                getProductsByFilter() {
                    let formData = new FormData();
                    if(this.isNew) {
                        formData.append('isnew', this.isNew);
                    }
                    if(this.isHit) {
                        formData.append('ishit', this.isHit);
                    }
                    if(this.isPromo) {
                        formData.append('ispromo', this.isPromo);
                    }
                    axios.post(window.location.href + '/get-products-by-filter', formData)
                    .then(res => {
                        console.log('ss', res);
                        this.listProductsByFilter = res.data;
                        $("#categoryProductsList").html("");
                        let html = "";
                        for(let i=0; i < res.data.data.length; i++) {
                            let item = res.data.data;
                            html += "<div class='product_card'>" +
                                        "<a href='/p/"+item[i].slug+"'>" +
                                            "<div class='product_img'>" +
                                                "<img src='"+item[i].thumb[0].path+"'>" +
                                            "</div> " +
                                            "<div class=\"product_title\">" +
                                                "<span>"+item[i].name+"</span>" +
                                            "</div> " +
                                            "<div class=\"product_info\">" +
                                                "<p>Артикуль: "+item[i].article+"</p> " +
                                                "<p>в наличии: 50</p> " +
                                                "<p>549 990 тг / 468 000 тг (шт)</p>" +
                                            "</div>" +
                                        "</a> " +
                                        "<div class=\"product_count_btn\">" +
                                            "<img @click='decrementProductCount("+item[i]+")' src='/img/product/minus.svg') >" +
                                            "<input v-model='product_count[getProductIndexInArray("+item[i]+")].count' readonly class='product_count_item' type='text'>" +
                                            "<img @click='incrementProductCount("+item[i]+")' src='/img/product/plus.svg'>" +
                                        "</div>" +
                                        "<div class=\"product_cart_add_btn\">" +
                                            "<button @click=\"cartAdd("+item[i].id+")\" type=\"button\">В корзину</button>" +
                                        "</div>" +
                                        "<div class=\"product_barcode_print_btn\">" +
                                            "<button type=\"button\">" +
                                                "<img src=\"/img/product/barcode.svg\" alt=\"product_barcode\">&nbsp;Печать\n" +
                                            "</button>" +
                                        "</div>" +
                                    "</div>";
                        }
                        $("#categoryProductsList").html(html);
                    })
                    .catch(err => {
                        console.log(err)
                    })
                }
            },
            created() {
                console.log('ss', this.listProductsByFilter.length)
            }
        });
    </script>
@endpush
