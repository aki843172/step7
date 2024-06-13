<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>商品新規登録</title>
    <link rel="stylesheet" href="../css/app.css">

<style>
.registration-form {
  border: 1px solid black;
  padding: 50px;
  margin-bottom: 50px;
  width: fit-content; /* フォームのコンテンツに合わせた幅にする */
}
.form-row {
  display: flex;
  align-items: center;
  margin-bottom: 15px;
  height: 50px; /* 高さを指定 */


}
.form-row label {
  width: 150px; /* ラベルの幅を揃える */
  margin-right: 25px;
  height: 40px; /* 高さを指定 */
  
}

input {
  border: 1px solid black;
  padding: 15px; /* 内側の余白（パディング）を全方向に10px設定 */
  padding-right: 25px; 
  border-radius: 3px; /* 角を5ピクセル丸くする */
}

.form-control {
  display: block; /* ブロックレベル要素として表示 */
  width: 100%; /* 親要素の幅に合わせて広がる */
  padding: 8px; /* 内側の余白 */
  border: 1px solid black; /* 境界線 */
  border-radius: 3px; /* 角の丸み */
  margin-bottom: 40px; /* 下側の余白 */
 /
}



.register-button {
  border: 1px solid black;
  background-color: orange; /* 登録ボタンはオレンジ色 */
  padding: 7px 10px;
  border-radius: 5px; /* 角を丸くする */
  margin-right: 40px; /* 右側に余白を追加 */
}

.back-button {
  border: 1px solid black;
  background-color: lightblue; /* 戻るボタンはライトブルー */
  padding: 7px 10px;
  border-radius: 5px; /* 角を丸くする */
}


.register-button:hover, .back-button:hover {
  opacity: 0.8; /* ホバー時に透明度を下げる */
}

  
</style>
</head>
<body>
    <h1>商品新規登録画面</h1>

    @if (session('success'))
        <div style="color: green;">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="registration-form">

            <div class="form-row">
                {{ Form::label('name', '商品名 <span style="color:red;">*</span>', ['class' => 'control-label'], false) }}
                {{ Form::text('name', null, ['class' => 'form-control', 'required']) }}
            </div>

            <!-- メーカーのセレクトボックス -->
            <div class="form-row">
                {{ Form::label('manufacturer', 'メーカー名 <span style="color:red;">*</span>', ['class' => 'control-label'], false) }}
                {{ Form::select('manufacturer', ['メーカーA' => 'メーカーA', 'メーカーB' => 'メーカーB', 'メーカーC' => 'メーカーC'], null, ['class' => 'form-control', 'required']) }}
            </div>

            <div class="form-row">
                {{ Form::label('price', '価格 <span style="color:red;">*</span>', ['class' => 'control-label'], false) }}
                {{ Form::text('price', null, ['class' => 'form-control', 'required']) }}
            </div>

            <div class="form-row">
                {{ Form::label('stock', '在庫数 <span style="color:red;">*</span>', ['class' => 'control-label'], false) }}
                {{ Form::number('stock', null, ['class' => 'form-control', 'required']) }}
            </div>

            <div class="form-row">
                <label for="comment">コメント</label>
                <textarea id="comment" name="comment" class="form-control"></textarea>
            </div>

            <div class="form-row">
                <label for="image">商品画像</label>
                <input type="file" id="image" name="image">
            </div>

            <div class="form-row">
                <button type="submit" class="register-button">新規登録</button>
                <button type="button" onclick="window.history.back()"class="back-button">戻る</button>
            </div>
        </div>
    </form>
</body>
</html>
