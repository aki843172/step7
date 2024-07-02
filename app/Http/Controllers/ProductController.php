<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Company;
use App\Http\Requests\ArticleRequest;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
        /**
        * Display a listing of the resource.
        *
        * @param  \Illuminate\Http\Request  $request
        * @return \Illuminate\Http\Response
        */
        public function index(Request $request)
        {

             //入力される値nameの中身を定義する
        $keyword = $request->input('keyword'); //商品名の値
        $company_id = $request->input('company_id'); //会社名の値

        $query = Product::query();
        //商品名が入力された場合、productsテーブルから一致する商品を$queryに代入
        if ($request->has('keyword')) {
            $query->where('product_name', 'like', '%' . $keyword . '%');
            }
        //カテゴリが選択された場合、companiesテーブルからcompany_idが一致する商品を$queryに代入
        if (isset($company_id)) {
            $query->where('company_id', $company_id);
        }

        //$queryをidの昇順に並び替えて$productsに代入
        $products = $query->with('company')->orderBy('id', 'asc')->paginate(10);

        //companiesテーブルからgetLists();関数でcompany_nameとidを取得する
        
        $companies = Company::pluck('company_name', 'id')->toArray();

        return view('products.index', compact('companies', 'products'));
         
    }

     // escapeLike関数の定義
     //protected static function escapeLike($value)
     //{
        // return str_replace(['\\', '%', '_'], ['\\\\', '\\%', '\\_'], $value);
     //}
 
            

    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function create()
    {
       
        $companies = Company::select('id','company_name')->get();
        return view('products.create', compact('companies'));
    }

    

    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function store(ArticleRequest $request)
    {  // 画像の保存
        try {
            $filename = null;
            if ($request->hasFile('img_path')) {
                $filename = $request->img_path->store('public/images');
            }

            $product = new Product;
            $product->product_name = $request->product_name;
            $product->price = $request->price;
            $product->company_id = $request->company_id;
            $product->stock = $request->stock;
            $product->comment = $request->comment;
            $product->img_path = $filename;
            $product->save();

            return redirect()->route('products.create')->with('success', '商品が登録されました。');
        } catch (Exception $e) {
            return redirect()->route('products.create')->with('error', '商品登録中にエラーが発生しました。');
        }
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
        $companies = Company::all();

        return view('products.edit', compact('product','companies'));
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
    public function update(ArticleRequest $request, $id)
    {

        try {
            $product = Product::findOrFail($id);
            $product->product_name = $validatedData['product_name'];
            $product->company_id = $validatedData['company_id'];
            $product->price = $validatedData['price'];
            $product->stock = $validatedData['stock'];
            $product->comment = $validatedData['comment'];

            if ($request->hasFile('img_path')) {
                $path = $request->file('img_path')->store('public/images');
                $product->img_path = str_replace('public/', 'storage/', $path);
            }

            $product->save();

            return redirect()->route('products.show', $product->id)->with('success', '商品情報が更新されました。');
        } catch (Exception $e) {
            return redirect()->route('products.edit', $id)->with('error', '商品情報の更新中にエラーが発生しました。');
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $product = Product::find($id);
            $product->delete();
            return redirect()->route('products.index')->with('success', '商品を削除しました。');
        } catch (Exception $e) {
            return redirect()->route('products.index')->with('error', '商品の削除中にエラーが発生しました。');
        }
    }
}
