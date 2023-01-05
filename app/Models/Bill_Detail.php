<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill_Detail extends Model
{
    use HasFactory;
    protected $table ="bill_detail";
    protected $primaryKey="id";
    protected $timestraps=false;
    public function product(){
        return $this->belongsTo(Product::class,"id_product","id");
    }
    public function bill(){
        return $this->hasMany(Bill::class,"id","id_bill");
    }
}
