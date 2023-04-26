@extends('layouts.default')
<?php
use App\Services\LikeService;

$app = app();
$likeService = $app->make(LikeService::class);
// dd($list);
?>

<?php //ADD META TAGS HERE ?>
@section('mete_title')Сохраненные товары (стр.{{$list ? $list->currentPage() : 1}})@endsection
@section('mete_description')Тут показаны Ваши сохраненные товары (стр.{{$list ? $list->currentPage() : 1}})@endsection

@section('breadcrumbs')
    <li class="breadcrumb-item active" aria-current="page">Сохраненные товары</li>
@endsection

<?php $h1 = "Все сохраненные товары"; ?>

@section('content')

<section class="widget-products sect-margin">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="widget-products__title">
                    <span>{{$h1}}</span>
                </div>
            </div>
            @if($list)
            @foreach($list as $l)
            <div class="col-lg-2 col-md-4 col-sm-6 col-xs-6">
                <div class="widget-products__item wishlist-opacity">

                    <div class="widget-products__wrap">
                        <div class="widget-products__item-title">
                            <span>{{$l->product()->first()->short_title}}</span>
                        </div>

                        <div class="widget-products__content">
                        @if($l->product()->first()->hasImages())
                        <?php //dd($l->product()->first()->images()->where('status', 1)->first()->alias); ?>
                        <img src='<?= asset("images/products/{$l->product()->first()->id}/middle/{$l->product()->first()->imageFirst()->alias}"); ?>' alt="<?= $l->product()->first()->imageFirst()->alt; ?>" >
                        @else
                        <img src='<?= asset("images/default/no-photo.jpg"); ?>' alt="Нет картинки" >
                        @endif
                        </div>
                    </div>
                    <div class="widget-categories__info">
                    <a href="<?= route('category', ['alias' => $l->product()->first()->category()->first()->alias]); ?>" ><small>{{$l->product()->first()->category()->first()->name}}</small></a>
                    </div>
                    <div class="widget-products__tax">
                        <span>{{$l->product()->first()->price}} {{$l->product()->first()->currensy}}.</span>
                        <div class="widget-products__action-favorite">
                            <i class="fa <?= $likeService->isProductLiked($l->product()->first()->id) ? "fa-heart" : "fa-heart-o"; ?> like-btn" data-prod-id="<?= $l->product()->first()->id; ?>" data-like-route="<?= route('like', []); ?>"></i>
                        </div>
                    </div>

                    <div class="widget-products__info">
                        <a type="button" class="btn btn-primary button-radius-25 hover-color-dark" href="<?= route('product', ['alias' => $l->product()->first()->alias]); ?>">Подробнее</a>
                    </div>
                    <div class="widget-products__info">
                        <a type="button" class="btn btn-outline-success button-radius-25" href="<?= route('making-checkout', ['id' => $l->product()->first()->id]); ?>">Купить</a>
                    </div>
                </div> 
            </div>
            @endforeach
            @else
            <h5 style="text-align: center; margin:20px 0 ">Пока тут ничего нет...</h5>
            @endif
        </div>
    </div>
</section>




        
@if($list)
<div class="pagination-wrap">
    <div class="container">
        <div class="row">
            <div class="col-12">
            {{ $list->links() }}
                <!-- <nav aria-label="...">
                    <ul class="pagination">
                        <li class="page-item disabled">
                            <span class="page-link">Previous</span>
                        </li>
                        <li class="page-item"><a class="page-link" href="#">1</a></li>
                        <li class="page-item active" aria-current="page">
                            <span class="page-link">2</span>
                        </li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                            <a class="page-link" href="#">Next</a>
                        </li>
                    </ul>
                </nav> -->
            </div>
        </div>
    </div>
</div>    
@endif           
            



@endsection