<?php
use Illuminate\Support\Facades\Auth;

?>
@extends('layouts.default')

<?php //ADD META TAGS HERE ?>
@section('mete_title','Интернет-магазин стильной женской одежды,обуви,сумок и бижутерии по выгодным ценам')
@section('mete_description','Интернет-магазин женской сезонной одежды, обуви ,сумочек, ювелирных украшений и различных аксессуаров в Украине по доступным ценам.')

@section('breadcrumbs')
    <li class="breadcrumb-item active" aria-current="page">Личный кабинет партнера</li>
@endsection

<?php //echo Auth::id(); ?>

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
        <h2>{{$header}}</h2>

        <div class="partner-body">
            
            <form action="{{ route('partner-logout') }}" method="POST" class="">
                @csrf
                <button class="btn btn-warning" type="submit">Выйти из кабинета</button>
            </form>
            <hr>
            <div class="partner-hello">
                <p>На данной странице представлена информация для партнера под логином <b>{{$partner->login}}</b></p>
                <p>Ваш алиас для реферальной ссылки <b>?partner={{$partner->login}}-{{$partner->id}}</b>
                <br>
                Для того, чтобы любая ссылка на магазин работала по партнерской программе, добавьте данный алиас в конец url ссылки.
                <br>
                Например: <i>https://elecci.com.ua/product/zenskaya-koftocka-seryiolivkadzinsbezbiryuza-tureckii-trikotaz-rubcik</i><b>?partner={{$partner->login}}-{{$partner->id}}</b></p>
            
                <small>В течение 30 дней любая покупка, сделанная покупателем по данной ссылке будет учтена на Ваш счет.
                <br>
                Например, посетитель перешел по Вашей партнерской ссылке, которая указывает на сумочку 1 января, а сделал покупку 25 января и купил свитер. 
                Такая покупка также работает на Вас.
                </small>

                <br><br><br>

            </div>
            <div class="partner-data">
                <div class="accordion" id="accordionExample">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingOne">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            Личные данные
                        </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            @include("partner._partner-info")
                        </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingTwo">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            История транзакций
                        </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            @include("partner._partner-stat")
                        </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingThree">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                            Заработок на партнерке
                        </button>
                        </h2>
                        <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            @include("partner._partner-earnings")
                        </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection


