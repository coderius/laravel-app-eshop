@extends('layouts.default')

@section('mete_title')
{{$category->title}}
@endsection

@section('mete_description')
{{$category->description}}
@endsection

@section('breadcrumbs')
    <li class="breadcrumb-item active" aria-current="page">{{$category->title}}</li>
@endsection

<?php //dd($product);?>

@section('content')
<h1>{{$category->title}}</h1>

@endsection