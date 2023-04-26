<?php
use App\Models\ExportProduct;


$product_state_select = ExportProduct::flags()['product_state'];
$in_stock_select = ExportProduct::flags()['in_stock'];
$status_select = ExportProduct::flags()['status'];

?>
@extends('layouts.admin-default')

@section('breadcrumbs')
<li class="breadcrumb-item" aria-current="page"><a href="<?= route('admin-'.$idHelper.'-index', []); ?>">{{$nameHelper}}</a></li>
<li class="breadcrumb-item active" aria-current="page">{{$p_title}}</li>
@endsection

@section('content')
<h2>{{$p_title}}</h2>

<form method="post" enctype="multipart/form-data" action="<?= route('admin-'.$idHelper.'-create', []); ?>">
@csrf <!-- add csrf field on your form -->
    <!-- image -->
    <div class="mb-3">
        <label for="formFileMultiple" class="form-label">Json file</label>
        <input name="json[]" class="form-control" type="file" id="formFileMultiple" required  multiple>
        @error('files')
            <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
        @enderror
    </div>
    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">category_id</label>
        <select name="category_id" class="form-select form-select-lg mb-3" aria-label=".form-select-lg example" required>
            @foreach($categories as $item)                        
            <option value="<?= $item->id; ?>" >{{$item->name}}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">brand_id</label>
        <select name="brand_id" class="form-select form-select-lg mb-3" aria-label=".form-select-lg example" required>
            @foreach($brands as $item)                        
            <option value="<?= $item->id; ?>" >{{$item->name}}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">owner_id</label>
        <select name="owner_id" class="form-select form-select-lg mb-3" aria-label=".form-select-lg example" required>
            @foreach($productOwners as $item)                        
            <option value="<?= $item->id; ?>" >{{$item->name}}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">product_state</label>
        <select name="product_state" class="form-select form-select-lg mb-3" aria-label=".form-select-lg example" required>
            @foreach($product_state_select as $typeSelect => $valueSelect)                        
            <option value="<?= $typeSelect; ?>" >{{$valueSelect}}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">in_stock</label>
        <select name="in_stock" class="form-select form-select-lg mb-3" aria-label=".form-select-lg example" required>
            @foreach($in_stock_select as $typeSelect => $valueSelect)                        
            <option value="<?= $typeSelect; ?>" >{{$valueSelect}}</option>
            @endforeach
        </select>
    </div>

    <!-- <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">status</label>
        <select name="status" class="form-select form-select-lg mb-3" aria-label=".form-select-lg example" required>
            <option value="1" >Перезаписать соответствия</option>
            <option value="2" >Добавить к имеющимся</option>
        </select>
    </div> -->

    <button type="submit" class="btn btn-primary">Submit</button>
</form>

@endsection
