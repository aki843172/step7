<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\Product;

class SalesController extends Controller
{
    public function purchase(Request $request)
    {
        // 入力された商品IDを取得
        $product_id = $request->input('product_id');

        // 商品情報を取得
        $product = Product::findOrFail($product_id);

        // 在庫が0の場合はエラー
        if ($product->stock <= 0) {
            return response()->json([
                'error' => '在庫がありません'
            ], 422);
        }

        // salesテーブルにレコードを追加
        $sale = new Sale();
        $sale->product_id = $product_id;
        $sale->save();

        // productsテーブルの在庫数を減算
        $product->stock--;
        $product->save();

        return response()->json([
            'message' => '購入完了しました'
        ], 200);
    }
}
