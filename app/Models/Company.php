<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

     protected $table ='companies';
     // プライマリキーが'id'でない場合は、ここで指定
     protected $primaryKey = 'id';

     protected $keyType = 'string'; // プライマリキーのデータ型が文字列の場合、これを設定


     public function getLists()
     {
         $companies =Company::pluck('company_name', 'id');
 
         //return $companies;
     }


    
    public function products()
    {
        return $this->hasMany(Product::class);
    }

}
