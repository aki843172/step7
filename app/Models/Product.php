<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_name', 'price', 'company_id', 'stock', 'comment', 'img_path'
   ];

   protected $table = 'products';

    public function company()
    {
        return $this->belongsTo(Company::class,'company_id');
    }
    
    
    public function sales()
    {
        return $this->hasMany('App\Models\Sale');
    }
    
}
