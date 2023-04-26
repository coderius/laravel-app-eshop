<h1>Всего продуктов {{ $products->count() }}</h1>
@foreach($products as $k => $item)
{{ route('product', ['alias' => $item->alias]) }}<br><?= $k % 20 == 0 && $k > 1 ? "<br>" : ""; ?>
@endforeach
