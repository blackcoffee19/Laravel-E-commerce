<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Bill_Detail;
use App\Models\Customer;
use App\Models\Product;
use App\Models\ProductType;
use App\Models\Slide;
use App\Models\Cart;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PageController extends Controller
{
    function getTrangchu(){
        $slide = Slide::all();
        $product_new = Product::where('new','=',1)->paginate(4,['*'],'pagenew');
        $product_top = Product::paginate(8,['*'],'pagenor');
        $product = Product::all();
        return view('pages.trangchu',compact('slide','product_new','product_top','product'));
    }
    function getLoaisp(){
        return view('pages.loaisanpham');
    }
    function chitietSP($id){
        $product=Product::where('id','=',$id)->first();
        $rela_product = Product::where('id_type','=',$product->id_type)->where('id','!=',$id)->paginate(3);
        $new_product=Product::where('new','=',1)->limit(4)->get();
        $topsell = Bill_Detail::selectRaw("id_product,sum(quantity) as total")->groupBy('id_product')->orderByDesc("total")->take(4)->get();
        return view('pages.chitietsanpham',compact('product','rela_product','new_product','topsell'));
    }
    function lienhe(){
        return view('pages.lienhe');
    }
    function gioithieu(){
        return view('pages.gioithieu');
    }
    function getLoaiBanh($id){
        $products_new = Product::where('id_type','=',$id)->where('new','=',1)->get();
        $product=Product::where('id_type','=',$id)->get();
        $loaibanh= ProductType::all();
        $loai = ProductType::where('id','=',$id)->first();
        return view('pages.loaisanpham',compact('products_new','product','loaibanh','loai'));
    }
    function getDatHang(){
        return view("pages.dathang");
    }
    function postDatHang(Request $req){
        $cart = Session::get('cart');
        $cus = new Customer();
        $cus->name = $req->name;
        $cus->gender = $req->gender;
        $cus->email = $req->email;
        $cus->address = $req->address;
        $cus->phone_number = $req->phone_number;
        $cus->note= $req->note ? $req->note : "None";
        $cus->save();
        $bill = new Bill();
        $bill->id_customer=$cus->id;
        $bill->date_order=date('Y-m-d');
        $bill->total=$cart->totalPrice;
        $bill->payment=$req->payment_method;
        $bill->note=$req->note;
        $bill->save();
        foreach($cart->items as $key=>$value){
            $bd= new Bill_Detail();
            $bd->id_bill =$bill->id;
            $bd->id_product = $key;
            $bd->quantity = $value['qty'];
            $bd->unit_price=($value['price']/$value['qty']);
            $bd->save();
        }
        Session::forget('cart');
        return view("pages.notity");
    }
    function themgiohang(Request $req,$id){
        //Session::forget('cart');
        if($req->qty){
            $item = Product::find($id);
            $arr_cart = new Cart(Session::get('cart'));
            $arr_cart->add($item,$id,intval($req->qty));
            Session::put('cart',$arr_cart);
        }else{
            $item = Product::find($id);
            $arr_cart = new Cart(Session::get('cart'));
            $arr_cart->add($item,$id);
            Session::put('cart',$arr_cart);
        }
        return redirect()->back();
    }
    function minusItem($id){
        $arr_cart = new Cart(Session::get('cart'));
        $arr_cart->reduceByOne($id);
        Session::put('cart',$arr_cart);
        return redirect()->back();
    }
    function getDangNhap(){
        return view('pages.dangnhap');
    }
    function getDangKy(){
        return view('pages.dangky');
    }
    function postDangNhap(Request $req){
        $val = $req->validate([
            "email"=> "required|email",
            "password"=>"required"
        ],[
            "email.required"=>"Ch??a nh???p email",
            "email.email"=>"Email kh??ng h???p l???",
            "password.required"=>"Ch??a nh???p password"
        ]);
        $chungthuc = array('email'=>$val['email'], 'password' => $val['password']);
        if(Auth::attempt($chungthuc)){
            return redirect('index');
        }else{
            return redirect()->back()->with(["matb"=>'0',"noidung"=>"????ng nh???p th???t b???i"]);
        }
    }
    function postDangKy(Request $req){
        $this->validate($req,[
            "email" => "required|email|unique:users",
            "password" => "required|min:6|max:20",
            "repassword" => "required|same:password",
            "address" => "required",
            "fullname" => "required"
        ],[
            "email.required" => "Vui l??ng nh???p ?????a ch??? th??",
            "email.email" => "?????a ch??? th?? kh??ng ????ng ?????nh d???ng",
            "email.unique" => "Email n??y ???? c?? ng?????i ????ng k??",
            "password.required" => "Ch??a nh???p m???t kh???u",
            "password.min" => "M???t kh???u t???i thi???u 6 k?? t???",
            "password.max" => "M???t kh???u t???i ??a 20 k?? t???",
            "repassword.required" => "Ch??a nh???p l???i m???t kh???u",
            "repassword.same" => "M???t kh???u kh??ng gi???ng nhau",
            "address.required" => "Ch??a nh???p l???i m???t kh???u",
            "fullname.required" => "Ch??a nh???p h??? v?? t??n"
        ]);
        $user =  new User;
        $user->full_name = $req->fullname;
        $user->email = $req->email;
        $user->password = Hash::make($req->password);
        $user->phone = $req->phone;
        $user->address = $req->address;
        $user->save();
        return redirect()->back()->with("thongbao","????ng k?? th??nh c??ng");
    }
    public function getDangXuat(){
        Auth::logout();
        return redirect("index");
    }
    public function getTimKiem(Request $req){
        $product = Product::where("name","like","%".$req->key."%")->orWhere(["unit_price"=>$req->key])->get();
        // dd($product);
        return view("pages.timkiem",compact("product"));
    }
}
