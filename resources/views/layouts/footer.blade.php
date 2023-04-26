<?php

$current = url()->current();

?>

<footer>
    <div class="container">
        <div class="footer-items">
        <div class="footer-links">
        @foreach ($fItems as $item)
        @if($item->url and $item->status == 1)
            <p class="footer-item">
                @if($item->type == 1)
                <small class="link-light" onmouseover="this.style.cursor='pointer';" onclick="window.open('<?= url($item->url); ?>', '_blank')" >{{ $item->text }}</small>
                @else
                <a href="<?= url($item->url); ?>"><span>{{ $item->text }}</span></a>
                @endif
            </p>
        @endif
        @endforeach
        <p class="footer-item"><a target="_blank" href="<?= route('sitemap', []); ?>"><i><small>Карта сайта</small></i></a></p>
        </div>

        <div class="footer-info">
            @foreach ($fItems as $item)
            @if(!$item->url)
            <p class="footer-item"><span>{{ $item->text }}</span></p>
            @endif
            @endforeach
        </div>

    <?php if(\request()->ip() == "::1" || \request()->ip() == "185.38.219.148"): ?>
    <?php else: ?>
    @include('layouts.counters')
    <?php endif; ?>
        

        </div>
    </div>
</footer>