

<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        .container {
            font-size: 20px; /* 文字全体を少し大きくする */
            display: flex;
            flex-direction: column; /* 縦方向に並べる */
            justify-content: center;
            align-items: center;
            
        }

        .show-body{
            border: 1px solid black; /* 黒枠を設定 */
            margin: 0 auto; /* フォームを中央に配置 */
            width: 450px; /* フォームのコンテンツに合わせた幅にする */
            padding: 15px; /* 内側の余白を設定 */
           
        }

        .show-row{
            margin-bottom: 30px; /* 行間隔 */
            display: flex;
            justify-content: flex-start; /* 項目と詳細情報を左寄せにする */
            margin-right: 30px; /* 右側に余白を追加 */
            margin-left: 30px;
            
        }

        .show-row strong {
            width: 100px; /* ラベルの幅を揃える */
            margin-right: 70px; /* 項目と詳細情報の間に余白を追加 */
        }

        
        
        .edit-button {
            border: 1px solid black;
            background-color: orange; /* 登録ボタンはオレンジ色 */
            padding: 4px 8px;
            border-radius: 5px; /* 角を丸くする */
            margin-right: 40px; /* 右側に余白を追加 */
            margin-top: 30px; /* ボタンを少し下に配置 */
        
        }

        .return-button {
            border: 1px solid black;
            background-color: skyblue; /* 戻るボタンはライトブルー */
            padding: 4px 8px;
            border-radius: 5px; /* 角を丸くする */
            margin-top: 30px; /* ボタンを少し下に配置 */
        }

        

    </style>
</head>
    <div class="container">
        <h2>商品情報詳細画面</h2>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <div class="show-body">

            <div class="show-row">
                <strong>ID</strong> <span>{{ $product->id }}</span>
            </div>
            <div class="show-row">
                <strong>画像パス</strong> <span><img src="{{ $product->img_path }}" alt="{{ $product->product_name }}"></span>
            </div>
            <div class="show-row">
                <strong>商品名</strong> <span>{{ $product->product_name }}</span>
            </div>
            <div class="show-row">
                <strong>メーカー名</strong> <span>{{ $product->company_id }}</span>
            </div>
            <div class="show-row">
                <strong>価格</strong> <span>{{ $product->price }}</span>
            </div>
            <div class="show-row">
                <strong>在庫数</strong> <span>{{ $product->stock }}</span>
            </div>
            <div class="show-row">
                <strong>コメント</strong> <span>{{ $product->comment }}</span>
            </div>
            
            
            
            <div class="show-row">
                <a href="{{ route('products.edit', $product->id) }}"><button type="submit" class="edit-button">編集</a>
                <a href="{{ route('products.index') }}"><button type="button" class="return-button">戻る</a>
            </div>
        </div>
    </div>

