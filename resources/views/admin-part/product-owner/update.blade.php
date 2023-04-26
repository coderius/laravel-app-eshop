<?php
use App\Models\ProductOwner;
$type_select = ProductOwner::flags()['type'];
$status_select = ProductOwner::flags()['status'];
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
        <label for="exampleInputEmail1" class="form-label">name</label>
        <input value="{{$item->name}}" name="name" type="text" class="form-control"  required>
    </div>

    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">type</label>
        <select value="{{$item->type}}" name="type" class="form-select form-select-lg mb-3" aria-label=".form-select-lg example" required>
            @foreach($type_select as $typeSelect => $valueSelect)                        
            <option value="<?= $typeSelect; ?>" >{{$valueSelect}}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">phones</label>
        <input value="{{$item->phones}}" name="phones" type="text" class="form-control">
    </div>

    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">telegram</label>
        <input value="{{$item->telegram}}" name="telegram" type="text" class="form-control"  required>
    </div>

    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">viber</label>
        <input value="{{$item->viber}}" name="viber" type="text" class="form-control">
    </div>

    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">noties</label>
        <textarea name="noties" class="form-control" rows="5" id="comment" name="text" required>{{$item->noties}}</textarea>
        <!-- <input value="{{$item->noties}}" name="noties" type="text" class="form-control"  required> -->
    </div>

    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">status</label>
        <select value="{{$item->status}}" name="status" class="form-select form-select-lg mb-3" aria-label=".form-select-lg example" required>
            @foreach($status_select as $typeSelect => $valueSelect)                        
            <option value="<?= $typeSelect; ?>" >{{$valueSelect}}</option>
            @endforeach
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Submit</button>
</form>

@endsection