@extends('layouts.admin-default')

@section('breadcrumbs')
<li class="breadcrumb-item" aria-current="page"><a href="<?= route('admin-category-index', []); ?>">Категории</a></li>
<li class="breadcrumb-item active" aria-current="page">{{$p_title}}</li>
@endsection

@section('content')
<h2>{{$p_title}}</h2>

<form method="post" action="<?= route('admin-category-create', []); ?>">
@csrf <!-- add csrf field on your form -->
    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Name</label>
        <input id="aliasTranslitFrom" name="name" type="text" class="form-control"  required>
    </div>

    <div class="mb-3">
        <p id="aliasTranslit"></p>
        <label for="exampleInputEmail1" class="form-label">alias</label>
        <input name="alias" type="text" class="form-control"  required>
    </div>

    <!-- <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">parent_id</label>
        <input name="parent_id" type="text" class="form-control"  required>
    </div> -->

    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">parent_id</label>
        <select name="parent_id" class="form-select form-select-lg mb-3" aria-label=".form-select-lg example" required>
            <option value="0" >Первый уровень</option>
            @foreach($categories as $item)                        
            <option value="<?= $item->id; ?>" >{{$item->name}}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">title</label>
        <input id="aliasTranslitFrom" name="title" type="text" class="form-control"  required>
    </div>

    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">description</label>
        <input name="description" type="text" class="form-control"  required>
    </div>

    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">img src (alias only)</label>
        <input name="src" type="text" class="form-control">
    </div>

    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">status</label>
        <input name="status" type="text" class="form-control"  required>
    </div>

    <button type="submit" class="btn btn-primary">Submit</button>
</form>

@endsection