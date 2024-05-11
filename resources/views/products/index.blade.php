@extends('layouts.app')

@section('content')
<div class="container">
    <h1>商品一覧画面</h1>

    <form action="/products" method="get">
        <input type="text" name="name" placeholder="商品名">
        <select name="maker">
        <!-- メーカーの一覧をoptionタグで表示 -->
        </select>
        <button type="submit">検索</button>
    </form>

    <form action="{{ route('products.index') }}" method="GET">
        <input type="text" name="product_name" placeholder="商品名" value="{{ request('product_name') }}">
        <select name="company_id">
            <option value="">メーカーを選択</option>
            @foreach($companies as $company)
                <option value="{{ $company->id }}" {{ request('company_id') == $company->id ? 'selected' : '' }}>
                    {{ $company->name }}
                </option>
            @endforeach
        </select>
        <button type="submit">検索</button>
    </form>

    
    <table class="table">
        <thead>
            <tr>
                
                <th>ID</th>
                
                <th>商品名</th>
                <th>価格</th>
                <th>在庫数</th>        
                <th>メーカー名</th>

            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
            <tr>
                <td>{{ $product->id }}</td>
                <td>{{ $product->name }}</td>
                <td>{{ $product->price }}</td> 
                <td>{{ $product->stock }}</td>
                <td>{{ $product->manufacturer->name}}</td>
                <td>
                    <form action="{{ route('products.destroy', $product->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit">削除</button>
                    </form>
                </td>
                <!-- 他の項目も同様に追加 -->
            </tr>
            @endforeach
        </tbody>
    </table>

    @foreach($products as $product)
        <div>
            <div>{{ $product->id }}</div>
            <div>{{ $product->name }}</div>
            <div>{{ $product->price }}</div>
            <div>{{ $product->stock }}</div>
            <div>{{ $product->company->name }}</div>
            {{-- 詳細表示ボタン、削除ボタン等 --}}
        </div>
        @endforeach
</div>
@endsection
