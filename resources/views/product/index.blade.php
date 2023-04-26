<?php
use App\Services\LikeService;
use App\Services\ProductService;

$app = app();
$likeService = $app->make(LikeService::class);
$productService = $app->make(ProductService::class);


?>
@extends('layouts.default')

<?php //ADD META TAGS HERE ?>
@section('mete_title'){{$product->title}}@endsection
@section('mete_description'){{$product->description}}@endsection

@section('mete_soc')
<!-- Social meta  -->
<meta property="og:title" content="<?= $product->title; ?>"/>
<meta property="og:type" content="product"/>
<meta property="og:brand" content=""/>
<meta property="og:price:amount" content="<?= $product->price; ?>"/>
<meta property="og:price:currency" content="UAH"/>
<meta property="og:availability" content="instock"/>
<meta property="og:image" content="<?= asset("images/products/".$product->id."/big/".$product->imageFirst()->alias); ?>"/>
<meta property="og:url" content="<?= url()->current(); ?>"/>
<meta property="og:description" content="<?= $product->description; ?>"/>
<meta property="og:site_name" content="Интернет-магазин elecci"/>

<meta name="twitter:card" content="<?= $product->title; ?>"/>
<meta name="twitter:image:alt" content="<?= $product->short_title; ?>"/>
<meta name="twitter:title" content="<?= $product->title; ?>"/>
<meta name="twitter:description" content="<?= $product->description; ?>"/>
@endsection

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="<?= route('catalog', []); ?>">Каталог</a></li>

    @if($category->parentCategories()->count() > 0)
        @foreach($category->parentCategories() as $sub)
        <li class="breadcrumb-item"><a href="<?= route('category', ['alias' => $sub->alias]); ?>">{{$sub->name}}</a></li>
        @endforeach
    @endif
    <li class="breadcrumb-item"><a href="<?= route('category', ['alias' => $category->alias]); ?>">{{$category->name}}</a></li>


    @if($brand->exists())
    <li class="breadcrumb-item"><a href="<?= route('brand', ['alias' => $brand->alias]); ?>">{{$brand->name}}</a></li>
    @endif
    <li class="breadcrumb-item active" aria-current="page">{{$product->short_title}}</li>
@endsection

<?php //echo $product->createdBy->name ?>


