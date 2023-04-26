<?php

?>
@extends('layouts.admin-default')

@section('breadcrumbs')
<li class="breadcrumb-item" aria-current="page"><a href="<?= route('admin-'.$idHelper.'-index', []); ?>">{{$nameHelper}}</a></li>
<li class="breadcrumb-item active" aria-current="page">{{$p_title}}</li>
@endsection

@section('content')

<h2>{{$p_title}}</h2>

<form method="post" action="<?= route('admin-'.$idHelper.'-update', ['id' => $item->id]); ?>">
@csrf <!-- add csrf field on your form -->
    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">text</label>
        <input value="{{$item->text}}" name="text" type="text" class="form-control"  required>
    </div>

    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">url</label>
        <input value="{{$item->url}}" name="url" type="text" class="form-control"  required>
    </div>

    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">status</label>
        <input value="{{$item->status}}" name="status" type="text" class="form-control"  required>
    </div>

    <button type="submit" class="btn btn-primary">Submit</button>
</form>

@endsection
