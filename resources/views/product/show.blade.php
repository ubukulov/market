@extends('layouts.app')
@section('content')
    <div class="main_content">
        <div class="content-title">
            <h4>{{ $product->name }}</h4>
        </div>

        <div class="product-wrap">
            <div class="product_img_carousel">
                <div class="product_slider">
                    <div id="carouselExampleIndicators" class="carousel slide">
                        <div class="carousel-indicators">
                            @foreach($images as $img)
                            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="{{ $loop->index }}" @if($loop->index == 0) class="active" aria-current="true" @endif aria-label="Slide {{ $loop->iteration }}"></button>
                            @endforeach
                        </div>
                        <div class="carousel-inner">
                            @foreach($images as $image)
                            <div class="carousel-item @if($loop->index == 0) active @endif">
                                <img src="{{ $image->path }}" class="d-block" alt="...">
                            </div>
                            @endforeach
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
            </div>

            <div class="product_detail_info">
                <div class="product_page_action_btns">
                    <div class="product_page_barcode_btn">
                        <button type="button">
                            <img src="{{ asset('img/product/barcode.svg') }}" alt="product_barcode">&nbsp;Печать
                        </button>
                    </div>

                    <div class="product_page_cart_btn">
                        <div class="product_count_btn">
                            <img src="{{ asset('img/product/minus.svg') }}" alt="">
                            <span class="product_count_item">2</span>
                            <img src="{{ asset('img/product/plus.svg') }}" alt="">
                        </div>

                        <div class="product_cart_add_btn">
                            <button type="button">В корзину</button>
                        </div>
                    </div>
                </div>

                <div class="description_characteristics">
                    asdasd
                </div>
            </div>

        </div>
    </div>
@stop
