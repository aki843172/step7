
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
            width: 100px; /* ラベルの幅を揃える */
            margin-right: 30px;
           
        }
        .form-group input,
        .form-group select,
        .form-group textarea {
            width: calc(90% - 120px); /* 入力欄の幅をラベルと合わせて調整 */
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
        .back-button{
            border: 1px solid black;
            background-color: skyblue; /* 戻るボタンはライトブルー */
            padding: 4px 4px;
            border-radius: 5px; /* 角を丸くする */
        }
        

    </style>
</head>
    <div class="container">
        <h1>商品情報編集画面</h1>

        @if(session('success'))
            <div class="alert alert-success">
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
            <label for="id">ID </label> <span>{{ $product->id }}</span>
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
                        <option value="{{ $company->company_name }}">{{ $company->company_name }}</option>
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
                <input type="file" id="img_path" name="img_path">
            </div>

            <div class="form-group">
            <button type="submit" class="update-button">更新</button>
            <a href="{{ route('products.show', $product->id) }}" class="back-button">戻る</a>
            </div>
        
        </div>
        </form>
    </div>

