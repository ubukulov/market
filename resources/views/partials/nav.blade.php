<div class="menu">
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('home') }}">
                <img src="{{ asset('img/main/logo.png') }}" alt="logo">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link categories" href="#">Категории</a>
                        <div class="main_menu">
                            @foreach($categories as $category)
                                <div class="parentMenuListItem">
                                    {{ $category->name }}

                                    @php
                                        $carItems2 = $category->getItems()
                                    @endphp

                                    @if(count($carItems2) > 0)
                                        <div class="subMenuList2">
                                            @foreach($carItems2 as $item2)
                                                <div class="subMenuList2_item @if(count($item2->getItems()) > 0) hasItem @endif">
                                                    <a href="{{ route('category.products', ['slug' => $item2->slug]) }}">{{ $item2->name }}</a>

                                                    @php
                                                        $carItems3 = $item2->getItems()
                                                    @endphp

                                                    @if(count($carItems3) > 0)

                                                        <div class="subMenuList3">
                                                            @foreach($carItems3 as $item3)
                                                                <div class="subMenuList3_item">
                                                                    {{ $item3->name }}
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>

                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#">Акции</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#">Партнерам</a>
                    </li>

                    <li class="nav-item li_search">
                        <form class="d-flex" role="search">
                            <input class="form-control me-2 main_search_input" type="search" placeholder="Поиск" aria-label="Search">
                        </form>
                    </li>

                    {{--<li class="nav-item">
                        <a class="nav-link b2b_portal_btn" href="#">B2B portal</a>
                    </li>--}}

                    <li class="nav-item">
                        <a class="nav-link b2b_portal_btn my_shop_btn" href="{{ route('store.index') }}">Мой магазин</a>
                    </li>

                    <li class="nav-item basket_link">
                        <a class="nav-link" href="{{ route('cart.index') }}">
                            <img src="{{ asset('img/main/cart.svg') }}" alt="">
                            @if($cartCount = Cart::name('cart')->countItems())
                            <div class="cart_count_elements">{{ $cartCount }}</div>
                            @endif
                        </a>
                    </li>

                    <li class="nav-item">
                        @if(Auth::check())
                            <a class="nav-link auth_user" style="color: #39C874;" href="#">
                                <img src="{{ asset('img/main/user.svg') }}" alt=""> &nbsp; Личный кабинет
                            </a>

                            <div class="auth_user_information">
                                <div class="user_full_name">{{ Auth::user()->full_name }}</div>
                                <div class="user_email">{{ Auth::user()->email }}</div>
                                <hr>
                                <div class="auth_user_links">
                                    <a href="{{ route('cabinet.profile') }}">Профиль</a>
                                </div>
                                <div class="auth_user_links">
                                    <a href="#">История заказов</a>
                                </div>
                                <div class="auth_user_links">
                                    <a href="{{ route('logout') }}">Выйти</a>
                                </div>
                            </div>
                        @else
                            <a class="nav-link" href="{{ route('login') }}">
                                <img src="{{ asset('img/main/user.png') }}" alt=""> &nbsp; Вход / Регистрация
                            </a>
                        @endif
                    </li>
                </ul>
            </div>
        </div>
    </nav>



</div>

@push('js')
    <script>
        /*$(document).ready(function(){
            $(".categories").hover(function(){
                $(".main_menu").removeClass('hidden');
            }, function(){
                //$(".main_menu").addClass('hidden');
            });
        });*/
    </script>
@endpush
