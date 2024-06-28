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
        * @param  \Illuminate\Http\Request  $request
        * @return \Illuminate\Http\Response
        */
        public function index(Request $request)
        {

             //入力される値nameの中身を定義する
        $keyWord = $request->input('keyWord'); //商品名の値
        $company_id = $request->input('company_id'); //カテゴリの値

        $query = Product::query();
        //商品名が入力された場合、productsテーブルから一致する商品を$queryに代入
        if ($request->has('keyword')) {
                $keyword = $request->input('keyword');
                $query->where('product_name', 'like', '%' . $keyword . '%');
            }
        //カテゴリが選択された場合、m_categoriesテーブルからcategory_idが一致する商品を$queryに代入
        if (isset($company_id)) {
            $query->where('company_id', $company_id);
        }

        //$queryをcategory_idの昇順に並び替えて$productsに代入
        $products = $query->with('company')->orderBy('company_id', 'asc')->paginate(15);

        //m_categoriesテーブルからgetLists();関数でcategory_nameとidを取得する
        $company = new Company;
        $companies = Company::pluck('company_name', 'id')->toArray();

        return view('products.index', compact('companies', 'products'));
         
    }

     // escapeLike関数の定義
     protected static function escapeLike($value)
     {
         return str_replace(['\\', '%', '_'], ['\\\\', '\\%', '\\_'], $value);
     }
 
            

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
    public function store(Request $request)
    {
        // バリデーション
        $request->validate([
            'product_name' => 'required',
            'price' => 'required|numeric',
            'company_id' =>  'required',
            'stock' => 'required|integer',
            'comment' => 'nullable',
            'img_path' => 'nullable|image'
        ]);

        
        // 画像の保存
        $filename = null;
        if ($request->hasFile('img_path')) {
            $filename = $request->img_path->store('public/images');
        }


        // 商品情報の保存
        $product = new Product;
        $product->product_name = $request->product_name;
        $product->price = $request->price;
        $product->company_id = $request->company_id;
        $product->stock = $request->stock;
        $product->comment = $request->comment;
        $product->img_path = $filename;
        $product->save();
        

        // 登録完了後、自画面にリダイレクト
        return redirect()->route('products.create')->with('success', '商品が登録されました。');
       
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
    public function update(Request $request, $id)
    {
        // バリデーションの追加（必要に応じて）
        $validatedData = $request->validate([
        'product_name' => 'required|max:255',
        'company_id' => 'required|integer',
        'price' => 'required|numeric',
        'stock' => 'required|numeric',
        'comment' => 'nullable|string',
        'img_path' => 'nullable|image|max:2048',
        ]);

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
