<?php
use App\Models\ProductOwner;

?>
@extends('layouts.admin-default')

@section('breadcrumbs')
<li class="breadcrumb-item active" aria-current="page">{{$p_title}}</li>
@endsection

@section('content')
<h2>{{$p_title}} <span>( {{$items->total()}} )</span></h2>

<a href="<?= route('admin-'.$idHelper.'-create', []); ?>" type="button" class="btn btn-primary">Создать новый</a>

<table class="table table-striped">
  <thead>
    <tr>
        <th scope="col">id</th>
        <th scope="col">name</th>
        <th scope="col">type</th>
        <th scope="col">phones</th>
        <th scope="col">telegram</th>
        <th scope="col">viber</th>
        <th scope="col">noties</th>
        <th scope="col">status</th>
        <th scope="col">Кнопки</th>
    </tr>
    </thead>
    <tbody>
        @foreach($items as $item)
        <tr>
            <th scope="row">{{$item->id}}</th>
            <td>{{$item->name}}</td>
            <td><?= ProductOwner::flags()['type'][$item->type]; ?></td>
            <td>{{$item->phones}}</td>
            <td>{{$item->telegram}}</td>
            <td>{{$item->viber}}</td>
            <td>{{$item->noties}}</td>
            <td><?= ProductOwner::flags()['status'][$item->status]; ?></td>
            
            <td>
                <a href="<?= route('admin-'.$idHelper.'-update', ['id' => $item->id]); ?>" type="button" class="btn btn-success btn-sm">Редактировать</a>
                <hr>
                <form method="post" action="<?= route('admin-'.$idHelper.'-delete', ['id' => $item->id]); ?>">
                    @csrf
                    <input class="btn btn-danger btn-sm admin-delete-item" type="submit" name="submit" value="Удалить">
                </form>
            </td>

        </tr>
        @endforeach
    </tbody>
</table>

<section>
{{ $items->links() }}
</section>

@endsection