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


<form method="post" enctype="multipart/form-data" action="<?= route('admin-'.$idHelper.'-update', ['id' => $product->id]); ?>">
@csrf <!-- add csrf field on your form -->
    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">short_title</label>
        <input value="{{$product->short_title}}" id="aliasTranslitFrom" name="short_title" type="text" class="form-control"  required>
    </div>

    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">title</label>
        <input value="{{$product->title}}" name="title" type="text" class="form-control"  required>
    </div>

    <div class="mb-3">
        <p id="aliasTranslit"></p>
        <label for="exampleInputEmail1" class="form-label">alias</label>
        <input value="{{$product->alias}}" name="alias" type="text" class="form-control"  required>
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
        @foreach($product->images()->get() as $image)
        <i class="loadedByController" data-src="<?= asset("images/products/$product->id/middle/$image->alias"); ?>" data-alias="<?= $image->alias; ?>"></i>
        <!-- <div class="upload-image">
            <img src="">
            <input value="{{$image->alias}}" name="imagesInfo[]"  type='hidden'>
        </div> -->
        @endforeach
    </div>
    <!-- image -->
    <br>
    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">price (only number)</label>
        <input value="{{$product->price}}" name="price" type="number" class="form-control"  required>
    </div>


    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">description</label>
        <input value="{{$product->description}}" name="description" type="text" class="form-control"  required>
    </div>

    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">tags</label>
        <input value="{{$product->tags}}" name="tags" type="text" class="form-control"  required>
    </div>

    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">header</label>
        <input value="{{$product->header}}" name="header" type="text" class="form-control"  required>
    </div>

    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">content</label>
        <textarea name="content" class="form-control" rows="10" id="comment" name="text" required>{{$product->content}}</textarea>
    </div>

    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">owner_article</label>
        <input value="{{$product->owner_article}}" name="owner_article" type="text" class="form-control"  required>
    </div>

    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">category_id</label>
        <select value="{{$product->category_id}}" name="category_id" class="form-select form-select-lg mb-3" aria-label=".form-select-lg example" required>
            @foreach($categories as $item)                        
            <option value="<?= $item->id; ?>" <?=$product->category_id == $item->id ? 'selected' : ''; ?>>{{$item->name}}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">brand_id</label>
        <select value="{{$product->brand_id}}" name="brand_id" class="form-select form-select-lg mb-3" aria-label=".form-select-lg example" required>
            @foreach($brands as $item)                        
            <option value="<?= $item->id; ?>" <?=$product->brand_id == $item->id ? 'selected' : ''; ?>>{{$item->name}}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">owner_id</label>
        <select value="{{$product->owner_id}}" name="owner_id" class="form-select form-select-lg mb-3" aria-label=".form-select-lg example" required>
            @foreach($productOwners as $item)                        
            <option value="<?= $item->id; ?>" <?=$product->owner_id == $item->id ? 'selected' : ''; ?>>{{$item->name}}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">product_state</label>
        <select value="{{$product->product_state}}" name="product_state" class="form-select form-select-lg mb-3" aria-label=".form-select-lg example" required>
            @foreach($product_state_select as $typeSelect => $valueSelect)                        
            <option value="<?= $typeSelect; ?>" <?=$product->product_state == $typeSelect ? 'selected' : ''; ?>>{{$valueSelect}}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">in_stock</label>
        <select value="{{$product->in_stock}}" name="in_stock" class="form-select form-select-lg mb-3" aria-label=".form-select-lg example" required>
            @foreach($in_stock_select as $typeSelect => $valueSelect)                        
            <option value="<?= $typeSelect; ?>" <?=$product->in_stock == $typeSelect ? 'selected' : ''; ?>>{{$valueSelect}}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">status</label>
        <select value="{{$product->status}}" name="status" class="form-select form-select-lg mb-3" aria-label=".form-select-lg example" required>
            @foreach($status_select as $typeSelect => $valueSelect)                        
            <option value="<?= $typeSelect; ?>" <?=$product->status == $typeSelect ? 'selected' : ''; ?>>{{$valueSelect}}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">my_noties</label>
        <textarea name="my_noties" class="form-control" rows="5" id="comment" name="text">{{$product->my_noties}}</textarea>
    </div> 


    <button type="submit" class="btn btn-primary">Submit</button>
</form>

@endsection