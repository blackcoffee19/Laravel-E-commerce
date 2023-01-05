<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $table="customer";
    protected $primaryKey="id";
    protected $timestraps=false;
    public function bill(){
        return $this->hasMany(Bill::class,"id_customer","id");
    }
}
