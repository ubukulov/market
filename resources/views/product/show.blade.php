@extends('layouts.app')
@section('content')
    <div class="main_content">
        <div class="content-title">
            <h4>{{ $product->name }}</h4>
        </div>

        <div class="row">
            <div class="col-md-4">
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
            </div>

            <div class="col-md-8">
                <div class="product_page_action_btns">
                    <div class="product_page_barcode_btn">
                        <button type="button">
                            <img src="{{ asset('img/product/barcode.svg') }}" alt="product_barcode">&nbsp;Печать
                        </button>
                    </div>

                    <div class="product_page_cart_btn">
                        <div class="product_count_btn">
                            <img @click="decrementProductCount()" src="{{ asset('img/product/minus.svg') }}" alt="">
                            <input v-model="product_count" class="product_count_item" type="text">
                            <img @click="incrementProductCount()" src="{{ asset('img/product/plus.svg') }}" alt="">
                        </div>

                        <div class="product_cart_add_btn">
                            <button @click="cartAdd()" type="button">В корзину</button>
                        </div>
                    </div>
                </div>

                <div class="description_characteristics">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Описание</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Характеристики</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">тут описание</div>
                        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                            @foreach($properties->elements[0]->properties as $property)
                            <div class="product_property">
                                <div class="product_property_name">{{ $property->name }}</div>
                                <div class="product_property_value">{!! $property->value !!}</div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="content-title mt-4">
            <h4>Сопутствующие товары</h4>
        </div>

        <div class="row">
            <div class="col-md-12">
                НУЖНО РЕАЛИЗОВАТЬ!
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
                    product_count: 1,
                    product_id: "<?php echo $product->id ?>",
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
                            this.toastHtml = res.data;
                            this.toastSuccess = true;
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
                }
            }
        });
    </script>
@endpush
