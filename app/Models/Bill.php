<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use HasFactory;
    protected $table = "bills";
    protected $primaryKey="id";
    protected $timestraps=false;
    public function bill_detail(){
        return $this->hasMany(Bill_Detail::class,"id_bill","id");
    }
    public function customer(){
        return $this->belongsTo(Customer::class,"id_customer","id");
    }
}
