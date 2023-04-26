<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
        <url>
            <loc>{{ route('home', []) }}</loc>
            <lastmod>{{ Carbon\Carbon::now()->subDays(2)->tz('UTC')->toAtomString() }}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.8</priority>
        </url>
        @foreach ($products as $item)
        <url>
            <loc>{{ route('product', ['alias' => $item->alias]) }}</loc>
            <lastmod>{{ $item->created_at->tz('UTC')->toAtomString() }}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>1</priority>
        </url>
        @endforeach 
        <url>
            <loc>{{ route('contacts', []) }}</loc>
            <lastmod>{{ Carbon\Carbon::now()->subDays(10)->tz('UTC')->toAtomString() }}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.5</priority>
        </url>
        <url>
            <loc>{{ route('catalog', []) }}</loc>
            <lastmod>{{ Carbon\Carbon::now()->subDays(1)->tz('UTC')->toAtomString() }}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.5</priority>
        </url>
    @foreach ($categories as $item)
        <url>
            <loc>{{ route('category', ['alias' => $item->alias]) }}</loc>
            <lastmod>{{ $item->created_at->tz('UTC')->toAtomString() }}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.8</priority>
        </url>
    @endforeach
    @foreach ($brands as $item)
        <url>
            <loc>{{ route('brand', ['alias' => $item->alias]) }}</loc>
            <lastmod>{{ $item->created_at->tz('UTC')->toAtomString() }}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.8</priority>
        </url>
    @endforeach
</urlset>