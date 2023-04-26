@if($partnerTransactionsHistory)
<table class="table table-striped">
  <thead>
    <tr>
        <th scope="col">Дата</th>
        <th scope="col">Вид транзакции</th>
        <th scope="col">Примечание</th>
        <th scope="col">Сумма</th>
    </tr>
    </thead>
    <tbody>
      @foreach($partnerTransactionsHistory as $trs)
      <tr>
        <td>{{$trs['data']}}</td>
        <td>{{$trs['type']}}</td>
        <td><?= $trs['info']; ?></td>
        <td>{{$trs['money']}}</td>
      </tr>
      @endforeach
    </tbody>
</table>
@else

<b>Пока транзакции отсутствуют</b>

@endif
    