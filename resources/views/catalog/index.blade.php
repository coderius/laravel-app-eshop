@extends('layouts.default')

<?php //ADD META TAGS HERE ?>
@section('mete_title')Каталог-модные женские сумки,бижутерия,косметика,одежда,ассортимент {{$stock_title}}(стр.{{$products->currentPage()}}{{$sort_title}})@endsection
@section('mete_description')Большой выбор стильных женских сумок, ювелирных изделий, косметики, одежды по выгодным ценам с доставкой в Украине. Ассортимент {{$stock_title}}(стр.{{$products->currentPage()}}{{$sort_title}})@endsection

@section('breadcrumbs')
    <!-- <li class="breadcrumb-item"><a href="<?= route('catalog', []); ?>">Каталог</a></li> -->
    <li class="breadcrumb-item active" aria-current="page">Каталог</li>
@endsection

<?php $h1 = "Все товары"; ?>

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-3 col-md-3 col-sm-12">
            <!--sidebar-->
            @include('catalog._sidebar')

        </div>

        <div class="col-lg-9 col-md-9 col-sm-12">
            <!--content-->
            @include('catalog._content')
        </div>
    </div>
</div>
@endsection