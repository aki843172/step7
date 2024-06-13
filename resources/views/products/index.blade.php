@extends('layouts.app')

@section('content')


<div class="container">
    <h1>商品一覧画面</h1>

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
                <a href="{{ route('products.create') }}" class="btn btn-success" style="margin-top: 20px;">新規登録</a>
        <tbody>
            @foreach ($products as $product)
            <tr>
                <td>{{ $product->id }}</td>
                <td>{{ $product->product_name }}</td>
                <td>{{ $product->price }}</td> 
                <td>{{ $product->stock }}</td>
                <td>{{ optional($product->company)->name }}</td>             
                <td>
                <td>
                    <a href="{{ route('products.show', $product->id) }}" class="btn btn-primary">詳細</a>
                </td>
                
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

    
       
       
</div>
@endsection
