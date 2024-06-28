<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>商品新規登録</title>
    <link rel="stylesheet" href="../css/app.css">
    <style>
        
       

        body {
            font-size: 20px; /* 文字全体を少し大きくする */
            display: flex;
            flex-direction: column; /* 縦方向に並べる */
            justify-content: center;
            align-items: center;
            height: 100vh; /* ビューポートの高さを100%に設定 */
            
        }
        .registration-form {
            border: 1px solid black; /* 黒枠を設定 */
            margin: 0 auto; /* フォームを中央に配置 */
            padding: 50px; /* 内側の余白を設定 */
            margin-bottom: 60px; /* 下部の余白を設定 */
            width: 100%; /* フォームの幅を100%に設定 */
            max-width: 600px; /* 最大幅を設定 */
        }

        .form-row {
            display: flex;
            margin-bottom: 30px; /* 行間隔 */
        }

        .form-row label {
            width: 120px; /* ラベルの幅を揃える */
            margin-right: 15px;
        }

        .form-row input  {
            align-items: left;
        }

        .form-row input,
        .form-row select,
        .form-row textarea {
            width: 70%; /* 入力欄の幅を100%に設定 */
            padding: 10px; /* 内側の余白を設定 */
            font-size: 16px; /* フォントサイズを設定 */
        }

        .register-button {
            border: 1px solid black;
            background-color: orange; /* 登録ボタンはオレンジ色 */
            padding: 4px 8px;
            border-radius: 5px; /* 角を丸くする */
            margin-right: 40px; /* 右側に余白を追加 */
        }

        .back-button {
            border: 1px solid black;
            background-color: skyblue; /* 戻るボタンはライトブルー */
            padding: 4px 8px;
            border-radius: 5px; /* 角を丸くする */
        }

        .register-button:hover, .back-button:hover {
            opacity: 0.8; /* ホバー時に透明度を下げる */
        }

    </style>

 
</head>
<body>
    
    <h2>商品新規登録画面</h2>

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
                {{ Form::label('product_name', '商品名 <span style="color:red;">*</span>', ['class' => 'control-label'], false) }}
                {{ Form::text('product_name', null, ['class' => 'form-control', 'required']) }}
            </div>

            <div class="form-row">
                {{ Form::label('company_id', 'メーカ名 <span style="color:red;">*</span>', ['class' => 'control-label'], false) }}
                <select id="company_id" name="company_id" class="form-control" required>
                    <option value="">メーカー名を選択</option>
                    @foreach($companies as $company)
                    <option value="{{ $company->id}}">{{ $company->company_name }}</option>
                    @endforeach
                </select>
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
                <button type="button" onclick="window.location='{{ route('products.index') }}'" class="back-button">戻る</button>

            </div>
        </div>
    </form>
     
</body>
</html>