@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-6 col-sm-12">
            <!-- Slider -->
            @if($product->hasImages())
            <section class="slider-column" id="SSliderWrap">
                <ul class="slider-items" id="SSliderItems" style="<?php echo $images->count() < 5 ? 'justify-content: flex-start; gap: 10px;' : 'justify-content: space-between'; ?>">
                    @php
                        $counter = 1;
                    @endphp
                    @foreach($images as $image)
                    @if($image->is_first == 0)
                    <li><img src="<?= asset("images/products/$product->id/middle/$image->alias"); ?>" data-sslider-img-index="<?= $counter += 1; ?>" data-sslider-img="<?= asset(asset("images/products/$product->id/big/$image->alias")); ?>" alt="<?= $image->alt; ?>"></li>
                    @endif
                    @endforeach
                    <!-- Genirated content for last slide in js -->
                    <li class="slider-item-last" style="display: none" id="SSliderImgExtra">
                        <img src="" id="SSliderImgForExtraNum">
                        <p>
                            <span id="SSliderExtraNum">+3</span>
                        </p>
                    </li>
                </ul>
                <div class="slider-img" id="SSliderMainImg">
                    @foreach($images as $image)
                    @if($image->is_first == 1)
                    <img src="<?= asset("images/products/$product->id/big/$image->alias"); ?>" data-sslider-img-index="1" data-sslider-img="<?= asset(asset("images/products/$product->id/big/$image->alias")); ?>" alt="<?= $image->alt; ?>">
                    @endif
                    @endforeach
                </div>
            </section>
            @else
            <div style="margin-bottom: 30px;"class="product-no-img">
                <img style="width: 100%;border-radius: 30px;" src='<?= asset("images/default/no-photo.jpg"); ?>' alt="Нет картинки" >
            </div>
            @endif

        </div>
        <!-- Slider content row -->
        <div class="col-lg-6 col-sm-12">
            <section class="content-column">
                <div class="content-column__top">
                    <div class="content-column__status">
                        <span>{{$in_stock}}</span>
                    </div>
                    <div class="content-column__favorite js-hendler" data-product-id="1">
                    <i class="fa <?= $likeService->isProductLiked($product->id) ? "fa-heart" : "fa-heart-o"; ?> like-btn" data-prod-id="<?= $product->id; ?>" data-like-route="<?= route('like', []); ?>"></i>
                    </div>
                    
                </div>
                

                <div class="content-column__header">
                    <h1>{{$product->header}}</h1>
                </div>
                @if(isAdmin())
                <div style="font-size:16px;color:#b2b2b2">
                    <i class="fa fa-eye"></i>
                    <span>{{$product->viewsProduct()}}</span>
                    <p></p>
                    <span>Артикул продавца: {{$product->owner_article}}</span>
                </div>
                @endif
                <div class="content-column__tax">
                    <p>{{$product->price}} {{$product->currensy}}.</p>
                </div>
                <ul class="content-column__params">
                    <li>
                        <b>Состояние:</b> 
                        <span>{{$product_state}}</span>
                    </li>
                </ul>
                <div class="content-column__buy">
                    <div>
                        <a type="button" class="btn btn-success button-radius-25" href="<?= route('making-checkout', ['id' => $product->id]); ?>" target="_blank">Купить</a>
                        <a type="button" class="btn btn-primary button-radius-25 add-message" href="">Задать вопрос</a>
                    </div>
                    
                    <div class="contacts-faq">
                        <div class="contacts-faq-title">Есть вопрос? Обращайтесь.</div>
                        @if($phone->count() > 0)
                        @foreach($phone as $ph)
                        <div class="contact-faq-contact"><a href="<?= $ph->link; ?>" class="contacts-faq-item"><?= $ph->text; ?></a></div>
                        @endforeach
                        @endif
                        @if($telegram->count() > 0)
                        <div class="contact-faq-contact"><a href="<?= $telegram->first()->link; ?>" target="_blank" class="contacts-faq-item">Сообщение в telegram</a></div>
                        @endif
                        @if($viber->count() > 0)
                        <div class="contact-faq-contact"><a href="<?= $viber->first()->link; ?>" target="_blank" class="contacts-faq-item">Сообщение в viber</a></div>
                        @endif
                        @if($viberMobile->count() > 0)
                        <div class="contact-faq-contact"><a href="<?= $viberMobile->first()->link; ?>" target="_blank" class="contacts-faq-item">Сообщение в viber (для мобильного)</a></div>
                        @endif
                    </div>
                </div>

                <div class="content-column__descr">
                    <div class="content-column__descr-title">Описание</div>
                    <div class="content-column__descr-content">
                    
                    <!-- {{$product->content}} -->
                    <?php echo str_replace(array("\r\n", "\r", "\n"), '<br>', $product->content); ?>
                    <br>
                    <br>
                    <?php
                        $prase = " ";
                        if($product->owner_id == 2){//LOVEBAGS DROP
                            $prase .= " модный аксессуар: ";

                        }
                        if($product->owner_id == 7){//AMMY BABY
                            $prase .= " модную одежду: ";
                        }
                        if($product->owner_id == 8){//Odrop Bezbrend
                            $prase .= " стильную обувь: ";
                        }
                        if($product->owner_id == 9){//Odrop Bezbrend
                            $prase .= " качественную косметику: ";
                        }

                    ?>
                    Вы можете купить <?= $prase; ?><?= mb_convert_case($product->short_title, MB_CASE_LOWER, "UTF-8"); ?> с доставкой по выгодной цене в каталоге "<a href="<?= route('category', ['alias' => $category->alias]); ?>">{{$category->name}}</a>"

                    </div>

                    {{-- AMMY BABY --}}
                    @if($product->owner_id == 7)
                    <br>
                        <p>Также обратите внимание на стильные <a href="{{route('category', ['alias' => 'sumki-zhenskie'])}}">сумочки & аксессуары</a> тренд данного сезона.</p>
                        <div class="row">
                            @foreach( $productService->randomProducts(5, 2) as $extraProduct)
                            <div class="col-2">
                                <a style="" href="{{route('product', ['alias' => $extraProduct->alias])}}">
                                <img class="" style="width: 100%; border-radius: 8%" src='<?= asset("images/products/" . $extraProduct->id. "/middle/" . $extraProduct->imageFirst()->alias); ?>' alt="Нет картинки" >
                                </a>
                            </div>
                            @endforeach
                        </div>
                    @endif

                    {{-- AMMY BABY --}}
                    @if($product->owner_id == 2)
                    <br>
                        <p>Также обратите внимание на трендовую <a href="{{route('category', ['alias' => 'zhenskaya-odezhda'])}}">одежду</a>.</p>
                        <div class="row">
                            @foreach( $productService->randomProducts(5, 7) as $extraProduct)
                            <div class="col-2">
                                <a style="" href="{{route('product', ['alias' => $extraProduct->alias])}}">
                                <img class="" style="width: 100%; border-radius: 8%" src='<?= asset("images/products/" . $extraProduct->id. "/middle/" . $extraProduct->imageFirst()->alias); ?>' alt="Нет картинки" >
                                </a>
                            </div>
                            @endforeach
                        </div>
                    @endif
                </div>

            </section>
        </div>
        
        <div class="col-12">
            <div class="content-column__dostavka">
                <div class="content-column__dostavka-title">
                    <h2>Способы оплаты и доставки этого товара ({{$product->header}}).</h2>
                </div>
                @if($shippingMethods->count() > 0)
                @foreach($shippingMethods as $sm)
                <div class="content-column__dostavka-descr">
                    <h5>{{ $sm->header }}</h5>
                    <!-- <p class="content-column__dostavka-descr-instr"><span>Инструкция</span></p> -->
                    <div class="content-column__dostavka-descr-instr-text">
                        <?= $sm->text; ?>
                    </div>
                </div>
                @endforeach
                @else
                <h5>Уточнить у продавца</h5>
                @endif
                <!-- <div class="content-column__dostavka-descr">
                    <h5>Shafa доставка</h5>
                    
                    <div class="content-column__dostavka-descr-instr-text">
                        Оформить Shafa доставку можно перейдя по данной ссылке <a href="https://shafa.ua/women/aksessuary/ukrasheniya-i-chasy/braslety/108800775-braslet-v-stile-cartier-lemon-s-kamnyami" target="_blank">ОЛХ</a>
                    </div>
                </div>

                <div class="content-column__dostavka-descr">
                    <h5>Новой почтой</h5>
                    
                    <div class="content-column__dostavka-descr-instr-text">
                        По предоплате 150 грн.
                    </div>
                </div> -->

            </div>
        </div>

        <div class="col-lg-10 offset-lg-1 col-md-offset-0 col-sm-12">
        @include('product.products-widget', ['products' => $widget])
        </div>
        
    </div>
    
