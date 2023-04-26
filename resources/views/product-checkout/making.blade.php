@extends('layouts.default')

<?php //ADD META TAGS HERE ?>
@section('mete_title')Оформление заказа на {{$product->title}}@endsection
@section('mete_description')Страница оформления заказа на {{$product->title}}@endsection

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="<?= route('catalog', []); ?>">Каталог</a></li>
    <li class="breadcrumb-item"><a href="<?= route('category', ['alias' => $category->alias]); ?>">{{$category->name}}</a></li>
    @if($brand->exists())
    <li class="breadcrumb-item"><a href="<?= route('brand', ['alias' => $brand->alias]); ?>">{{$brand->name}}</a></li>
    @endif
    <li class="breadcrumb-item"><a href="<?= route('product', ['alias' => $product->alias]); ?>">{{$product->short_title}}</a></li>
    <li class="breadcrumb-item active" aria-current="page">Оформление заказа</li>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <h1 style="margin-bottom: 40px;color:darkslategrey">Оформление покупки</h1>
        </div>
        
        <!-- Slider content row -->
        <div class="col-6">

        @if (\Session::has('success'))
            <div class="alert alert-success">
                <ul>
                    <li>{!! \Session::get('success') !!}</li>
                </ul>
            </div>
            <!-- <br>
            <div class="alert alert-info" role="alert">
                Спасибо! С Вами в ближайшее время свяжется наш менеджер.
            </div> -->
        

        @else
        <!-- Shipping info -->
        <div class="content-column__dostavka">
            <div class="content-column__dostavka-title">
                <h2>Способы оплаты и доставки этого товара.</h2>
            </div>
            @if($shippingMethods->count() > 0)
            @foreach($shippingMethods as $sm)
            <div class="content-column__dostavka-descr">
                <h5>{{ $sm->header }}</h5>
                <!-- <p class="content-column__dostavka-descr-instr"><span>Инструкция</span></p> -->
                <div class="content-column__dostavka-descr-instr-text">
                    <?= $sm->text; ?>
                </div>
            </div>
            @endforeach
            @else
            <h5>Уточнить у продавца</h5>
            @endif
        </div>

        <section class="content-column">
        
            <div class="content-column__header">
                <h2>Оформление заказа</h2>
            </div>
            <form id="bayer-form" method="POST" action="{{ route('order-processing') }}">
            @csrf
                <div class="mb-3">
                    <label for="item1" class="form-label"><b class="text-danger">*</b> Ваша фамилия</label>
                    <input type="text" value="{{ old('surname') }}" name="surname" class="form-control" id="item1" required>
                    <div class="form-text"></div>
                    @error('surname')
                    <span class="text-danger"><strong>{{$message}}</strong></span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="item1" class="form-label"><b class="text-danger">*</b> Ваше имя</label>
                    <input type="text" value="{{ old('name') }}" name="name" class="form-control" id="item1" required>
                    <div class="form-text"></div>
                    @error('name')
                    <span class="text-danger"><strong>{{$message}}</strong></span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="item1" class="form-label"><b class="text-danger">*</b> Ваше отчество</label>
                    <input type="text" value="{{ old('lastname') }}" name="lastname" class="form-control" id="item1" required>
                    <div class="form-text"></div>
                    @error('lastname')
                    <span class="text-danger"><strong>{{$message}}</strong></span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="item1" class="form-label"><b class="text-danger">*</b> Область</label>
                    <input type="text" value="{{ old('region') }}" name="region" class="form-control" id="item1" required>
                    <div class="form-text">Например, Киевская обл.</div>
                    @error('region')
                    <span class="text-danger"><strong>{{$message}}</strong></span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="item1" class="form-label"><b class="text-danger">*</b> Город, населенный пункт</label>
                    <input type="text" value="{{ old('locality') }}" name="locality" class="form-control" id="item1" required>
                    <div class="form-text">Например, г.Киев</div>
                    @error('locality')
                    <span class="text-danger"><strong>{{$message}}</strong></span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="item1" class="form-label"><b class="text-danger">*</b> № отделения Новой Почты</label>
                    <input type="number" value="{{ old('mail_num') }}" name="mail_num" class="form-control" id="item1" required>
                    <div class="form-text">Например, 5</div>
                    @error('locality')
                    <span class="text-danger"><strong>{{$message}}</strong></span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="item1" class="form-label"><b class="text-danger">*</b> Телефон</label>
                    <input type="tel" value="{{ old('phone') }}" name="phone" pattern="\+[1-9]{1}8[0-9]{10}" class="form-control" id="item1" required>
                    <div class="form-text">Введите телефон в формате +380991230087</div>
                    @error('phone')
                    <span class="text-danger"><strong>{{$message}}</strong></span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="item1" class="form-label"><b class="text-danger">*</b> Email</label>
                    <input type="email" value="{{ old('email') }}" name="email" pattern="[^@\s]+@[^@\s]+\.[^@\s]+" title="Не верный формат email" class="form-control" id="item1" required>
                    <div class="form-text">youremail@gmail.com</div>
                    @error('email')
                    <span class="text-danger"><strong>{{$message}}</strong></span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="item1" class="form-label">Телефон на котором Viber</label>
                    <input type="tel" value="{{ old('phone_viber') }}" name="phone_viber" pattern="\+[1-9]{1}8[0-9]{10}" class="form-control" id="item1" placeholder="Свяжемся с Вами в чате">
                    <div class="form-text">Введите телефон в формате +380991230087</div>
                </div>
                <div class="mb-3">
                    <label for="item1" class="form-label">Телефон на котором Telegram</label>
                    <input type="tel" value="{{ old('phone_telegram') }}" name="phone_telegram" pattern="\+[1-9]{1}8[0-9]{10}" class="form-control" id="item1" placeholder="Свяжемся с Вами в чате">
                    <div class="form-text">Введите телефон в формате +380991230087</div>
                </div>
                <div class="mb-3">
                    <label for="item1" class="form-label">Ваши комментарии</label>
                    <textarea name="comments" class="form-control" rows="5" id="comments" name="text"></textarea>
                    <div class="form-text">Тут Вы можете написать свои комментарии к заказу</div>
                </div>

                <input type="hidden" name="product_id" value="{{$product->id}}">
                <input type="hidden" name="amount" value="{{$product->price}}">
                <input type="hidden" name="currensy" value="{{$product->currensy}}">

                <button type="submit" class="btn btn-primary">Отправить</button>
                
            </form>
        @endif   

        </section>
