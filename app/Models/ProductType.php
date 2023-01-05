<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductType extends Model
{
    use HasFactory;
    protected $table = "type_products";
    protected $primaryKey="id";
    protected $timestraps=false;
    public function product(){
        return $this->hasMany(Product::class,"id_type","id");
    }
}
