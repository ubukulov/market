@extends('layouts.app')
@section('content')
    <div class="main_content">
        <div class="category-title">
            <h4>{{ $category->name }}</h4>
        </div>

        <div class="row">
            <div class="col-md-9">
                @foreach($products as $product)
                    <div class="product_card">
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

                        <div class="product_count_cart_btns">
                            <div class="product_count_btn">
                                <img src="{{ asset('img/product/minus.svg') }}" alt="">
                                <span class="product_count_item">0</span>
                                <img src="{{ asset('img/product/plus.svg') }}" alt="">
                            </div>

                            <div class="product_cart_add_btn">
                                <button type="button">В корзину</button>
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
                            <input class="form-check-input" type="checkbox" value="1" id="flexCheckDefault1">
                            <label class="form-check-label" for="flexCheckDefault1">
                                Новинки
                            </label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="2" id="flexCheckDefault2">
                            <label class="form-check-label" for="flexCheckDefault2">
                                Хиты продаж
                            </label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="3" id="flexCheckDefault3">
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
                            <input class="form-check-input" type="checkbox" value="1" id="flexCheckDefault1">
                            <label class="form-check-label" for="flexCheckDefault1">
                                Название
                            </label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="2" id="flexCheckDefault2">
                            <label class="form-check-label" for="flexCheckDefault2">
                                Артикуль
                            </label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="3" id="flexCheckDefault3">
                            <label class="form-check-label" for="flexCheckDefault3">
                                Цена
                            </label>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@stop
