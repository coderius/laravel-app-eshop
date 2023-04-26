<?php
use App\Models\Contact;
$select = Contact::flags()['in_stock'];
?>
@extends('layouts.admin-default')

@section('breadcrumbs')
<li class="breadcrumb-item" aria-current="page"><a href="<?= route('admin-'.$idHelper.'-index', []); ?>">{{$nameHelper}}</a></li>
<li class="breadcrumb-item active" aria-current="page">{{$p_title}}</li>
@endsection

@section('content')
<h2>{{$p_title}}</h2>

<form method="post" action="<?= route('admin-'.$idHelper.'-create', []); ?>">
@csrf <!-- add csrf field on your form -->
    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">text</label>
        <input name="text" type="text" class="form-control"  required>
    </div>

    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">link</label>
        <input name="link" type="text" class="form-control"  required>
    </div>

    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">type</label>
        <!-- <input id="aliasTranslitFrom" name="type" type="text" class="form-control"  required> -->
        <select name="type" class="form-select form-select-lg mb-3" aria-label=".form-select-lg example" required>
            @foreach($select as $typeSelect => $valueSelect)                        
            <option value="<?= $typeSelect; ?>" >{{$valueSelect}}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">status</label>
        <input name="status" type="text" class="form-control"  required>
    </div>

    <button type="submit" class="btn btn-primary">Submit</button>
</form>

@endsection