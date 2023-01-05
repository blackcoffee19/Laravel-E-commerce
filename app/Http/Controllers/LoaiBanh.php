<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductType;
use Illuminate\Http\Request;

class LoaiBanh extends Controller
{
    function getLoaiBanh($id){
        $products_new = Product::where('id_type','=',$id)->where('new','=',1)->get();
        $product=Product::where('id_type','=',$id)->get();
        $loaibanh= ProductType::all();
        $loai = ProductType::where('id','=',$id)->first();
        return view('pages.loaisanpham',compact('products_new','product','loaibanh','loai'));
    }
}
