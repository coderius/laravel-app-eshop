@extends('layouts.admin-default')

@section('breadcrumbs')
<li class="breadcrumb-item" aria-current="page"><a href="<?= route('admin-brand-index', []); ?>">Бренды</a></li>
<li class="breadcrumb-item active" aria-current="page">{{$p_title}}</li>
@endsection

@section('content')

<h2>{{$p_title}}</h2>

<form method="post" action="<?= route('admin-brand-update', ['id' => $item->id]); ?>">
@csrf <!-- add csrf field on your form -->
    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Name</label>
        <input value="{{$item->name}}" name="name" type="text" class="form-control"  required>
    </div>

    <div class="mb-3">
        <p id="aliasTranslit"></p>
        <label for="exampleInputEmail1" class="form-label">alias</label>
        <input value="{{$item->alias}}" name="alias" type="text" class="form-control"  required>
    </div>

    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">title</label>
        <input value="{{$item->title}}" name="title" type="text" class="form-control" id="aliasTranslitFrom"  required>
    </div>

    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">description</label>
        <input value="{{$item->description}}" name="description" type="text" class="form-control"  required>
    </div>

    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">status</label>
        <input value="{{$item->status}}" name="status" type="text" class="form-control"  required>
    </div>

    <button type="submit" class="btn btn-primary">Submit</button>
</form>

@endsection
