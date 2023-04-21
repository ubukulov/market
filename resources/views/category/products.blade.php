@extends('layouts.app')
@section('content')
    <div class="main_content">
        <div class="category p40_200">
            <h4>{{ $category->name }}</h4>
        </div>

        <div class="row f3f5f9">
            @foreach($products as $product)
            <div class="col-md-3">
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
                </div>
            </div>
            @endforeach
        </div>
    </div>
@stop
