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
                    <li class="nav-item categories">
                        <a class="nav-link" href="#">Категории</a>
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

                    <li class="nav-item">
                        <a class="nav-link b2b_portal_btn" href="#">B2B portal</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link b2b_portal_btn my_shop_btn" href="#">Мой магазин</a>
                    </li>

                    <li class="nav-item basket_link">
                        <a class="nav-link" href="#">
                            <img src="{{ asset('img/main/basket.png') }}" alt="">
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('loginForm') }}">
                            <img src="{{ asset('img/main/user.png') }}" alt=""> &nbsp; Вход / Регистрация
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="main_menu hidden">
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
                                <a href="{{ route('category.products', ['id' => $item2->id]) }}">{{ $item2->name }}</a>

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
