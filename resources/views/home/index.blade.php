<?php
use Illuminate\Support\Facades\Auth;

?>
@extends('layouts.default')

<?php //ADD META TAGS HERE ?>
@section('mete_title','Интернет-магазин стильной женской одежды,обуви,сумок и бижутерии по выгодным ценам')
@section('mete_description','Интернет-магазин женской сезонной одежды, обуви ,сумочек, ювелирных украшений и различных аксессуаров в Украине по доступным ценам.')

@section('breadcrumbs')
    <!-- <li class="breadcrumb-item active" aria-current="page">Контакты</li> -->
@endsection

<?php //echo Auth::id(); ?>

@section('content')

@if($categories->count() > 0)
<section class="widget-categories sect-margin">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="alert alert-warning" role="alert">
                    <h1 style="font-size: 18px;font-style:italic;"><strong style="font-size: 22px;">elecci</strong> - женские сумочки, одежда, обувь, качественная бижутерия премиум класса.</h1>
                    <p>В продаже всегда только качественные и модные товары для женщин: сумочки и рюкзаки, стильная одежда на все сезоны, качественная женская обувь, 
                        а также бижутерия премиум класса. Добро пожаловать в магазин Elecci !
                    </p>
                </div>
            </div>
            <div class="col-12">
                <div class="widget-categories__title">
                    <span>Категории товаров</span>
                </div>
            </div>
            @if($categories->count() < 3)
              
            @endif
            <?php
                $lg = $categories->count() < 5 ? 3 : 4;
                $md = $categories->count() < 5 ? 3 : 4;
            ?>
            @foreach($categories as $category)
            <div class="col-lg-<?= $lg; ?> col-md-<?= $md; ?> col-sm-6 col-xs-6">
                <div class="widget-categories__item">

                    <div class="widget-categories__wrap">
                        <div class="widget-categories__content">
                            <img src='<?= asset("images/categories/{$category->src}"); ?>' alt="<?= $category->title . " фото";?>" >
                        </div>
                    </div>

                    <div class="widget-categories__item-title">
                        <span>{{$category->name}}</span>
                    </div>

                    <div class="widget-categories__info">
                        @if($category->categoriesByLevel()->count() > 0)
                            <ul>
                            @foreach($category->categoriesByLevel() as $sub)
                                <li><a href="<?= route('category', ['alias' => $sub->alias]); ?>">{{$sub->name}}</a></li>
                            @endforeach
                            </ul>
                        @endif
                    </div>
                    
                </div> 
            </div>
            @endforeach
            
            
        </div>
    </div>
</section>
@endif

<!--Newest products section-->
@include('widgets.products-widget', ['products' => $newProducts, 'section_header' => "Новинки", "style" => false])

<!--Top sail products section-->
@include('widgets.products-widget', ['products' => $randomProducts, 'section_header' => "Топ продаж", "style" => "orange"])

@endsection