<?php
use Illuminate\Support\Facades\Auth;

?>
@extends('layouts.default')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="<?= route('partner', []); ?>">Кабинет партнера</a></li>
    <li class="breadcrumb-item active" aria-current="page">Форма входа для партнеров</li>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <h2>Заказать вывод средств.</h2>
            <p>Доступно <b>{{$partnerCheck->balance}} {{$partnerCheck->currency}}.</b></p>

            @if (\Session::has('success'))
            <div class="alert alert-success">
                <ul>
                    <li>{!! \Session::get('success') !!}</li>
                </ul>
            </div>
            @endif

            <div class="card">
                <div class="card-header">Форма для вывода денег для партнера под логином <b>{{$partner->login}}</b></div>

                <div class="card-body">
                    <form method="POST" action="{{ route('partner-cash-out-form-request') }}">
                        @csrf

                       <div class="form-group row">
                            <label for="amaunt" class="col-md-4 col-form-label text-md-right">Сумма, грн.</label>

                            <div class="col-md-6">
                                <input id="amaunt" size="5" type="text" class="form-control @error('amaunt') is-invalid @enderror" name="amaunt" value="{{ old('amaunt') }}" required autofocus>

                                @error('amaunt')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <br>
                        <div class="form-group row">
                            <label for="card_num" class="col-md-4 col-form-label text-md-right">Номер кредитной карты.</label>

                            <div class="col-md-6">
                                <input id="card_num" value="{{ old('card_num') }}" placeholder="1234 5678 1234 5678" type="text" pattern="[0-9.,\s]{16,19}" class="form-control @error('card_num') is-invalid @enderror" name="card_num" required>

                                @error('card_num')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <br>
                        <div class="form-group row">
                            <label for="fio" class="col-md-4 col-form-label text-md-right">ФИО</label>

                            <div class="col-md-6">
                                <input id="fio" type="text" value="{{ old('fio') }}" class="form-control @error('fio') is-invalid @enderror" name="fio" size="13" required>

                                @error('fio')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <br>
                        
                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Отправить
                                </button>
                            </div>
                        </div>
                        @foreach ($errors->all() as $error)
                        <br>
                        <div class="alert alert-danger" role="alert">
                            {{ $error }}
                        </div>
                        @endforeach
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection