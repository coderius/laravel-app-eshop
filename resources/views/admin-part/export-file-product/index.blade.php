<?php
use App\Models\Product;
use Illuminate\Support\Str;

$alert = session('message');
echo "APP_DEBUG-". env('APP_DEBUG');
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

<a href="<?= route('admin-'.$idHelper.'-create', []); ?>" type="button" class="btn btn-primary">Создать новый</a>
<!-- <img class="Adm-image-sm" src='<?= public_path("images/photo_2022-12-18_19-30-46.jpg"); ?>' > -->
<!-- <div class="table-responsive"> -->
<div>

<hr>
<h3>С выбранными:</h3>
<form method="post" enctype="multipart/form-data" action="<?= route('admin-'.$idHelper.'-checkbox-action', []); ?>">
@csrf <!-- add csrf field on your form -->
    <div class="mb-3">
        <select name="checkbox-select" class="form-select form-select-lg mb-3" aria-label=".form-select-lg example" required>
            <option value="1" >Разместить в продуктах</option>
            <option value="2" >Удалить</option>
            <option value="3" >Сделать статус desibled</option>
            <option value="4" >Сделать статус enabled</option>
        </select>
    </div>
    <!-- <input name="ids[]" class="form-control" type="hidden"> -->
    <button onclick="confirm('Подтвердить действие')" type="submit" class="btn btn-primary">Применить</button>
    <p>Выбрано: <span id="count_select"></span></p>
@if(\Session::has('alert'))
<hr>
<div class="alert alert-primary" role="alert">
{!! \Session::get('alert') !!}
</div>
@endif



@push('scripts')

$("#count_select").html("0");
$("#checkAllItems").change(function(e){
    if(this.checked) {
       $(".check-ides").each(function(ind, elem){
            $(this).prop('checked', true);
            $("#count_select").html(ind+1);
       });
    }else{
        $(".check-ides").each(function(ind, elem){
            $(this).prop('checked', false);
            $("#count_select").html(0);
       });
    }
    
});

@endpush

<hr>

<table class="table table-striped">
  <thead>
    <tr>
        <th scope="col">
        <input class="form-check-input" type="checkbox" value="" id="checkAllItems">
        </th>
        <th scope="col">Кнопки</th>
        <th scope="col">status</th>
        <th scope="col">id</th>
        <!-- <th scope="col">img</th> -->
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
                <input name="ids[]" class="check-ides" type="checkbox" value="<?= $item->id; ?>">
            </td>
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
            <td><?= Str::limit($item->content, 20, ' (...)'); ?></td>
            <td><?= Product::flags()['in_stock'][$item->in_stock]; ?></td>
            <td><?= Product::flags()['product_state'][$item->product_state]; ?></td>
            <td><?= Str::limit($item->my_noties, 20, ' (...)'); ?></td>
            <td>{{$item->created_at}}</td>

        </tr>

        <!-- Alert -->
        <div class="alert-helper alert-helper-{{$item->id}} visually-hidden">
            <ul>
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
</form>
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