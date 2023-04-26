@extends('layouts.default')

<?php //ADD META TAGS HERE ?>
@section('mete_title','Контакты интернет-магазина модных вещей и аксессуаров')
@section('mete_description','Контакты интернет-магазина одежды, обуви и различных аксессуаров в Украине')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="<?= route('catalog', []); ?>">Каталог</a></li>
    <li class="breadcrumb-item active" aria-current="page">Контакты магазина</li>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <section id="contacts-page">
                <h1>Контакты магазина</h1>
                <div class="contacts-faq">
                @if($phone->count() > 0)
                    @foreach($phone as $ph)
                    <div class="contact-faq-contact">
                        <a href="<?= $ph->link; ?>" class="contacts-faq-item"><?= $ph->text; ?></a>
                    </div>
                    @endforeach
                @endif
                @if($telegram->count() > 0)
                <div class="contact-faq-contact">
                    <!-- <a href="<?= $telegram->first()->link; ?>" target="_blank" class="contacts-faq-item">Сообщение в telegram</a> -->
                    <span class="link-primary" onmouseover="this.style.cursor='pointer';" onclick="window.open('<?= $telegram->first()->link; ?>', '_blank')" >Сообщение в telegram</span>
                </div>
                @endif
                @if($viber->count() > 0)
                <div class="contact-faq-contact">
                    <!-- <a href="<?= $viber->first()->link; ?>" target="_blank" class="contacts-faq-item">Сообщение в viber</a> -->
                    <span class="link-primary" onmouseover="this.style.cursor='pointer';" onclick="window.open('<?= $viber->first()->link; ?>', '_blank')" >Сообщение в viber</span>
                </div>
                @endif
                @if($viberMobile->count() > 0)
                <div class="contact-faq-contact">
                    <!-- <a href="<?= $viberMobile->first()->link; ?>" target="_blank" class="contacts-faq-item">Сообщение в viber (для мобильного)</a> -->
                    <span class="link-primary" onmouseover="this.style.cursor='pointer';" onclick="window.open('<?= $viberMobile->first()->link; ?>', '_blank')" >Сообщение в viber (для мобильного)</span>
                </div>
                @endif
                </div>

                <div class="sale-pages">
                    <div class="sale-pages__title"><span>Магазин на интернет-площадках</span></div>
                    @if($urls->count() > 0)
                    @foreach($urls as $url)
                    @if($url->text == 'olx')
                    <div class="sale-pages__item"><span class="link-primary" onmouseover="this.style.cursor='pointer';" onclick="window.open('<?= $url->link; ?>', '_blank')" >Страница магазина на ОЛХ</span></div>
                    @endif
                    @if($url->text == 'shafa')
                    <div class="sale-pages__item"><span class="link-primary" onmouseover="this.style.cursor='pointer';" onclick="window.open('<?= $url->link; ?>', '_blank')" >Страница магазина на Shafa</span></div>
                    @endif
                    @endforeach
                    @endif
                </div>

                <div class="sale-pages">
                    <div class="sale-pages__title"><span>Telegram группа магазина</span></div>
                    <div class="sale-pages__item"><a href="<?= $telegramGroupShop->first()->link; ?>" target="_blank" class="contacts-faq-item"><?= $telegramGroupShop->first()->link; ?></a></div>
                </div>

                <div class="sale-pages">
                    <a name='partnership'></a>
                    <div class="sale-pages__title"><span>Партнерская программа</span></div>
                    <div class="sale-pages__item"><a href="<?= route('partner-conditions', []); ?>">Условия программы</a></div>
                    <div class="sale-pages__item"><a href="<?= route('partner-register-form', []); ?>">Вход & Регистрация в партнерской программе</a></div>
                </div>
            </section>
        </div>
    </div>
    
</div>
@endsection