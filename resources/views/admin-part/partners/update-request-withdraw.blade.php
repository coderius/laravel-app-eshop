<?php
use App\Models\Product;
use App\Models\Deals\Orders;
use App\Models\Partner\PartnerRequestWithdraw;
// $product_state_select = Product::flags()['product_state'];
// $in_stock_select = Product::flags()['in_stock'];
$statuses = PartnerRequestWithdraw::flags();

?>
@extends('layouts.admin-default')

@section('breadcrumbs')
<li class="breadcrumb-item" aria-current="page"><a href="<?= route('admin-partners-index', []); ?>">Все партнеры</a></li>
<li class="breadcrumb-item active" aria-current="page">{{$p_title}}</li>
@endsection

@section('content')
<h2>{{$p_title}}</h2>

@push('scripts')



@endpush

<form method="post" enctype="multipart/form-data" action="<?= route('update-request-withdraw', ['id' => $item->id]); ?>">
@csrf <!-- add csrf field on your form -->
    <div class="mb-3">
        <label for="item1" class="form-label">partner_id</label>
        <input type="text" value="<?= $item->partner_id; ?>" name="partner_id" class="form-control" id="item1" required>
        <div class="form-text"></div>
    </div>
    <div class="mb-3">
        <label for="item1" class="form-label">fio</label>
        <input type="text" value="<?= $item->fio; ?>" name="fio" class="form-control" id="item1" required>
        <div class="form-text"></div>
    </div>
    <div class="mb-3">
        <label for="item1" class="form-label">card_num</label>
        <input type="text" value="<?= $item->card_num; ?>" name="card_num" class="form-control" id="item1" required>
    </div>
    <div class="mb-3">
        <label for="item1" class="form-label">status</label>
        <select name="status" class="form-select form-select-lg mb-3" aria-label=".form-select-lg example" required>
            @foreach($statuses as $k => $v)                        
            <option value="<?= $k; ?>" <?= $item->status == $k ? 'selected' : ''; ?> >{{$v}}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label for="item1" class="form-label">amaunt</label>
        <input type="text" value="<?= $item->amaunt; ?>" name="amaunt" class="form-control" id="item1" required>
    </div>
    <div class="mb-3">
        <label for="item1" class="form-label">admin_comments</label>
        <textarea name="admin_comments" class="form-control" rows="5" id="comments" name="text"><?= $item->admin_comments; ?></textarea>
        <div class="form-text">Комментарии админа</div>
    </div>
    
    <button type="submit" class="btn btn-primary">Submit</button>
</form>

@endsection