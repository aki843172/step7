@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $product->name }}</h1>
    <p>{{ $product->description }}</p>
    <p>価格: ¥{{ number_format($product->price) }}</p>
    <a href="{{ route('products.index') }}">商品一覧に戻る</a>
</div>
@endsection
