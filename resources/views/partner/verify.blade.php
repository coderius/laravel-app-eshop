@extends('layouts.default')

<?php //ADD META TAGS HERE ?>
@section('mete_title')Восстановление доступа@endsection
@section('mete_description')Страница для восстановления доступа@endsection

@section('breadcrumbs')
    <li class="breadcrumb-item active" aria-current="page">Восстановление доступа</li>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Подтвердите ваш email</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            Ссылка для сброса пароля отправлена на ваш email
                        </div>
                    @endif

                    Прежде чем продолжить, проверьте свою электронную почту на наличие ссылки для подтверждения.
                    Если вы не получили письмо,
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">нажмите здесь, чтобы отправить новый запрос</button>.
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
