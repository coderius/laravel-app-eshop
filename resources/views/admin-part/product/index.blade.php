<?php
use App\Models\Product;
use Illuminate\Support\Str;
?>
@extends('layouts.admin-default')

@section('styles')

@endsection

@section('breadcrumbs')
<li class="breadcrumb-item active" aria-current="page">{{$p_title}}</li>
@endsection

@section('content')
<h2>{{$p_title}} <span>( {{$items->total()}} )</span></h2>

<section>
{{ $items->links() }}
</section>

@push('scripts')
$(function() {
  $('.container-op-cl').css("height", "70px").css("overflow", "hidden");
  $('.op-cl').click(function(e){
    e.preventDefault();
    var bl = $(this).parent('td').find('.container-op-cl');
    if(bl.attr("data-h") !=  "opened"){
      bl.css("overflow-y", "scroll");
      bl.animate({"height":"300px"}, 300);
      bl.attr("data-h", "opened");
      $(this).html("-");
    }else{
      bl.css("overflow", "hidden");
      bl.animate({"height":"70px"}, 300);
      bl.attr("data-h", "closed");
      $(this).html("+");
    }
    
    
  });
  
  var $searchString = $('#search-string').attr('data-search');
  $all = $("td:contains("+$searchString+")");
  $all.css("background-color", "yellow");
  console.log($all);
});


@endpush

<form id="frmSearch" name="frmSearch" role="form" class="was-validated" method="post" action="<?= route('admin-product-index-search', []); ?>">
@csrf
  <div class="row mb-4">
        <div class="col-lg-2 offset-lg-1 text-end">Искать по параметрам...</div>
        <div class="col-lg-2 text-start">
            <select name="param[]" ID="ddlType" Class="form-control rounded" multiple required>
                <!-- <option value="" selected>Search by...</option> -->
                <option value="alias">alias</option>
                <option value="title">title</option>
                <option value="short_title">short_title</option>
                <option value="description">description</option>
                <option value="content">content</option>
                <option value="owner_article">owner_article</option>
            </select>
        </div>
        <div class="col-lg-1 text-center">что ищем ...</div>
        <div class="col-lg-4">
            <input type="text" name="search" ID="tbTerm" class="form-control rounded text-black" required />
        </div>
        <div class="col-lg-1 mx-auto">
            <button type="submit" ID="btnSearch" class="btn-success btn text-white">Search</button>
        </div>
    </div>
</form>

@if($search_header)
<h5 id="search-string" data-search="<?= $data_search; ?>">{{$search_header}}</h5>

<a href="<?= route('admin-'.$idHelper.'-index', []); ?>" type="button" class="btn btn-success">Сбросить поиск</a>
<p></p>
<hr>
<p></p>
<p></p>
@endif



