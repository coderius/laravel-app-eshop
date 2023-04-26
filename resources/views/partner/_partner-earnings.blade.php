<?php
// dd($partner->partnerCheck());
?>
<div class="d-flex flex-column align-items-center">
<ul class="list-group list-group-horizontal">
  <li class="list-group-item" style="width: 140px;"><b>Всего заработано</b></li>
  <li class="list-group-item" style="width: 250px;"><span class="text-success">{{$partnerIncreasesSumUAN}}</span></li>
</ul>
<ul class="list-group list-group-horizontal">
  <li class="list-group-item" style="width: 140px;"><b>Выведено средств</b></li>
  <li class="list-group-item" style="width: 250px;"><span class="text-success">{{$partnerWithdrawsSumUAN}}</span></li>
</ul>
<ul class="list-group list-group-horizontal">
  <li class="list-group-item" style="width: 140px"><b>Текущий баланс:</b></li>
  <li class="list-group-item" style="width: 250px;">
  <span class="text-success">
    @if($partnerCheck)
  {{$partnerCheck->balance}} {{$partnerCheck->currency}}.
  @else
  0
  @endif
  </span>
  <br>
  <a href="{{ route('partner-cash-out-form') }}">Вывести</a>
</li>
</ul>

</div>  