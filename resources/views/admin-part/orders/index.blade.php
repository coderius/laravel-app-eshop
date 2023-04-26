<?php
use App\Models\Brand;
use App\Models\Deals\Orders;

$statusesOrders = Orders::flags()['statuses'];
Carbon\Carbon::setLocale('ua');
$isAdmin = function($id){
    return $id == '1' ? 'admin' : 'user';
};

?>

@extends('layouts.admin-default')

@section('breadcrumbs')
<li class="breadcrumb-item active" aria-current="page">{{$p_title}}</li>
@endsection


@section('content')

<form id="frmSearch" name="frmSearch" role="form" class="was-validated" method="post" action="<?= route('admin-orders-index-search', []); ?>">
@csrf
  <div class="row mb-4">
        <div class="col-lg-2 offset-lg-1 text-end">
            Искать по параметрам...
            <p>
                @foreach($statusesOrders as $k => $v)
                <small>{{$k}} : {{$v}}</small><br>
                @endforeach
            </p>
        </div>
        <div class="col-lg-2 text-start">
            <select name="search-param[]" ID="ddlType" Class="form-control rounded" multiple required>
                <!-- <option value="" selected>Search by...</option> -->
                <option value="product_id">product_id</option>
                <!-- <option value="customer_id">customer_id</option> -->
                <option value="partner_id">partner_id</option>
                <option value="status">status</option>
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

<a href="<?= route('admin-orders-index', []); ?>" type="button" class="btn btn-success">Сбросить поиск</a>
<br><hr><br>

<h3>С выбранными (изменить статус):</h3>
<form method="post" enctype="multipart/form-data" action="<?= route('admin-orders-checkbox-action', []); ?>">
@csrf <!-- add csrf field on your form -->
    <div class="mb-3">
        <select name="checkbox-select-status" class="form-select form-select-lg mb-3" aria-label=".form-select-lg example" required>
            @foreach($statusesOrders as $k => $v)
            <option value="{{$k}}" >{{$v}}</option>
            @endforeach
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

<h2>{{$p_title}} <span>( {{$items->total()}} )</span></h2>

<a href="<?= route('admin-orders-create', []); ?>" type="button" class="btn btn-primary">Создать новый</a>

<table class="table table-striped">
  <thead>
    <tr>
        <th scope="col">
            <input class="form-check-input" type="checkbox" value="" id="checkAllItems">
        </th>
        <th scope="col">id</th>
        <th scope="col">Кнопки</th>
        <th scope="col">product_id</th>
        <th scope="col">customer_id <br> (покупатель)</th>
        <th scope="col">partner_id</th>
        <th scope="col">amount <br> (цена на сайте)</th>
        <th scope="col">margin <br> (моя наценка)</th>
        <th scope="col">partner_bid <br> (партнерские)</th>
        <th scope="col">currensy</th>
        <th scope="col">status</th>
        <th scope="col">comments <br> (покупателя)</th>
        <th scope="col">admin_noties <br> (админа)</th>
        <th scope="col">created_at</th>
        <th scope="col">updated_at</th>
    </tr>
    </thead>
    <tbody>
        @foreach($items as $item)
        <tr>
            <td>
                <input name="ids[]" class="check-ides" type="checkbox" value="<?= $item->id; ?>">
            </td>
            <th scope="row">#{{$item->id}}</th>
            <td>
                <a href="<?= route('admin-orders-update', ['id' => $item->id]); ?>" type="button" class="btn btn-success btn-sm">Редактировать</a>
                <hr>
                <form method="post" action="<?= route('admin-orders-delete', ['id' => $item->id]); ?>">
                    @csrf
                    <input class="btn btn-danger btn-sm admin-delete-item" type="submit" name="submit" value="Удалить">
                </form>
            </td>
            <td>
                id товара: {{$item->product->id}}
                <br>
                title: 
                <a 
                target="_blank" 
                href="{{route('product', ['alias' => $item->product->alias])}}">
                    {{$item->product->title}}
                </a>
            </td>
            <td>
                <?php //Изменил данный блок только на сервере ?>
                <p class="mb-0">id заказа: <?= $item->getCustomer($item->id)->id; ?></p>
                <p class="mb-0"><span class="fw-bold">Дата: </span><?= $item->getCustomer($item->id)->created_at->translatedFormat('d M Y H:i '); ?></p>
                <p class="mb-0"><span class="fw-bold">ФИО: </span><?= $item->getCustomer($item->id)->surname; ?> <?= $item->getCustomer($item->id)->name; ?> <?= $item->getCustomer($item->id)->lastname; ?></p>
                <p class="mb-0"><span class="fw-bold">Область: </span><?= $item->getCustomer($item->id)->region; ?></p>
                <p class="mb-0"><span class="fw-bold">Нас.пункт: </span><?= $item->getCustomer($item->id)->locality; ?></p>
                <p class="mb-0"><span class="fw-bold">Новая почта №: </span><?= $item->getCustomer($item->id)->mail_num; ?></p>
                <p class="mb-0"><span class="fw-bold">Телефон: </span><?= $item->getCustomer($item->id)->phone; ?></p>
                <p class="mb-0"><span class="fw-bold">Email: </span><?= $item->getCustomer($item->id)->email; ?>, 
                <p class="mb-0"><span class="fw-bold">viber: </span><?= $item->getCustomer($item->id)->phone_viber ?? '<i>Не указано</i>' ?></p>
                <p class="mb-0"><span class="fw-bold">telegram: </span><?= $item->getCustomer($item->id)->phone_telegram ?? '<i>Не указано</i>' ?></p>
                <p class="mb-0"><span class="fw-bold">user_id: </span><?= $item->getCustomer($item->id)->user_id ? "<span class='badge bg-success'>" . $isAdmin($item->getCustomer($item->id)->user_id) . ' - ' . $item->getCustomer($item->id)->user_id . "</span>" : '<i>Не установлено</i>'; ?></p>
                <p class="mb-0"><span class="fw-bold">cookie_uid: </span><?= $item->getCustomer($item->id)->cookie_uid ?? '<i>Не установлено</i>'; ?></p>
            </td>
            <td>{{$item->partner_id ? $item->partner->id : "без партнерки"}}</td>
            <td>{{$item->amount}}</td>
            <td>{{$item->margin}}</td>
            <td>{{$item->partner_bid}}</td>
            <td>{{$item->currensy}}</td>
            <td><b class="<?= Orders::statusColor($item->status); ?>">{!! Orders::statusDescription($item->status) !!}</b></td>
            <td>{{$item->comments}}</td>
            <td>{{$item->admin_noties}}</td>
            <td>{{$item->created_at}}</td>
            <td>{{$item->updated_at}}</td>
        </tr>
        @endforeach
    </tbody>
</table>
</form>

<section>
{{ $items->links() }}
</section>

@endsection

@push('scripts')

@endpush