@extends('layouts.admin-default')

@section('breadcrumbs')
<li class="breadcrumb-item" aria-current="page"><a href="<?= route('admin-category-index', []); ?>">Категории</a></li>
<li class="breadcrumb-item active" aria-current="page">{{$p_title}}</li>
@endsection

@section('content')

<h2>{{$cat->title}}</h2>

<form method="post" action="<?= route('admin-category-update', ['id' => $cat->id]); ?>">
@csrf <!-- add csrf field on your form -->
    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Name</label>
        <input id="aliasTranslitFrom" value="{{$cat->name}}" name="name" type="text" class="form-control"  required>
    </div>

    <div class="mb-3">
        <p id="aliasTranslit"></p>
        <label for="exampleInputEmail1" class="form-label">alias</label>
        <input value="{{$cat->alias}}" name="alias" type="text" class="form-control"  required>
    </div>

    <!-- <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">parent_id</label>
        <input value="{{$cat->parent_id}}" name="parent_id" type="text" class="form-control"  required>
    </div> -->

    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">parent_id</label>
        <select value="{{$cat->parent_id}}"name="parent_id" class="form-select form-select-lg mb-3" aria-label=".form-select-lg example" required>
            <option value="0" >Первый уровень</option>
            @foreach($categories as $item)                        
            <option value="<?= $item->id; ?>" <?=$cat->parent_id == $item->id ? 'selected' : ''; ?>>{{$item->name}}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">title</label>
        <input value="{{$cat->title}}" name="title" type="text" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">description</label>
        <input value="{{$cat->description}}" name="description" type="text" class="form-control"  required>
    </div>

    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">img src (alias only)</label>
        <input name="src" value="{{$cat->src}}" type="text" class="form-control">
    </div>

    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">status</label>
        <input value="{{$cat->status}}" name="status" type="text" class="form-control"  required>
    </div>

    <button type="submit" class="btn btn-primary">Submit</button>
</form>

@endsection
