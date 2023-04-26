<?php
use App\Models\Product;


$product_state_select = Product::flags()['product_state'];
$in_stock_select = Product::flags()['in_stock'];
$status_select = Product::flags()['status'];

?>
@extends('layouts.admin-default')

@section('breadcrumbs')
<li class="breadcrumb-item" aria-current="page"><a href="<?= route('admin-'.$idHelper.'-index', []); ?>">{{$nameHelper}}</a></li>
<li class="breadcrumb-item active" aria-current="page">{{$p_title}}</li>
@endsection

@section('content')
<h2>{{$p_title}}</h2>

@push('scripts')

aliasAutoPast( $(".from1"), $(".to1") );
textAutoPast( $(".textAutoPastFrom1"), $(".textAutoPastTo1") );
textAutoPast( $(".textAutoPastFrom2"), $(".textAutoPastTo2") );

@endpush



<form method="post" enctype="multipart/form-data" action="<?= route('admin-'.$idHelper.'-create', []); ?>">
@csrf <!-- add csrf field on your form -->
    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">short_title</label>
        <input id="aliasTranslitFrom" name="short_title" type="text" class="form-control from1 textAutoPastFrom2"  required>
    </div>

    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">title</label>
        <input name="title" type="text" class="form-control textAutoPastFrom1"  required>
    </div>

    <div class="mb-3">
        <p id="aliasTranslit"></p>
        <label for="exampleInputEmail1" class="form-label">alias</label>
        <input name="alias" type="text" class="form-control to1"  required>
    </div>

    <!-- image -->
    <div class="mb-3">
        <label for="formFileMultiple" class="form-label">Images</label>
        <input name="images[]" class="form-control" type="file" id="formFileMultiple" accept="image/*"  multiple>
        @error('files')
            <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
        @enderror
    </div>
    <div id="sortable" class="upload-images">
        <!-- <div class="upload-image">
            <img src="<?= asset("images/default/no-photo.jpg"); ?>">
            <div class="upload-images__icons">
                <i class="fa fa-trash" aria-hidden="true"></i>
            </div>
        </div> -->

    </div>
    <!-- image -->
    <br>
    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">price (only number)</label>
        <input name="price" type="number" class="form-control"  required>
    </div>


    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">description</label>
        <input name="description" type="text" class="form-control textAutoPastTo1"  required>
    </div>

    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">tags</label>
        <input name="tags" type="text" class="form-control"  required>
    </div>

    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">header</label>
        <input name="header" type="text" class="form-control textAutoPastTo2"  required>
    </div>

    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">content</label>
        <textarea name="content" class="form-control" rows="10" id="comment" name="text" required></textarea>
    </div>

    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">owner_article</label>
        <input name="owner_article" type="text" class="form-control"  required>
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

    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">status</label>
        <select name="status" class="form-select form-select-lg mb-3" aria-label=".form-select-lg example" required>
            @foreach($status_select as $typeSelect => $valueSelect)                        
            <option value="<?= $typeSelect; ?>" >{{$valueSelect}}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">my_noties</label>
        <textarea name="my_noties" class="form-control" rows="5" id="comment" name="text"></textarea>
    </div> 


    <button type="submit" class="btn btn-primary">Submit</button>
</form>

@endsection
