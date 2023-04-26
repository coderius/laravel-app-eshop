@extends('layouts.default')

<?php //ADD META TAGS HERE ?>
@section('mete_title','Страничка не найдена')
@section('mete_description','Ошибка 404. страница не найдена')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="<?= route('catalog', []); ?>">Каталог</a></li>
    <li class="breadcrumb-item active" aria-current="page">Страница не найдена</li>
@endsection

<?php //dd($product);?>

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <h1>Страница не найдена</h1>
            <div>
                Такой страницы на сайте нет.
                Возможно то, что Вы ищете находится в <a href="<?= route('catalog', []); ?>">каталоге</a>
            </div>
        </div>
    </div>
</div>

@endsection