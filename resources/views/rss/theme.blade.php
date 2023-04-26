<?=
'<?xml version="1.0" encoding="UTF-8"?>'.PHP_EOL
?>
<rss version="2.0">
    <channel>
        <title><![CDATA[ <?= $category->name; ?> - elecci.com.ua - <?= date("Y"); ?>]]></title>
        <link><![CDATA[ <?= route('rss-theme', ['alias' => $category->alias]); ?> ]]></link>
        <description><![CDATA[ Интернет магазин товаров для женщин. <?= $category->title; ?> ]]></description>
        <language>ru</language>
  
        @foreach($products as $item)
            <item>
                <title><![CDATA[{{ $item->title }}]]></title>
                <link>{{ route('product', ['alias' => $item->alias]) }}</link>
                <description><![CDATA[{!! $item->description !!}]]></description>
                <category>{{ $item->category()->first()->name }}</category>
                <pubDate>{{ $item->created_at->toRssString() }}</pubDate>
            </item>
        @endforeach
    </channel>
</rss>