<br><br>
            <!-- Contacts -->
            <div class="contacts-faq">
                <!-- <div class="contacts-faq-title">Вы также можете оформить заказ по данным контактам.</div> -->
                <div class="contacts-faq-title">Контакты для связи.</div>
                @if($phone->count() > 0)
                @foreach($phone as $ph)
                <div class="contact-faq-contact"><a href="<?= $ph->link; ?>" class="contacts-faq-item"><?= $ph->text; ?></a></div>
                @endforeach
                @endif
                @if($telegram->count() > 0)
                <div class="contact-faq-contact"><a href="<?= $telegram->first()->link; ?>" target="_blank" class="contacts-faq-item">Сообщение в telegram</a></div>
                @endif
                @if($viber->count() > 0)
                <div class="contact-faq-contact"><a href="<?= $viber->first()->link; ?>" target="_blank" class="contacts-faq-item">Сообщение в viber</a></div>
                @endif
                @if($viberMobile->count() > 0)
                <div class="contact-faq-contact"><a href="<?= $viberMobile->first()->link; ?>" target="_blank" class="contacts-faq-item">Сообщение в viber (для мобильного)</a></div>
                @endif
            </div>

            <br><br>
            
        </div>

        <div class="col-4 offset-2">
            <!-- Product -->
            <section class="checkout-product">
                <h2>{{$product->header}}</h2>
                <p><b>Состояние:</b> <span>{{$product_state}}</span></p>
                <div class="slider-img">
                    <img class="rounded-img" src="<?= asset(asset("images/products/$product->id/middle/$image->alias")); ?>" alt="<?= $image->alt; ?>">
                </div>
                <div class="checkout-product__tax">
                    <span>Стоимость товара:</span>
                    <span>{{$product->price}} {{$product->currensy}}.</span>
                </div>
            </section>
        </div>
        
        <!-- <div class="col-12">
            <div class="contacts-faq">
                <div class="contacts-faq-title">Есть вопрос? Обращайтесь.</div>
                <div class="contact-faq-contact"><a href="tel: +380971081069" class="contacts-faq-item">+380971081069</a></div>
                <div class="contact-faq-contact"><a href="https://telegram.me/drop_shopes" target="_blank" class="contacts-faq-item">Сообщение в telegram</a></div>
                <div class="contact-faq-contact"><a href="viber://chat?%2B380971081069" target="_blank" class="contacts-faq-item">Сообщение в viber</a></div>
            </div>
        </div> -->
        
    </div>
    
</div>
@endsection