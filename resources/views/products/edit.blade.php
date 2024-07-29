@extends('layouts.app')

@section('content')
    
    <div class="container">
        <h2>商品情報編集画面</h2>

        @if(session('success'))
            <div style="color: green;">
                {{ session('success') }}
            </div>
        @endif
        <form action="{{ route('products.update', $product->id) }}" method="POST"  enctype="multipart/form-data">
            @csrf
            @method('PUT')

        <div class="edit">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
            
            <div class="form-group">
            <label for="id">ID </label> <span>{{ $product->id }}.</span>
            </div>
            <div class="form-group">
                <label for="product_name">商品名 <span style="color:red;">*</span> </label>
                <input type="text" name="product_name" class="form-control" value="{{ $product->product_name }}">
            </div>

            <div class="form-group">
                <label for="company_id">メーカー名<span style="color:red;">*</span> </label>
                    <select id="company_id"name="company_id" class="form-control" required>
                        <option value="">メーカー名を選択</option>
                        @foreach($companies as $company)
                        <option value="{{ $company->id }}" {{ $product->company_id == $company->id ? 'selected' : '' }}>
                        {{ $company->company_name }}
                            </option>
                        @endforeach
                    </select>
            </div>

            <div class="form-group">
                <label for="price">価格 <span style="color:red;">*</span> </label>
                <input type="text" name="price" class="form-control" value="{{ $product->price }}">
            </div>

            <div class="form-group">
                <label for="stock">在庫数 <span style="color:red;">*</span> </label>
                <input type="text" name="stock" class="form-control" value="{{ $product->stock }}">
            </div>

            <div class="form-group">
                <label for="comment">コメント</label>
                <textarea name="comment" class="form-control">{{ $product->comment }}</textarea>
            </div>

            <div class="form-group">
                <label for="img_path">商品画像</label>
                @if($product->img_path)
                    <div>
                        <img src="{{ asset($product->img_path) }}" alt="商品画像" style="max-width: 200px;">
                        <input type="checkbox" name="delete_img" value="1"> 画像を削除
                    </div>
                @endif
                <input type="file" id="img_path" name="img_path">
            </div>

            <div class="form-group">
            <button type="submit" class="update-button">更新</button>
            <a href="{{ route('products.show', $product->id) }}" ><button type="button" class="return-button">戻る</a>
            </div>
        
        </div>
        </form>
    </div>

@endsection

@push('styles')      
<style>
        body {
           
           font-size: 20px; /* 文字全体を少し大きくする */
           display: flex;
           flex-direction: column; /* 縦方向に並べる */
           justify-content: center;
           align-items: center;
       }

       .edit{
           border: 1px solid black; /* 黒枠を設定 */
           padding: 10px; /* 内側の余白を設定 */
       }

       .form-group{
           width: 500px; /* フォームのコンテンツに合わせた幅にする */
           padding: 10px; /* 内側の余白を設定 */
           display: flex;
           justify-content: flex-start; /* 項目と詳細情報を左寄せにする */
           
       }
       .form-group label {
           width: 120px; /* ラベルの幅を揃える */
           margin-right: 30px;
          
       }
       
       .form-control{
           width: calc(80% - 100px); /* 入力欄の幅をラベルと合わせて調整 */
           padding: 10px; /* 内側の余白を設定 */
           font-size: 16px; /* フォントサイズを設定 */
           
       }
       .update-button{
           border: 1px solid black;
           background-color: orange; /* 登録ボタンはオレンジ色 */
           padding: 4px 8px;
           border-radius: 5px; /* 角を丸くする */
           margin-right: 10px; /* 右側に余白を追加 */
       }
       .return-button{
           border: 1px solid black;
           background-color: skyblue; /* 戻るボタンはライトブルー */
           padding: 4px 4px;
           border-radius: 5px; /* 角を丸くする */
       }
</style>
@endpush
