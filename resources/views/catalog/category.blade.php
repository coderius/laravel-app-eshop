@extends('layouts.default')

<?php //ADD META TAGS HERE ?>
@section('mete_title'){{$ctgr->title}} Ассортимент {{$stock_title}}(стр.{{$products->currentPage()}}{{$sort_title}})@endsection
@section('mete_description'){{$ctgr->description}} Ассортимент {{$stock_title}}(стр.{{$products->currentPage()}}{{$sort_title}})@endsection

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="<?= route('catalog', []); ?>">Каталог</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{$ctgr->name}}</li>
@endsection

<?php $h1 = $ctgr->name; ?>

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