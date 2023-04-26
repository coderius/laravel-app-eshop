<?php
use App\Services\LikeService;

$app = app();
$likeService = $app->make(LikeService::class);
$hasLikes = (bool) $likeService->countPersonLikes();
$countLikes = $likeService->countPersonLikes();
// dd();

// echo app()->make(App\Services\CookieService::class)->getCookieUid();

?>


<section class="header">
    <div class="container">
        <div class="row">
            <div class="col-lg-2 col-sm-12 logo">
                <a href="{{ route('home') }}"><span>{{config('app.name')}}</span></a>
            </div>

            <!-- <div class="col-lg-6 col-sm-12 search">
                <div class="row">
                    <div class="col-md-5 mx-auto">
                        <div class="input-group">
                            <input class="form-control border-end-0 border rounded-pill" type="search" value
                                placeholder="Поиск товара по каталогу" id="example-search-input">
                            <span class="input-group-append">
                                <button
                                    class="btn btn-outline-secondary bg-white border-bottom-0 border rounded-pill ms-n5"
                                    type="button">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                        </div>
                    </div>
                </div>
            </div> -->

            <!-- <div class="col-lg-2 col-sm-12">
                <div class="header-contacts">
                    <a href="#"><span>Наши контакты</span></a>
                </div>
            </div> -->
            <div class="col-lg-4 col-sm-12 offset-lg-6 actions">
                @if(isPartner())
                <a href="{{ route('partner') }}">Кабинет партнера</a>
                @endif
            
                @if(Auth::check())
                

                <div class="login">
                    @if(Auth::user()->is_admin == 1)
                    <a href="<?= route('admin-home', []); ?>">Админка</a>
                    @endif
                </div>

                <a class="" href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                    Выход
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
                

                <!-- <div class="add-to-card">
                    <a href="/shopping-basket">
                        <i class="fa fa-shopping-basket"></i>
                        <span class="add-to-card__count">7</span>
                    </a>
                </div> -->
                @else
                <div class="login">
                    <!-- <i class="fa fa-heart-o"></i> -->
                    <a href="{{ route('login') }}">
                        <i class="fa fa-user-o"></i>
                        <small>Login</small>
                    </a>
                </div>
                @endif
                <div class="add-to-favorite" data-like-route="<?= route('like-count', []); ?>">
                    <!-- <i class="fa fa-heart-o"></i> -->
                    <a href="{{ route('wishlist') }}">
                        @if($hasLikes)
                        <i class="fa fa-heart"></i>
                        <span class="add-to-card__count">{{$countLikes}}</span>
                        @else
                        <i class="fa fa-heart-o"></i>
                        <span class="add-to-card__count">{{$countLikes}}</span>
                        @endif
                    </a>
                </div>

                <!-- <div class="add-to-card">
                    <a href="{{ route('cart') }}">
                        <i class="fa fa-shopping-basket"></i>
                        <span class="add-to-card__count">7</span>
                    </a>
                </div> -->


            </div>
        </div>
    </div>
</section>