</div>

@endsection


@section('slider')
<div class="slider-shadow"></div>

<div class="sslider-screen">
    <div class="sslider-screen__items">
        <!-- <img src="/img/products/1.jpg" class="">
        <img src="/img/products/2.jpg" class="fade" style="display:none;"> -->
        <div class="sslider-screen-lc">
            <i class="fa fa-chevron-left" aria-hidden="true"></i>
        </div>
        <div class="sslider-screen-rc">
            <i class="fa fa-chevron-right" aria-hidden="true"></i>
        </div>
        <div class="sslider-screen-close">
            <i class="fa fa-times" aria-hidden="true"></i>
        </div>
    </div>
    
</div>


<!-- Modal -->
<div class="modal fade" id="addMessageModal" tabindex="-1" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">

    <div class="widget-products__content">
        <div class="modal-header">
        @if($product->hasImages())
        <img style="width:60px;padding:5px;" src='<?= asset("images/products/$product->id/middle/{$product->imageFirst()->alias}"); ?>' alt="<?= $product->imageFirst()->alt; ?>" >
        @else
        <img src='<?= asset("images/default/no-photo.jpg"); ?>' alt="Нет картинки" >
        @endif
        <h5>{{$product->short_title}}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        
        
    </div>
    <div class="modal-body">
        @if(Auth::check())
            @if(isAdmin())
                
            <b>Привет, Админ!</b>

            @else

            <form method="post" action="<?= route('modal-chat-message', []); ?>">
                @csrf <!-- add csrf field on your form -->
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Ваше сообщение</label>
                    <textarea name="modal_message" class="form-control" rows="5" id="comment" name="text" required></textarea>
                </div>
                <input name="product_id" type="hidden" value="<?= $product->id; ?>">
                <button type="submit" class="btn btn-primary">Отправить</button>
            </form>

            @endif

        @else
            Чтобы отправлять сообщение, нужно <a href="{{ route('login') }}">авторизироваться</a>
        @endif
        </div>
    </div>
  </div>
</div>
@endsection

