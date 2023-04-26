<?php
Carbon\Carbon::setLocale('ua');
use App\Services\PartnersService;
use App\Models\Partner\PartnerRequestWithdraw;

?>

<h3>{{$status}}</h3>
<table class="table table-striped">
    <thead>
        <tr>
            <th scope="col">id запроса</th>
            <th scope="col">Статус</th>
            <th scope="col">Данные</th>
            <th scope="col">Комменты админа</th>
            <th scope="col">Дата</th>
            <th scope="col">Кнопки</th>
        </tr>
    </thead>
    <tbody>
        @foreach($items as $item)
        <tr>
            <td><span>{{$item->id}}</span></td>
            <td><span>{{PartnerRequestWithdraw::getStatusName($item->status)}}</span></td>
            <td>
                <b>Партнер ID:</b> <span>{{$item->partner_id}}</span><br>
                <b>ФИО:</b> <span>{{$item->fio}}</span><br>
                <b>Номер карточки:</b> <span>{{$item->card_num}}</span><br>
                <b>Сумма:</b> <span>{{$item->amaunt}} грн.</span><br>
            </td>
            <td>
                {{$item->admin_comments}}
            </td>
            <td>
                <b>created_at:</b> {{$item->created_at->timezone('Europe/Kiev')->translatedFormat('d M Y H:i ')}}<br>
                <b>updated_at:</b> {{$item->updated_at->timezone('Europe/Kiev')->translatedFormat('d M Y H:i ')}}
            </td>
            <td>
                <a href="<?= route('update-request-withdraw', ['id' => $item->id]); ?>" type="button" class="btn btn-success btn-sm">Редактировать</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>    