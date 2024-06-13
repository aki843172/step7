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
        $products = Product::with('company')->get(); // すべての商品データを取得（リレーション込み）
        
        return view('products.index', compact('companies', 'products'));
        
    }

    
   




    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function create()
    {
       
        $companies = Company::all(); // すべての会社データを取得
        return view('products.create', compact('companies'));
    }

    

    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function store(Request $request)
    {
        // バリデーション
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'manufacturer' => 'required',
            'stock' => 'required|integer',
            'comment' => 'nullable',
            'image' => 'required|image'
        ]);

        
        // 画像の保存
        if ($request->hasFile('image')) {
            $filename = $request->image->store('public/images');
        }


        // 商品情報の保存
        $product = new Product;
        $product->name = $request->name;
        $product->price = $request->price;
        $product->company_name = $request->company_name;
        $product->stock = $request->stock;
        $product->comment = $request->comment;
        $product->image = $filename;
        $product->save();
        

        // 登録完了後、自画面にリダイレクト
        return redirect()->route('products.create')->with('success', '商品が登録されました。');
        //新規商品情報をデータベースに保存するためのメソッド
        //通常、これはフォームから送信されたデータを取得し、それをデータベースに保存する
        //これは、商品を登録した後に再び商品登録フォームのページへリダイレクトし、さらに success という名前で成功メッセージを
        //セッションにフラッシュ（一時的に保存）します。
        //これにより、ユーザーは同じフォームで複数の商品を連続して登録することが可能になり、
        //登録が成功したことを知らせるメッセージも表示されます。
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
        // バリデーションの追加（必要に応じて）
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'manufacturer' => 'required',
            'stock' => 'required|integer',
            'comment' => 'nullable',
            'image' => 'nullable|image'
        ]);

        $product = Product::find($id);

        // 商品情報の更新
        $product->name = $request->name;
        $product->price = $request->price;
        $product->manufacturer = $request->manufacturer;
        $product->stock = $request->stock;
        $product->comment = $request->comment;

    // 画像の更新（必要に応じて）
        if ($request->hasFile('image')) {
            $filename = $request->image->store('public/images');
            $product->image = $filename;
        }

        $product->save();
        return redirect()->route('products.show',['id' => $id])->with('success', '商品情報が更新されました。');
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
        return redirect()->route('products.index')->with('success', '商品を削除しました。');
        //商品情報を削除するためのメソッド。該当の商品をデータベースから削除し、一覧画面にリダイレクトする
    }
}
