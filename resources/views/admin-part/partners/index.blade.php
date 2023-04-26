<?php
use App\Models\Brand;
use App\Services\OrdersService;
use App\Models\Partner\PartnerRequestWithdraw;

Carbon\Carbon::setLocale('ua');
use App\Services\PartnersService;
?>
@extends('layouts.admin-default')

@section('breadcrumbs')
<li class="breadcrumb-item active" aria-current="page">{{$p_title}}</li>
@endsection

@section('content')
<h2>{{$p_title}} <span>( {{$items->total()}} )</span></h2>
<p>Баланс общий для выплат: <b class="badge bg-info text-dark"><?= PartnersService::allPartnerCheckBalances() ?></b></p>

<!-- <a href="<?= route('admin-brand-create', []); ?>" type="button" class="btn btn-primary">Создать новый</a> -->

<table class="table table-striped">
  <thead>
    <tr>
        <th scope="col">id</th>
        <th scope="col">Рег. данные</th>
        <th scope="col">Счет</th>
        <th scope="col">Заказы</th><!-- Тут будет информация обо всех заказах у данного партнера. Со всеми статусами. А также информация о перечислении денег на внутренний счет -->
        <!-- Не плохо было бы сделать оповещение на телеграм по боту о поступлении денег -->
    </tr>
    </thead>
    <tbody>
        @foreach($items as $item)
        <tr>
            <th scope="row">{{$item->id}}</th>
            <td>
                <b>user_id:</b> {{$item->user_id}}
                <br>
                <b>login:</b> {{$item->login}}
                <br>
                <b>email:</b> {{$item->email}}
                <br>
                <b>email_verified_at:</b> {{$item->email_verified_at}}
                <br>
                <b>created_at:</b> {{$item->created_at->timezone('Europe/Kiev')->translatedFormat('d M Y H:i ')}}
                <br>
                <b>updated_at:</b> {{$item->updated_at->timezone('Europe/Kiev')->translatedFormat('d M Y H:i ')}}
                <br>
                <b>phone:</b> {{$item->phone}}
                <br>
                <b>telegram_phone:</b> {{$item->telegram_phone}}
                <br>
                <b>viber_phone:</b> {{$item->viber_phone}}
            </td>
            </td>
            <td>
                Всего заработано: <?= PartnersService::partnerIncreasesSumUAN($item->increases) ?>
                <br>
                Выведено: <?= PartnersService::partnerWithdrawsSumUAN($item->withdraws) ?>
                <br>
                Доступно: <b><?= PartnersService::partnerCheckBalance($item); ?></b>
                <hr>
                Запросы на вывод: 
                <ul>
                    <li>
                        <i>Новые:</i>
                        <?php if(PartnersService::getPartnerRequestWithdraw($item->id, [PartnerRequestWithdraw::NEW])): ?>
                        <a href="<?= route('request-withdraw-info', ["partnerId" => $item->id, 'status' => PartnerRequestWithdraw::NEW]); ?>" class="request-withdraw-link badge bg-primary"><?= PartnersService::countPartnerRequestWithdraw($item->id, [PartnerRequestWithdraw::NEW]); ?></a>
                        <?php else: ?>
                        <span class="badge bg-secondary">Нет</span>
                        <?php endif; ?>
                    </li>
                    <li>
                        <i>Подтвержденные <small>(после беседы с партнером)</small>:</i>
                        <?php if(PartnersService::getPartnerRequestWithdraw($item->id, [PartnerRequestWithdraw::CONFIRMED])): ?>
                        <a href="<?= route('request-withdraw-info', ["partnerId" => $item->id, 'status' => PartnerRequestWithdraw::CONFIRMED]); ?>" class="request-withdraw-link badge bg-success"><?= PartnersService::countPartnerRequestWithdraw($item->id, [PartnerRequestWithdraw::CONFIRMED]); ?></a>
                        <?php else: ?>
                        <span class="badge bg-secondary">Нет</span>
                        <?php endif; ?>
                    </li>
                    <li>
                        <i>Выполненные:</i>
                        <?php if(PartnersService::getPartnerRequestWithdraw($item->id, [PartnerRequestWithdraw::SUCCESSED])): ?>
                        <a href="<?= route('request-withdraw-info', ["partnerId" => $item->id, 'status' => PartnerRequestWithdraw::SUCCESSED]); ?>" class="request-withdraw-link badge bg-info"><?= PartnersService::countPartnerRequestWithdraw($item->id, [PartnerRequestWithdraw::SUCCESSED]); ?></a>
                        <?php else: ?>
                        <span class="badge bg-secondary">Нет</span>
                        <?php endif; ?>
                    </li>
                    <li>
                        <i>Откланенные:</i>
                        <?php if(PartnersService::getPartnerRequestWithdraw($item->id, [PartnerRequestWithdraw::DISMISSED])): ?>
                        <a href="<?= route('request-withdraw-info', ["partnerId" => $item->id, 'status' => PartnerRequestWithdraw::DISMISSED]); ?>" class="request-withdraw-link badge bg-danger"><?= PartnersService::countPartnerRequestWithdraw($item->id, [PartnerRequestWithdraw::DISMISSED]); ?></a>
                        <?php else: ?>
                        <span class="badge bg-secondary">Нет</span>
                        <?php endif; ?>
                    </li>
                    <li>
                        <i>Все:</i>
                        <?php if(PartnersService::countPartnerRequestWithdraw($item->id)): ?>
                        <a href="<?= route('request-withdraw-info', ["partnerId" => $item->id, 'status' => 0]); ?>" class="request-withdraw-link badge bg-light text-dark"><?= PartnersService::countPartnerRequestWithdraw($item->id); ?></a>
                        <?php else: ?>
                        <span class="">0</span>
                        <?php endif; ?>
                        
                    </li>
                </ul>    
                <hr>
                История платежей: <a href="<?= route('get-partner-transactions-info', ["partnerId" => $item->id]); ?>" class="get-partner-transactions-info" class=""><?= PartnersService::partnerTransactionsCount($item->increases, $item->withdraws) ?></a>
                <br>
            </td>
            <td>
                <!-- Те заказы, которые зарегестрированы, но еще не завершены -->
                Текущие (по статусам): <a href="<?= route('get-partner-active-orders', ["partnerId" => $item->id]); ?>" class="get-active-orders-info"><?= OrdersService::partnerOrdersActiveCount($item); ?></a>
                <br>
                <!-- Все заказы, которые зарегестрированы за партнером -->
                Все (со статусами): <a href="<?= route('get-partner-all-orders', ["partnerId" => $item->id]); ?>" class="get-all-orders-info"><?= OrdersService::partnerOrdersCount($item); ?></a>
                <br>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<section>
{{ $items->links() }}
</section>

