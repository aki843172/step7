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
        $price_min = $request->input('price_min'); // 価格下限
        $price_max = $request->input('price_max'); // 価格上限
        $stock_min = $request->input('stock_min'); // 在庫下限
        $stock_max = $request->input('stock_max'); // 在庫上限
        $sort = $request->input('sort', 'id');
        $direction = $request->input('direction', 'desc');


        $query = Product::query();
       
        if ($request->has('keyword')) {
            $query->where('product_name', 'like', '%' . $keyword . '%');
            }
       
        if (isset($company_id)) {
            $query->where('company_id', $company_id);
        }

        if (isset($price_min)) {
            $query->where('price', '>=', $price_min);
        }

        if (isset($price_max)) {
            $query->where('price', '<=', $price_max);
        }

        if (isset($stock_min)) {
            $query->where('stock', '>=', $stock_min);
        }

        if (isset($stock_max)) {
            $query->where('stock', '<=', $stock_max);
        }


        
        $products = $query->with('company')->orderBy($sort, $direction)->paginate(10);

        if ($request->ajax()) {
            return view('products.partials.product_list', compact('products'))->render();
        }

        $companies = Company::pluck('company_name', 'id')->toArray();

        return view('products.index', compact('companies', 'products', 'sort', 'direction'));
         
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

            
            if ($request->has('delete_img') && $product->img_path) {
                $img_path = public_path($product->img_path);
                if (file_exists($img_path)) {
                    unlink($img_path);
                }
                $product->img_path = null;
            }
        
            // 新しい画像のアップロード
            if ($request->hasFile('img_path')) {
                $file = $request->file('img_path');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('images'), $filename);
        
                // 古い画像を削除
                if ($product->img_path) {
                    $old_img_path = public_path($product->img_path);                        
                    if (file_exists($old_img_path)) {
                        unlink($old_img_path);
                    }
                }
        
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
            $product = Product::findOrFail($id);
            $product->delete();
    
            if (request()->ajax()) {
                return response()->json(['success' => true]);
            }
    
            return redirect()->route('products.index')->with('success', '商品を削除しました。');
        } catch (Exception $e) {
            if (request()->ajax()) {
                return response()->json(['error' => '商品の削除中にエラーが発生しました。'], 500);
            }
    
            return redirect()->route('products.index')->with('error', '商品の削除中にエラーが発生しました。');
        }
    }
 
}