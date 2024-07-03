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

        $keyword = $request->input('keyword'); //商品名の値
        $company_id = $request->input('company_id'); //会社名の値

        $query = Product::query();
       
        if ($request->has('keyword')) {
            $query->where('product_name', 'like', '%' . $keyword . '%');
            }
       
        if (isset($company_id)) {
            $query->where('company_id', $company_id);
        }

        
        $products = $query->with('company')->orderBy('id', 'asc')->paginate(10);

        $companies = Company::pluck('company_name', 'id')->toArray();

        return view('products.index', compact('companies', 'products'));
         
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
    public function store(ArticleRequest $request)
    {  // 画像の保存
        try {
            $filename = null;
            if ($request->hasFile('img_path')) {
                $file = $request->file('img_path');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('images'), $filename);
                
            }

            $product = new Product;
            $product->product_name = $request->product_name;
            $product->price = $request->price;
            $product->company_id = $request->company_id;
            $product->stock = $request->stock;
            $product->comment = $request->comment;
            $product->img_path = $filename ? 'images/' . $filename : null;
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
            $product->product_name = $request['product_name'];
            $product->company_id = $request['company_id'];
            $product->price = $request['price'];
            $product->stock = $request['stock'];
            $product->comment = $request['comment'];

            if ($request->hasFile('img_path')) {
                $file = $request->file('img_path');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('images'), $filename);
                $product->img_path = 'images/' . $filename;
            
            
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
