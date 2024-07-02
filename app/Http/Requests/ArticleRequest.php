<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
        'product_name' => 'required|max:255',
        'company_id' => 'required|integer',
        'price' => 'required|numeric',
        'stock' => 'required|numeric',
        'comment' => 'nullable|string',
        'img_path' => 'nullable|image|max:2048',
        
        ];
    }


    public function attributes()
    {
        return [
        'product_name' => '商品名',
        'company_id' => 'メーカー名',
        'price' => '価格',
        'stock' => '在庫数',
        'comment' => 'コメント',
        'img_path' => '商品画像',  
        ];
    }


    public function messages()
    {
        return [
            'product_name.required' => '商品名は必須項目です。',
            'company_id.required' => '会社の選択は必須項目です。',
            'price.required' => '価格は必須項目です。',
            'price.numeric' => '価格は数値でなければなりません。',
            'stock.required' => '在庫数は必須項目です。',
            'stock.numeric' => '在庫数は数値でなければなりません。',
            'img_path.image' => '画像ファイルを選択してください。',
            'img_path.max' => '画像ファイルのサイズは2MB以下でなければなりません。',
        ];
    }
}
