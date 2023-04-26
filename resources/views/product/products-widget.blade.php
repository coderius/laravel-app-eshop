<!--Top sail products section-->
<section class="widget-products sect-margin top-sails product-widget">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="widget-products__title">
                    <span>Также покупают</span>
                </div>
            </div>
            @foreach($products as $item)
            <a href="<?= route('product', ['alias' => $item->alias]); ?>" class="link-img-wrapper col">
            <!-- <div class="col-lg-2 col-md-4 col-sm-6 col-xs-6"> -->
                <div class="widget-products__item">
                    <div class="widget-products__wrap">
                        <div class="widget-products__content">
                            
                            @if($item->hasImages())
                            <img src='<?= asset("images/products/$item->id/middle/{$item->imageFirst()->alias}"); ?>' alt="Также заказывают: фото <?= $item->short_title; ?>" >
                            @else
                            <img src='<?= asset("images/default/no-photo.jpg"); ?>' alt="Нет фото <?= $item->short_title; ?>" title="Нет фото <?= $item->short_title; ?>">
                            @endif
                            
                        </div>
                    </div>
                   
                    <div class="widget-products__tax">
                        <span>{{$item->price}} {{$item->currensy}}.</span>
                    </div>

                    <div class="product-widget__header">
                        <span>{{$item->header}}</span>
                    </div>

                    
                    @if(Auth::check() && Auth::user()->is_admin === 1)
                    <div style="font-size:12px;color:#b2b2b2">
                        <i class="fa fa-eye"></i>
                        <span>{{$item->viewsProduct()}}</span>
                    </div>
                    @endif
                    <!-- <div class="widget-products__info">
                        <a type="button" class="btn btn-primary button-radius-25 hover-color-dark" href="<?= route('product', ['alias' => $item->alias]); ?>">Подробнее</a>
                    </div>
                    <div class="widget-products__info">
                        <a type="button" class="btn btn-outline-success button-radius-25" href="<?= route('making-checkout', ['id' => $item->id]); ?>" >Купить</a>
                    </div> -->
                </div> 
            <!-- </div> -->
            </a>
            @endforeach
            
        </div>
    </div>
</section>
