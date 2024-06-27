@extends('layouts.app')
@section('content')

<!DOCTYPE html>
<html lang="en">
    <head>
    <style>

    .container{
        font-size: 15px; /* 文字全体を少し大きくする */
        display: flex;
        flex-direction: column; /* 縦方向に並べる */
        justify-content: center;
        align-items: center;
        
            
    }
    /* テーブル全体のスタイル */
    table {
        border: 1px solid black; /* 黒い枠線 */
        border-collapse: collapse; /* 枠線の重なりを解除 */
        /*width: %; /* 幅を100%に設定 */
        width: fit-content; /* フォームのコンテンツに合わせた幅にする */
       
    }

    /* テーブルのヘッダー行のスタイル */
    th {
        text-align: left; /* 左え */
        padding: 15px; /* 余白を追加 */
    }

    /* テーブルのデータ行のスタイル */
    td {
        text-align: left; /* 中央揃え */
        padding: 15px; /* 余白を追加 */
    }

    /* ラインを追加 */
    tr {
        border-bottom: 1px solid black; /* 黒いライン */
    }
    
   
    
    /* 新規登録ボタンのスタイル */
    .register-button {
        border: 1px solid black;
        background-color: orange; /* 登録ボタンはオレンジ色 */
        padding: 7px 10px;
        border-radius: 4px; /* 角を丸くする */
        /*margin-right: 30px; /* 右側に余白を追加 */
        
    }

    /* 詳細ボタンのスタイル */
    .detail-button {
        border: 1px solid black;
        border-radius: 4px;
        background-color: lightblue; /* 水色の背景 */
        color: black; /* 黒のテキスト */
        padding: 7px 10px;
        font-size: 15px;
    }

    /* 削除ボタンのスタイル */
    .delete-button {
        border: 1px solid black;
        border-radius: 4px;
        background-color: red; /* 赤色の背景 */
        color: white; /* 白色のテキスト */
        padding: 7px 10px;
    }
    
    .register-button:hover,.detail-button:hover ,.delete-button:hover{
        opacity: 0.8; /* ホバー時に透明度を下げる */
    }
    /* キーワード検索とセレクトボックスのサイズを大きくする */
    .search-input {
            font-size: 18px; /* フォントサイズを大きくする */
            padding: 10px; /* パディングを追加 */
            width: 300px; /* 幅を広げる */
            margin-bottom:10px;
        }

        .select-box {
            font-size: 18px; /* フォントサイズを大きくする */
            padding: 10px; /* パディングを追加 */
            width: 320px; /* 幅を広げる */
            margin-bottom:10px;
        }
    </style>
    </head>
    <div class="container">
    <h2>商品一覧画面</h2>
  
        <form action="{{ route('products.index') }}" method="GET">

            <input type="text" name="keyword" placeholder="検索キーワード" value="{{ request('keyword') }}"class="search-input">

            <select name="company_id"class="select-box">
                <option value="">メーカー名</option>
                @foreach($companies as $company)
                <option value="{{ $company->id }}" {{ request('company_id') == $company->id ? 'selected' : '' }}>
                {{ $company->company_name }}
                </option>
                @endforeach
            </select>

            <button type="submit" class ="searct-button">検索</button>
        </form>
  

        
    <table class="table">
        <thead>
            <tr>

                <th>ID</th>
                <th>商品名</th>
                <th>商品画像</th>
                <th>価格</th>
                <th>在庫数</th>        
                <th>メーカー名</th>
                <th><a href="{{ route('products.create') }}"><button type="submit" class="register-button">新規登録</button></a></th>
            </tr>
        </thead>
               
        <tbody>
            
            @foreach ($products as $product)
            <tr>
            
            
                <td>{{ $product->id }}</td>
                <td>{{ $product->product_name }}</td>
                <td><img src="{{ $product->img_path }}" alt="{{ $product->product_name }}"></td>
                <td>{{ $product->price }}</td> 
                <td>{{ $product->stock }}</td>
                <td>{{ $product->company_id }}</td>             
                
                <td>
                    <a href="{{ route('products.show', $product->id) }}" class="detail-button">詳細</a>
                </td>
                <td>
                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('本当にこの商品を削除しますか？');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class ="delete-button">削除</button>
                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline;">
                    </form>

                </td>
                <!-- 他の項目も同様に追加 -->
            </tr>
            @endforeach
        </tbody>
    </table>

    
       
       
    </div>
@endsection
