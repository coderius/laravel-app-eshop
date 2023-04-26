@extends('layouts.default')

<?php //ADD META TAGS HERE ?>
@section('mete_title','{{$brand->title}}')
@section('mete_description','{{$brand->description}}')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="<?= route('catalog', []); ?>">Каталог</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{$brand->name}}</li>
@endsection

<?php //dd($product);?>

@section('content')
<h1>{{$brand->title}}</h1>

@endsection