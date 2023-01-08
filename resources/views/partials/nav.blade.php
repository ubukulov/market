<div class="menu">
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">FD Design</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Категории</a>
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

</div>
