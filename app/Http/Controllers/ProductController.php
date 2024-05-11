<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Company;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companies = Company::all(); // すべての会社データを取得
        $products = Product::all(); // すべての商品データを取得

        return view('products.index', compact('companies', 'products'));
    }

    
   


    /**
     * Show the form for creating a new resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('products.create');
        //商品新規登録画面を表示するためのメソッド,
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $product = new Product;
        $product->name = $request->name;
      
        $product->save();
        return redirect()->route('products.index');
        //新規商品情報をデータベースに保存するためのメソッド
        //通常、これはフォームから送信されたデータを取得し、それをデータベースに保存する

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);
        return view('products.show', compact('product'));
        // 商品情報詳細画面を表示するためのメソッドです。
        //通常、これはデータベースから特定の商品情報を取得し、それをビューに渡して表示します。
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::find($id);
        return view('products.edit', compact('product'));
        // 商品情報編集画面を表示するためのメソッド
        //通常、これはデータベースから特定の商品情報を取得し、それを編集フォームに渡して表示します。

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $product = Product::find($id);
        $product->name = $request->name;

        $product->save();
        return redirect()->route('products.show',['id' => $id]);
        //編集された商品情報をデータベースに保存するためのメソッドです。
        //通常、これはフォームから送信されたデータを取得し、それをデータベースに保存します。
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        $product->delete();
        return redirect()->route('products.index');
        //商品情報を削除するためのメソッド。該当の商品をデータベースから削除し、一覧画面にリダイレクトする
    }
}
