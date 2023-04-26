<?php
use App\Models\Product;
use App\Models\Deals\Orders;

// $product_state_select = Product::flags()['product_state'];
// $in_stock_select = Product::flags()['in_stock'];
$statusesOrders = Orders::flags()['statuses'];

?>
@extends('layouts.admin-default')

@section('breadcrumbs')
<li class="breadcrumb-item" aria-current="page"><a href="<?= route('admin-orders-index', []); ?>">Все заказы</a></li>
<li class="breadcrumb-item active" aria-current="page">{{$p_title}}</li>
@endsection

@section('content')
<h2>{{$p_title}}</h2>

@push('scripts')



@endpush

<form method="post" enctype="multipart/form-data" action="<?= route('admin-orders-update', ['id' => $item->id]); ?>">
@csrf <!-- add csrf field on your form -->
    <div class="mb-3">
        <label for="item1" class="form-label"><b class="text-danger">*</b> Ваша фамилия</label>
        <input type="text" value="<?= $item->getCustomer($item->id)->surname; ?>" name="surname" class="form-control" id="item1" required>
        <div class="form-text"></div>
        @error('surname')
        <span class="text-danger"><strong>{{$message}}</strong></span>
        @enderror
    </div>
    <div class="mb-3">
        <label for="item1" class="form-label"><b class="text-danger">*</b> Ваше имя</label>
        <input type="text" value="<?= $item->getCustomer($item->id)->name; ?>" name="name" class="form-control" id="item1" required>
        <div class="form-text"></div>
        @error('name')
        <span class="text-danger"><strong>{{$message}}</strong></span>
        @enderror
    </div>
    <div class="mb-3">
        <label for="item1" class="form-label"><b class="text-danger">*</b> Ваше отчество</label>
        <input type="text" value="{{ old('lastname') }}" name="lastname" class="form-control" id="item1">
        <div class="form-text"></div>
        @error('lastname')
        <span class="text-danger"><strong>{{$message}}</strong></span>
        @enderror
    </div>
    <div class="mb-3">
        <label for="item1" class="form-label"><b class="text-danger">*</b> Область</label>
        <input type="text" value="<?= $item->getCustomer($item->id)->region; ?>" name="region" class="form-control" id="item1" required>
        <div class="form-text">Например, Киевская обл.</div>
        @error('region')
        <span class="text-danger"><strong>{{$message}}</strong></span>
        @enderror
    </div>
    <div class="mb-3">
        <label for="item1" class="form-label"><b class="text-danger">*</b> Город, населенный пункт</label>
        <input type="text" value="<?= $item->getCustomer($item->id)->locality; ?>" name="locality" class="form-control" id="item1" required>
        <div class="form-text">Например, г.Киев</div>
        @error('locality')
        <span class="text-danger"><strong>{{$message}}</strong></span>
        @enderror
    </div>
    <div class="mb-3">
        <label for="item1" class="form-label"><b class="text-danger">*</b> № отделения Новой Почты</label>
        <input type="text" value="<?= $item->getCustomer($item->id)->mail_num; ?>" name="mail_num" class="form-control" id="item1" required>
        <div class="form-text">Например, 5</div>
        @error('locality')
        <span class="text-danger"><strong>{{$message}}</strong></span>
        @enderror
    </div>
    <div class="mb-3">
        <label for="item1" class="form-label"><b class="text-danger">*</b> Телефон</label>
        <input type="tel" value="<?= $item->getCustomer($item->id)->phone; ?>" name="phone" pattern="\+[1-9]{1}8[0-9]{10}" class="form-control" id="item1" required>
        <div class="form-text">Введите телефон в формате +380991230087</div>
        @error('phone')
        <span class="text-danger"><strong>{{$message}}</strong></span>
        @enderror
    </div>
    <div class="mb-3">
        <label for="item1" class="form-label"><b class="text-danger">*</b> Email</label>
        <input type="email" value="<?= $item->getCustomer($item->id)->email; ?>" name="email" pattern="[^@\s]+@[^@\s]+\.[^@\s]+" title="Не верный формат email" class="form-control" id="item1" required>
        <div class="form-text">youremail@gmail.com</div>
        @error('email')
        <span class="text-danger"><strong>{{$message}}</strong></span>
        @enderror
    </div>
    <div class="mb-3">
        <label for="item1" class="form-label">Телефон на котором Viber</label>
        <input type="tel" value="<?= $item->getCustomer($item->id)->phone_viber; ?>" name="phone_viber" pattern="\+[1-9]{1}8[0-9]{10}" class="form-control" id="item1" placeholder="Свяжемся с Вами в чате">
        <div class="form-text">Введите телефон в формате +380991230087</div>
    </div>
    <div class="mb-3">
        <label for="item1" class="form-label">Телефон на котором Telegram</label>
        <input type="tel" value="<?= $item->getCustomer($item->id)->phone_telegram; ?>" name="phone_telegram" pattern="\+[1-9]{1}8[0-9]{10}" class="form-control" id="item1" placeholder="Свяжемся с Вами в чате">
        <div class="form-text">Введите телефон в формате +380991230087</div>
    </div>
    <div class="mb-3">
        <label for="item1" class="form-label">Комментарии покупателя</label>
        <textarea name="comments" class="form-control" rows="5" id="comments" name="text"><?= $item->comments; ?></textarea>
        <div class="form-text">Комментарии покупателя к заказу</div>
    </div>
