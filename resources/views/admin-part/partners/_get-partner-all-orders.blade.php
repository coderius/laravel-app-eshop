<?php
use App\Models\Deals\Orders;
?>

@if($result->count() > 0)
@foreach($result as $param)
<h3>Заказ ID {{$param->id}}</h3>
<p>Статус: <b class="{{Orders::statusColor($param->status)}}">{{Orders::statusDescription($param->status)}}</b></p>
<table class="table table-striped td-first-bold">
  <thead>
    <tr>
        <th scope="col">Параметр</th>
        <th scope="col">Значение</th>
    </tr>
    </thead>
    <tbody>
        <tr>
            <td>status</td>
            <td>{{$param->status}}</td>
        </tr>
        <tr>
            <td>product_id</td>
            <td>
                id: {{$param->product_id}}
                <br>
                <a 
                target="_blank" 
                href="{{route('product', ['alias' => $param->product->alias])}}">
                    {{$param->product->title}}
                </a>

            </td>
        </tr>
        <tr>
            <td>partner_id</td>
            <td>{{$param->partner_id}}</td>
        </tr>
        <tr>
            <td>amount</td>
            <td>{{$param->amount}}</td>
        </tr>
        <tr>
            <td>margin</td>
            <td>{{$param->margin}}</td>
        </tr>
        <tr>
            <td>partner_bid</td>
            <td>{{$param->partner_bid}}</td>
        </tr>
        <tr>
            <td>currensy</td>
            <td>{{$param->currensy}}</td>
        </tr>
        <tr>
            <td>comments</td>
            <td>{{$param->comments}}</td>
        </tr>
        <tr>
            <td>admin_noties</td>
            <td>{{$param->admin_noties}}</td>
        </tr>
        <tr>
            <td>created_at</td>
            <td>{{$param->created_at->timezone('Europe/Kiev')->translatedFormat('d M Y H:i ')}}</td>
        </tr>
        <tr>
            <td>updated_at</td>
            <td>{{$param->updated_at->timezone('Europe/Kiev')->translatedFormat('d M Y H:i ')}}</td>
        </tr>

    </tbody>
</table>
@endforeach
@else
<p>У данного партнера заказов еще не было</p>
@endif