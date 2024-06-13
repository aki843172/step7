@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>商品詳細</h1>
        <div>
            <strong>ID:</strong> {{ $product->id }}
        </div>
        <div>
            <strong>画像パス:</strong> {{ $product->img_path }}
        </div>
        <div>
            <strong>商品名:</strong> {{ $product->product_name }}
        </div>
        <div>
            <strong>メーカー名:</strong> {{ $product->company_id }}
        </div>
        <div>
            <strong>価格:</strong> {{ $product->price }}
        </div>
        <div>
            <strong>在庫数:</strong> {{ $product->stock }}
        </div>
        
        <div>
            <strong>コメント:</strong> {{ $product->comment }}
        </div>
        
        <div>
            <strong>更新者ID:</strong> {{ $product->updated_by }}
        </div>
        <div>
            <strong>作成日時:</strong> {{ $product->created_at }}
        </div>
        <div>
            <strong>更新日時:</strong> {{ $product->updated_at }}
        </div>
        <div>
            <a href="{{ route('products.edit', $product->id) }}"><button type="submit">編集</a>
            <a href="{{ route('products.index') }}"><button type="submit">戻る</a>
        </div>
    </div>
@endsection
