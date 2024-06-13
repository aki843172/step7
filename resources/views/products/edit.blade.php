@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>商品情報編集画面</h1>
        <form action="{{ route('products.update', $product->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div>
            <strong>ID:</strong> {{ $product->id }}
            </div>
            <div class="form-group">
                <label for="product_name">商品名</label>
                <input type="text" name="product_name" class="form-control" value="{{ $product->product_name }}">
            </div>

            <div class="form-group">
                <label for="company_id">メーカー名</label>
                <input type="text" name="company_id" class="form-control" value="{{ $product->company_id }}">
            </div>

            <div class="form-group">
                <label for="price">価格</label>
                <input type="text" name="price" class="form-control" value="{{ $product->price }}">
            </div>

            <div class="form-group">
                <label for="stock">在庫数</label>
                <input type="text" name="stock" class="form-control" value="{{ $product->stock }}">
            </div>

            <div class="form-group">
                <label for="comment">コメント</label>
                <textarea name="comment" class="form-control">{{ $product->comment }}</textarea>
            </div>

            <div class="form-group">
                <label for="image">商品画像</label>
                <input type="file" id="image" name="image">
            </div>

            <button type="submit" class="btn btn-primary">更新</button>
            <button type="button" onclick="window.history.back()"class="back-button">戻る</button>
        </form>
    </div>
@endsection
