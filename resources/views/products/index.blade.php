@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>商品一覧画面</h2>
        <form  id="searchForm">
            <input type="text" name="keyword" placeholder="検索キーワード" value="{{ request('keyword') }}" class="search-input">
            <select name="company_id" class="select-box">
                <option value="">メーカー名</option>
                @foreach($companies as $id => $company_name)
                    <option value="{{ $id }}" {{ request('company_id') == $id ? 'selected' : '' }}>
                        {{ $company_name }}
                    </option>
                @endforeach
            </select>
            <input type="number" name="price_min" placeholder="価格下限" class="search-input">
            <input type="number" name="price_max" placeholder="価格上限" class="search-input">
            <input type="number" name="stock_min" placeholder="在庫下限" class="search-input">
            <input type="number" name="stock_max" placeholder="在庫上限" class="search-input">
            <button type="submit" class="search-button">検索</button>
           
        </form>
        <table class="table">
            <thead>
                <tr>
                    <th><a href="{{ route('products.index', array_merge(request()->all(), ['sort' => 'id', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc'])) }}">ID</a></th>
                    <th>商品名</a></th>
                    <th>商品画像</th>
                    <th><a href="{{ route('products.index', array_merge(request()->all(), ['sort' => 'price', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc'])) }}">価格</a></th>
                    <th><a href="{{ route('products.index', array_merge(request()->all(), ['sort' => 'stock', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc'])) }}">在庫数</a></th>
                    <th>メーカー名</th>
                    <th><a href="{{ route('products.create') }}"><button type="submit" class="register-button">新規登録</button></a></th>
                </tr>
            </thead>
            <tbody id="product-list">
            @include('products.partials.product_list', ['products' => $products])
            </tbody>
        </table>
        {{ $products->links() }}
    </div>
@endsection


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // 検索フォームの非同期処理
        $('#searchForm').on('submit', function(event) {
            event.preventDefault();
            $.ajax({
                url: "{{ route('products.index') }}",
                method: "GET",
                data: $(this).serialize(),
                success: function(response) {
                    $('#product-list').html(response);
                },
                error: function(xhr) {
                    alert('検索に失敗しました。');
                }
            });
        });

        // 削除ボタンの非同期処理
        $(document).on('submit', '.delete-form', function(event) {
            event.preventDefault();
            if (!confirm('本当にこの商品を削除しますか？')) {
                return;
            }
            var form = $(this);
            $.ajax({
                url: form.attr('action'),
                method: form.find('input[name="_method"]').val(),
                data: form.serialize(),
                success: function(response) {
                    form.closest('tr').remove();
                },
                error: function(xhr) {
                    alert('削除に失敗しました。');
                }
            });
        });
    });
</script>

@push('styles')
<style>
    .container {
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
        width: fit-content; /* フォームのコンテンツに合わせた幅にする */
    }
    /* テーブルのヘッダー行のスタイル */
    th {
        text-align: left; /* 左揃え */
        padding: 15px; /* 余白を追加 */
    }
    /* テーブルのデータ行のスタイル */
    td {
        text-align: left; /* 左揃え */
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
    .register-button:hover, .detail-button:hover, .delete-button:hover {
        opacity: 0.8; /* ホバー時に透明度を下げる */
    }
    /* キーワード検索とセレクトボックスのサイズを大きくする */
    .search-input {
        font-size: 12px; /* フォントサイズを大きくする */
        padding: 10px; /* パディングを追加 */
        width: 110px; /* 幅を広げる */
        margin-bottom: 10px;
    }
    .select-box {
        font-size: 12px; /* フォントサイズを大きくする */
        padding: 10px; /* パディングを追加 */
        width: 110px; /* 幅を広げる */
        margin-bottom: 10px;
    }
</style>
@endpush
