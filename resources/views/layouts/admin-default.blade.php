<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="@yield('mete_description')">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- The above 4 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <!-- Title  -->
    <title>Admin part - KupiTut Shop</title>

    <!-- Favicon  -->
    <link rel="icon" href="https://codworker.github.io/favicon.png" />

    <!-- Core Style CSS -->
    <link rel="stylesheet" href="{{asset('appstyle/assets/bootstrap-5.0.2/css/bootstrap-reboot.css')}}">
    <link rel="stylesheet" href="{{asset('appstyle/assets/bootstrap-5.0.2/css/bootstrap-grid.css')}}">
    <link rel="stylesheet" href="{{asset('appstyle/assets/bootstrap-5.0.2/css/bootstrap.css')}}">
    <link rel="stylesheet" href="{{asset('appstyle/assets/font-awesome/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('appstyle/styles/main.css?v=').time()}}">
    <link rel="stylesheet" href="{{asset('appstyle/styles/admin.css')}}">
    
</head>


<body class="admin-body">
    <header>
        <div class="col-lg-2 col-sm-12 logo">
            <a target="_blank" href="{{ route('home') }}"><span>{{config('app.name')}}</span></a>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <section id="admin-header-menu" style="background-color: black">
                        <div><a href="">Заказы</a></div>
                        <div><a href="">Все просмотры товаров</a></div>
                        <div><a href="">Сообщения</a></div>
                    </section>
                </div>
            </div>
        </div>
    </header>

    <!--breadcrumbs-->
    <section class="bcr">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                        <!-- More info https://www.tutsplanet.com/snippets/how-to-check-if-the-current-page-is-homepage-in-laravel/ -->
                            @if(Request::is('/'))
                            <li class="breadcrumb-item">Главная</li>
                            @else
                            <li class="breadcrumb-item"><a href="<?= route('admin-home', []); ?>">Главная</a></li>
                            @endif
                            @yield('breadcrumbs')
                            <!-- <li class="breadcrumb-item active" aria-current="page">Контакты</li> -->
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>

    <main>
        <div class="container">
            <div class="row">
            <h1>Admin part</h1>
            <hr>
                <!-- Sidebar -->
                <div class="col-md-2">
                    <section id="admin-sidebar">
                        <div class="admin-sidebar__item">
                            <h3>Категории</h3>
                            <ul>
                                <li class="admin-sidebar__line <?= url()->current() == route('admin-category-index', []) ? 'active' : '' ?>">
                                    <a href="<?= route('admin-category-index', []); ?>">Все</a>
                                </li>
                                <li class="admin-sidebar__line <?= url()->current() == route('admin-category-create', []) ? 'active' : '' ?>">
                                    <a href="<?= route('admin-category-create', []); ?>">Создать</a>
                                </li>
                            </ul>
                        </div>  

                        <div class="admin-sidebar__item">
                            <h3>Бренды</h3>
                            <ul>
                                <li class="admin-sidebar__line <?= url()->current() == route('admin-brand-index', []) ? 'active' : '' ?>">
                                    <a href="<?= route('admin-brand-index', []); ?>">Все</a>
                                </li>
                                <li class="admin-sidebar__line <?= url()->current() == route('admin-brand-create', []) ? 'active' : '' ?>">
                                    <a href="<?= route('admin-brand-create', []); ?>">Создать</a>
                                </li>
                            </ul>
                        </div> 

                        <div class="admin-sidebar__item">
                            <h3>Продукты</h3>
                            <ul>
                                <li class="admin-sidebar__line <?= url()->current() == route('admin-product-index', []) ? 'active' : '' ?>">
                                    <a href="<?= route('admin-product-index', []); ?>">Все</a>
                                </li>
                                <li class="admin-sidebar__line <?= url()->current() == route('admin-product-create', []) ? 'active' : '' ?>">
                                    <a href="<?= route('admin-product-create', []); ?>">Создать</a>
                                </li>
                            </ul>
                        </div> 

                        <div class="admin-sidebar__item">
                            <h3>Контакты</h3>
                            <ul>
                                <li class="admin-sidebar__line <?= url()->current() == route('admin-contacts-index', []) ? 'active' : '' ?>">
                                    <a href="<?= route('admin-contacts-index', []); ?>">Все</a>
                                </li>
                                <li class="admin-sidebar__line <?= url()->current() == route('admin-contacts-create', []) ? 'active' : '' ?>">
                                    <a href="<?= route('admin-contacts-create', []); ?>">Создать</a>
                                </li>
                            </ul>
                        </div> 

                        <div class="admin-sidebar__item">
                            <h3>Поставщики</h3>
                            <ul>
                                <li class="admin-sidebar__line <?= url()->current() == route('admin-product-owner-index', []) ? 'active' : '' ?>">
                                    <a href="<?= route('admin-product-owner-index', []); ?>">Все</a>
                                </li>
                                <li class="admin-sidebar__line <?= url()->current() == route('admin-product-owner-create', []) ? 'active' : '' ?>">
                                    <a href="<?= route('admin-product-owner-create', []); ?>">Создать</a>
                                </li>
                            </ul>
                        </div>
                        <div class="admin-sidebar__item">
                            <h3>Заказы</h3>
                            <ul>
                                <li class="admin-sidebar__line <?= url()->current() == route('admin-orders-index', []) ? 'active' : '' ?>">
                                    <a href="<?= route('admin-orders-index', []); ?>">Все</a>
                                </li>
                                <li class="admin-sidebar__line <?= url()->current() == route('admin-orders-create', []) ? 'active' : '' ?>">
                                    <a href="<?= route('admin-orders-create', []); ?>">Создать</a>
                                </li>
                            </ul>
                        </div>
                        <div class="admin-sidebar__item">
                            <h3>Партнеры</h3>
                            <ul>
                                <li class="admin-sidebar__line <?= url()->current() == route('admin-partners-index', []) ? 'active' : '' ?>">
                                    <a href="<?= route('admin-partners-index', []); ?>">Все</a>
                                </li>
                                <!-- <li class="admin-sidebar__line <?= url()->current() == route('admin-partners-create', []) ? 'active' : '' ?>">
                                    <a href="<?= route('admin-partners-create', []); ?>">Создать</a>
                                </li> -->
                            </ul>
                        </div>
                        <div class="admin-sidebar__item">
                            <h3>Методы доставки</h3>
                            <ul>
                                <li class="admin-sidebar__line <?= url()->current() == route('admin-shipping-methods-index', []) ? 'active' : '' ?>">
                                    <a href="<?= route('admin-shipping-methods-index', []); ?>">Все</a>
                                </li>
                                <li class="admin-sidebar__line <?= url()->current() == route('admin-shipping-methods-create', []) ? 'active' : '' ?>">
                                    <a href="<?= route('admin-shipping-methods-create', []); ?>">Создать</a>
                                </li>
                            </ul>
                        </div>

                        <br><br>
                        <hr>
                        <h2 class="text-success"><i>Структура сайта</i></h2>
                        <hr>

                        <div class="admin-sidebar__item">
                            <h3>Меню в хедере</h3>
                            <ul>
                                <li class="admin-sidebar__line <?= url()->current() == route('admin-header-menu-index', []) ? 'active' : '' ?>">
                                    <a href="<?= route('admin-header-menu-index', []); ?>">Все</a>
                                </li>
                                <li class="admin-sidebar__line <?= url()->current() == route('admin-header-menu-create', []) ? 'active' : '' ?>">
                                    <a href="<?= route('admin-header-menu-create', []); ?>">Создать</a>
                                </li>
                            </ul>
                        </div>

                        <div class="admin-sidebar__item">
                            <h3>Меню в футере</h3>
                            <ul>
                                <li class="admin-sidebar__line <?= url()->current() == route('admin-footer-menu-index', []) ? 'active' : '' ?>">
                                    <a href="<?= route('admin-footer-menu-index', []); ?>">Все</a>
                                </li>
                                <li class="admin-sidebar__line <?= url()->current() == route('admin-footer-menu-create', []) ? 'active' : '' ?>">
                                    <a href="<?= route('admin-footer-menu-create', []); ?>">Создать</a>
                                </li>
                            </ul>
                        </div>

                        <div class="admin-sidebar__item">
                            <h3>Экспорт из файла</h3>
                            <ul>
                                <li class="admin-sidebar__line <?= url()->current() == route('admin-footer-menu-index', []) ? 'active' : '' ?>">
                                    <a href="<?= route('admin-export-file-product-index', []); ?>">Все во временном хранилище</a>
                                </li>
                                <li class="admin-sidebar__line <?= url()->current() == route('admin-footer-menu-create', []) ? 'active' : '' ?>">
                                    <a href="<?= route('admin-export-file-product-create', []); ?>">Создать новый экспорт</a>
                                </li>
                            </ul>
                        </div>

                        <div class="admin-sidebar__item" style="background-color: #b2b2b2">
                            <h2><i>Информер</i></h2>
                            <ul>
                                <li class="admin-sidebar__line">
                                    <a href="">Просмотры продуктов</a>
                                </li>
                                <li class="admin-sidebar__line">
                                    <a href="">Заказы</a>
                                </li>
                                <li class="admin-sidebar__line">
                                    <a href="">Избранные продукты</a>
                                </li>
                            </ul>
                        </div>
                    </section>
                </div>
                <!-- Content -->
                <div class="col-md-10">
                @yield('content')
                </div>
            </div>
        </div>
    </main>

    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <section>
                        <a href="">Главная админки</a>
                    </section>
                </div>
            </div>
        </div>
        
    </footer>


    <!-- ##### jQuery (Necessary for All JavaScript Plugins) ##### -->
    <script src="{{asset('appstyle/scripts/jquery/jquery-2.2.4.min.js')}}"></script>
    <script src="{{asset('appstyle/scripts/jquery-mobile/jquery.mobile.custom.min.js')}}"></script>
    <script src="{{asset('appstyle/scripts/jquery-ui-1.13.2/jquery-ui.min.js')}}"></script>
    <script src="{{asset('appstyle/assets/bootstrap-5.0.2/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('appstyle/scripts/main.js')}}"></script>
    <script src="{{asset('appstyle/scripts/admin.js')}}"></script>

    <script>
        $(function () {
            @stack('scripts')
        });
    </script>

</body>

</html>