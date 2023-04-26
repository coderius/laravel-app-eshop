<?php


$current = currentUrlWithoutSortParam();//global helper
//dd($current);

$catalog_url = route("catalog", []);

// echo $catalog_url;

?>
<section class="sidebar">
    <div class="sidebar-header">
        <span>Категории</span>
    </div>
    <ul>
        <li class="<?= $catalog_url == $current ? 'sidebar-link-active' : ''; ?>"><a href="<?= route('catalog', []); ?>">Все товары</a> <span>( {{$allProdCount}} )</span></li>
        @foreach($categoris as $cat)
        <?php $category_url = route("category", ['alias' => $cat->alias]); ?>
        <li class="<?= $category_url == $current ? 'sidebar-link-active' : ''; ?>"><a href="<?= route("category", ['alias' => $cat->alias]); ?>">{{$cat->name}}</a> <span>( {{$cat->productsCount()}} )</span></li>
        @if($cat->categoriesByLevel()->count() > 0)
            <ul class="ul-subcat">
            @foreach($cat->categoriesByLevel() as $sub)
                <?php $sub_url = route("category", ['alias' => $sub->alias]); ?>
                <li class="subcat <?= $sub_url == $current ? 'sidebar-link-active' : ''; ?>"><a href="<?= route("category", ['alias' => $sub->alias]); ?>">{{$sub->name}}</a> <span>( {{$sub->productsActive()->count()}} )</span></li>
            @endforeach
            </ul>
        @endif
        @endforeach
    </ul>
</section>

<section class="sidebar">
    <div class="sidebar-header">
        <span>Бренды</span>
    </div>
    <ul>
        @foreach($brands as $brand)
        <?php $brand_url = route("brand", ['alias' => $brand->alias]); ?>
        <?php  //dd($brand_url); ?>
        <li class="<?= $brand_url == $current ? 'sidebar-link-active' : ''; ?>"><a href="<?= route("brand", ['alias' => $brand->alias]); ?>">{{$brand->name}}</a> <span>( {{$brand->productsActive()->count()}} )</span></li>
        @endforeach
    </ul>
</section>