<a href="<?= route('admin-'.$idHelper.'-create', []); ?>" type="button" class="btn btn-primary">Создать новый</a>
<!-- <img class="Adm-image-sm" src='<?= public_path("images/photo_2022-12-18_19-30-46.jpg"); ?>' > -->
<!-- <div class="table-responsive"> -->
<div>
<table class="table table-striped">
  <thead>
    <tr>
        <th scope="col">Кнопки</th>
        <th scope="col">status</th>
        <th scope="col">id</th>
        <th scope="col">img</th>
        <th scope="col">owner_article</th>
        <th scope="col">category_id</th>
        <th scope="col">brand_id</th>
        <th scope="col">owner_id</th>
        <th scope="col">alias</th>
        <th scope="col">price</th>
        <th scope="col">currensy</th>

        <th scope="col">short_title</th>
        <th scope="col">title</th>
        <th scope="col">description</th>
        <th scope="col">tags</th>

        <th scope="col">header</th>
        <th scope="col">content</th>
        <th scope="col">in_stock</th>
        <th scope="col">product_state</th>
        <th scope="col">my_noties</th>
        <th scope="col">created_at</th>
        
    </tr>
    </thead>
    <tbody>
        @foreach($items as $k => $item)
        <tr>
        
            <td>
                <a href="<?= route('admin-'.$idHelper.'-update', ['id' => $item->id]); ?>" type="button" class="btn btn-success btn-sm">Редактировать</a>
                <hr>
                <form method="post" action="<?= route('admin-'.$idHelper.'-delete', ['id' => $item->id]); ?>">
                    @csrf
                    <input class="btn btn-danger btn-sm admin-delete-item" type="submit" name="submit" value="Удалить">
                </form>
            </td>
            <td style="background-color:<?= Product::STATUS_ACTIVE == $item->status ? 'green' : 'red'; ?>"><?= Product::flags()['status'][$item->status]; ?></td>
            <th class="Admin-alert-info text-info" data-k="{{$item->id}}" scope="row">{{$item->id}}</th>
            <td>
              @if($item->imagesCount(null) == 0)
                <i class="text-danger">нет картинок</i></p>
              @endif

              @if($item->imagesCount(1) > 0)
                <img class="Adm-image-sm" src='<?= asset(asset("images/products/" . $item->id. "/middle/" . $item->imageFirst()->alias)); ?>' >
                <p><i class="fa fa-eye text-success" aria-hidden="true"></i>({{$item->imagesCount()}})<br>
                <i class="fa fa-eye text-danger" aria-hidden="true"></i>({{$item->imagesCount(0)}})</p>
              @endif

              @if($item->imagesCount(0) > 0)
                <i class="text-danger">картинки не активны</i></p>
                <p><i class="fa fa-eye text-success" aria-hidden="true"></i>({{$item->imagesCount()}})<br>
                <i class="fa fa-eye text-danger" aria-hidden="true"></i>({{$item->imagesCount(0)}})</p>
              @endif

            </td>
            <td>{{$item->owner_article}}</td>
            <td>{{$item->category()->first()->name}}</td>
            <td>{{$item->brand()->first()->name}}</td>
            <td>{{$item->productOwner()->first()->name}}</td>
            <td>{{$item->alias}}</td>
            <td>{{$item->price}}</td>
            <td>{{$item->currensy}}</td>
            <td>{{$item->short_title}}</td>
            <td>{{$item->title}}</td>
            <td>{{$item->description}}</td>
            <td>{{$item->tags}}</td>
            <td>{{$item->header}}</td>
            <!-- <td><?= Str::limit($item->content, 20, ' (...)'); ?></td> -->
            <td><div class="container-op-cl"><?= $item->content; ?></div><a href="" style="text-decoration: none;font-size:28px;font-weidth:bold;" class="op-cl">+</a></td>
            <td><?= Product::flags()['in_stock'][$item->in_stock]; ?></td>
            <td><?= Product::flags()['product_state'][$item->product_state]; ?></td>
            <td><?= Str::limit($item->my_noties, 20, ' (...)'); ?></td>
            <td>{{$item->created_at}}</td>

        </tr>

        <!-- Alert -->
        <div class="alert-helper alert-helper-{{$item->id}} visually-hidden">
            <ul>
                <li><h3>Картинки</h3>
                <p><b>Active ({{$item->imagesCount(1)}})</b></p>
                @foreach($item->images()->get() as $image)
                <img class="Adm-image-smx" src='<?= asset(asset("images/products/" . $item->id. "/middle/" . $image->alias)); ?>' >
                @endforeach
                <hr>
                <p><b>Desibled ({{$item->imagesCount(0)}})</b></p>
                @foreach($item->images(0)->get() as $image)
                <img class="Adm-image-smx" src='<?= asset(asset("images/products/" . $item->id. "/middle/" . $image->alias)); ?>' >
                @endforeach
                </li>
                <li><h3>Категория</h3>{{$item->category()->first()->name}}</li>
                <li><h3>Бренд</h3>{{$item->brand()->first()->name}}</li>
                <li><h3>Поставщик</h3>{{$item->productOwner()->first()->name}}</li>
                <li><h3>Алиас</h3>{{$item->alias}}</li>
                <li><h3>Прайс</h3>{{$item->price}}</li>
                <li><h3>Валюта</h3>{{$item->currensy}}</li>
                <li><h3>short_title</h3>{{$item->short_title}}</li>
                <li><h3>description</h3>{{$item->description}}</li>
                <li><h3>tags</h3>{{$item->tags}}</li>
                <li><h3>content</h3>{{$item->content}}</li>
                <li><h3>in_stock</h3>{{$item->in_stock}} <?= Product::flags()['in_stock'][$item->in_stock]; ?></li>
                <li><h3>product_state</h3>{{$item->product_state}} <?= Product::flags()['product_state'][$item->product_state]; ?></li>
                <li><h3>my_noties</h3>{{$item->my_noties}}</li>
                <li><h3>status</h3>{{$item->status}} <?= Product::flags()['status'][$item->status]; ?></li>
                <li><h3>created_at</h3>{{$item->created_at}}</li>
            </ul>
        </div>
        <!-- Alert -->
        @endforeach
    </tbody>
</table>
</div>

<section>
{{ $items->links() }}
</section>


<!-- Modal -->
<!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@mdo">Open modal for @mdo</button>
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@fat">Open modal for @fat</button>
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@getbootstrap">Open modal for @getbootstrap</button> -->

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">New message</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <a href="" type="button" class="btn btn-primary">Update</a>
      </div>
    </div>
  </div>
</div>
@endsection