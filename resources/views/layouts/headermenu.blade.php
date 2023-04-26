<?php

$current = currentUrlWithoutSortParam();

?>

<section class="header-menu">
    <div class="container">
        <div class="header-menu__items">
        <div class="header-menu__item <?= url('/') == $current ? 'active' : ''; ?>">
                <a href="<?= url('/'); ?>"><span>Главная</span></a>
        </div>
        @foreach ($items as $item)
        <?php //dd($item);?>
            @if($item->status == 1)
            <div class="header-menu__item  <?= url("$item->url") == $current ? 'active' : ''; ?>">
                <a href='<?= url("$item->url");?>'><span>{{ $item->text }}</span></a>
            </div>
            @endif
            

        @endforeach
        </div>
    </div>
</section>
