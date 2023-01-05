<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table="products";
    protected $primaryKey = "id";
    protected $timestraps=false;
    public function productType(){
        return $this->belongsTo(ProductType::class,"id_type","id");
    }
    public function bill_detail(){
        return $this->hasMany(Bill_Detail::class,"id_product","id");
    }
}