<hr>
    <div class="mb-3">
        <label for="item1" class="form-label">product_id</label>
        <input type="text" value="<?= $item->product_id; ?>" name="product_id" class="form-control" id="item1" required>
        <div class="form-text">product_id</div>
    </div>

    <div class="mb-3">
        <label for="item1" class="form-label">partner_id</label>
        <input type="text" value="<?= $item->partner_id; ?>" name="partner_id" class="form-control" id="item1">
        <div class="form-text">partner_id</div>
    </div>

    <div class="mb-3">
        <label for="item1" class="form-label">amount</label>
        <input type="text" value="<?= $item->amount; ?>" name="amount" class="form-control" id="item1" required>
        <div class="form-text">Полная стоимость с наценкой</div>
    </div>

    <div class="mb-3">
        <label for="item1" class="form-label">margin</label>
        <input type="text" value="<?= $item->margin; ?>" name="margin" class="form-control" id="item1" required>
        <div class="form-text">наценка</div>
    </div>

    <div class="mb-3">
        <label for="item1" class="form-label">partner_bid</label>
        <input type="text" value="<?= $item->partner_bid; ?>" name="partner_bid" class="form-control" id="item1">
        <div class="form-text">Партнерская ставка</div>
    </div>

    <div class="mb-3">
        <label for="item1" class="form-label">currensy</label>
        <select name="currensy" class="form-select form-select-lg mb-3" aria-label=".form-select-lg example" required>
            <option value="грн" <?= $item->currensy == 'грн' ? 'selected' : ''; ?>>грн</option>
        </select>
        <div class="form-text">Валюта</div>
    </div>

    <div class="mb-3">
        <label for="item1" class="form-label">status</label>
        <select name="status" class="form-select form-select-lg mb-3" aria-label=".form-select-lg example" required>
            @foreach($statusesOrders as $k => $v)                        
            <option value="<?= $k; ?>" <?= $item->status == $k ? 'selected' : ''; ?> >{{$v}}</option>
            @endforeach
        </select>
        <div class="form-text">Статус заказа</div>
    </div>
    
    <div class="mb-3">
        <label for="item1" class="form-label">admin_noties</label>
        <textarea name="admin_noties" class="form-control" rows="5" id="comments" name="text"><?= $item->admin_noties; ?></textarea>
        <div class="form-text">Комментарии админа к заказу</div>
    </div>
    
    <button type="submit" class="btn btn-primary">Submit</button>
</form>

@endsection
