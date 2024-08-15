@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>商品一覧画面</h2>
        <form  id="searchForm"  action="{{ route('products.index') }}">
            <input type="text" name="keyword" placeholder="検索キーワード" value="{{ request('keyword') }}" class="search-input">
            <select name="company_id" class="select-box">
                <option value="">メーカー名</option>
                @foreach($companies as $id => $company_name)
                    <option value="{{ $id }}" {{ request('company_id') == $id ? 'selected' : '' }}>
                        {{ $company_name }}
                    </option>
                @endforeach
            </select>
            <input type="number" name="price_min" placeholder="価格下限" class="search-input" value="{{ request('price_min') }}">
            <input type="number" name="price_max" placeholder="価格上限" class="search-input" value="{{ request('price_max') }}">
            <input type="number" name="stock_min" placeholder="在庫下限" class="search-input" value="{{ request('stock_min') }}">
            <input type="number" name="stock_max" placeholder="在庫上限" class="search-input" value="{{ request('stock_max') }}">
            <button type="submit" class="search-button">検索</button>
           
        </form>
        <table class="table">
            <thead>
                <tr>
                    <th><a href="#" class="sort-link" data-sort="id">ID</a></th>
                    <th>商品名</th>
                    <th>商品画像</th>
                    <th><a href="#" class="sort-link" data-sort="price">価格</a></th>
                    <th><a href="#" class="sort-link" data-sort="stock">在庫数</a></th>
                    <th>メーカー名</th>
                    <th><a href="{{ route('products.create') }}"><button type="submit" class="register-button">新規登録</button></a></th>
                </tr>
            </thead>
            <tbody id="product-list">
            @include('products.partials.product_list', ['products' => $products])
            </tbody>
        </table>
        {{ $products->appends(request()->all())->links() }}

        
    </div>
@endsection


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.3/js/jquery.tablesorter.min.js"></script>
<script>
    $(document).ready(function() {
        var currentSort = "{{ request('sort','id') }}";
        var currentDirection = "{{ request('direction','desc') }}";

        $('#searchForm').on('submit', function(event) {
            event.preventDefault();
            performSearch();
        });

        $(document).on('click', '.sort-link', function(event) {
            event.preventDefault();
            var sort = $(this).data('sort');
            if (currentSort === sort) {
                currentDirection = currentDirection === 'asc' ? 'desc' : 'asc';
            } else {
                currentSort = sort;
                currentDirection = 'asc';
            }
            performSearch();
        });

        $(document).on('click', '.delete-button', function(event) {
            event.preventDefault();
            if (!confirm('本当にこの商品を削除しますか？')) {
                return;
            }
            var $row = $(this).closest('tr');
            var deleteUrl = $(this).data('url');
            $.ajax({
                url: deleteUrl,
                method: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    $row.remove();
                },
                error: function(xhr) {
                    alert('削除に失敗しました。');
                }
            });
        });

        function performSearch() {
        var formData = $('#searchForm').serializeArray();
        formData.push({ name: 'sort', value: currentSort });
        formData.push({ name: 'direction', value: currentDirection });

        $.ajax({
            url: "{{ route('products.index') }}",
            method: "GET",
            data: $.param(formData),
            success: function(response) {
                $('#product-list').html(response);
                $(".table").tablesorter({
                    headers: {
                        0: { sorter: 'digit' }, // ID カラムのソート
                        3: { sorter: 'digit' }, // 価格カラムのソート
                        4: { sorter: 'digit' }  // 在庫数カラムのソート
                    },
                    sortList: [[0,1]] // 初期ソート: ID 降順
                });
            },
            error: function(xhr) {
                alert('検索に失敗しました。');
            }
        });
    }


        $(".table").tablesorter({
            headers: {
                0: { sorter: 'digit' }, // ID カラムのソート
                3: { sorter: 'digit' }, // 価格カラムのソート
                4: { sorter: 'digit' }  // 在庫数カラムのソート
            },
            sortList: [[0,1]] // 初期
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