<!-- Modal Запрос на вывод -->
 <div class="modal fade" id="infoModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" style="max-width: 90%;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Запрос на вывод денег</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

@endsection

@push('scripts')

var modalWindow = $("#infoModal");
var modalTitle = $("#infoModal").find('.modal-title');
var modalBody = $("#infoModal").find('.modal-body');

$(".get-active-orders-info").click(function(e){
    e.preventDefault();
    var route = $(this).attr("href");
    
    $.ajax({
        type: 'GET',
        url: route,
        //data: { prodId: prodId },
    }).done(function (view) {
        modalTitle.html('Активные заказы');
        modalBody.html(view);
        modalWindow.modal('show');

    })
    .fail(function (e) {
        console.log(e)
    });
    
});

$(".get-all-orders-info").click(function(e){
    e.preventDefault();
    var route = $(this).attr("href");
    
    $.ajax({
        type: 'GET',
        url: route,
        //data: { prodId: prodId },
    }).done(function (view) {
        modalTitle.html('Активные заказы');
        modalBody.html(view);
        modalWindow.modal('show');

    })
    .fail(function (e) {
        console.log(e)
    });
    
});

$(".get-partner-transactions-info").click(function(e){
    e.preventDefault();
    var route = $(this).attr("href");
    
    $.ajax({
        type: 'GET',
        url: route,
    }).done(function (view) {
        modalTitle.html('Все транзакции партнера');
        modalBody.html(view);
        modalWindow.modal('show');

    })
    .fail(function (e) {
        console.log(e)
    });
    
});

$(".request-withdraw-link").click(function(e){
    e.preventDefault();
    var route = $(this).attr("href");
    
    $.ajax({
        type: 'GET',
        url: route,
    }).done(function (view) {
        modalTitle.html('Запросы на вывод денег');
        modalBody.html(view);
        modalWindow.modal('show');

    })
    .fail(function (e) {
        console.log(e)
    });
    
});

@endpush