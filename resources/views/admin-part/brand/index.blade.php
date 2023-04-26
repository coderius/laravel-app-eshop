<?php
use App\Models\Brand;
?>
@extends('layouts.admin-default')

@section('breadcrumbs')
<li class="breadcrumb-item active" aria-current="page">{{$p_title}}</li>
@endsection

@section('content')
<h2>{{$p_title}} <span>( {{$items->total()}} )</span></h2>

<a href="<?= route('admin-brand-create', []); ?>" type="button" class="btn btn-primary">Создать новый</a>

<table class="table table-striped">
  <thead>
    <tr>
        <th scope="col">id</th>
        <th scope="col">name</th>
        <th scope="col">alias</th>
        <th scope="col">parent_id</th>
        <th scope="col">title</th>
        <th scope="col">description</th>
        <th scope="col">Кол-во продуктов</th>
        <th scope="col">status</th>
        <th scope="col">Кнопки</th>
    </tr>
    </thead>
    <tbody>
        @foreach($items as $item)
        <tr>
            <th scope="row">{{$item->id}}</th>
            <td>{{$item->name}}</td>
            <td>{{$item->alias}}</td>
            <td>{{$item->parent_id}}</td>
            <td>{{$item->title}}</td>
            <td>{{$item->description}}</td>
            <td>
                <span class="badge bg-primary">{{$item->productsCount()}}</span>
                <span class="badge bg-warning">{{$item->productsCount(0)}}</span>
            </td>
            <td style="background-color:<?= Brand::STATUS_ACTIVE == $item->status ? 'green' : 'red'; ?>">{{$item->status}}</td>
            <td>
                <a href="<?= route('admin-brand-update', ['id' => $item->id]); ?>" type="button" class="btn btn-success btn-sm">Редактировать</a>
                <hr>
                <form method="post" action="<?= route('admin-brand-delete', ['id' => $item->id]); ?>">
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