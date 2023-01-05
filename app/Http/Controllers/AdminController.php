<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Bill_Detail;
use App\Models\Customer;
use App\Models\Product;
use App\Models\ProductType;
use App\Models\Slide;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    function getDanhsachDonhang(){
        $bills = Bill::all()->sortBy('status');
        return view('admin.Bill.dsdonhang',compact('bills'));
    }
    function suaDonHang($id){
        $bill = Bill::find($id);
        return view('admin.Bill.suadonhang',compact('bill'));
    }
    function postsuaDH(Request $req){
        $bill = Bill::find($req->id);
        $bill->status = $req->bill_status;
        $bill->save();
        return redirect()->back()->with('thongbao',"Đã sửa thành công");
    }
    function chitietDH($id){
        $bill_detail = Bill_Detail::where('id_bill','=',$id)->get();
        $bill_t = Bill::find($id);
        return view('admin.Bill.chitietdonhang',compact('bill_detail','bill_t'));
    }
    function getDanhsachCustomer(){
        $customers = Customer::all();
        return view('admin.Customer.danhsachkh',compact('customers'));
    }
    function getDanhsachSanpham(){
        $products = Product::all();
        return view('admin.Product.danhsachsanpham',compact('products'));
    }
    function getdsSlide(){
        $slides = Slide::all();
        return view('admin.Slide.danhsachslide',compact('slides'));
    }
    function getLoaiSanpham(){
        $types = ProductType::all();
        return view('admin.Type.danhsachloaisp',compact('types'));
    }
    function getdsuser(){
        $users = User::all();
        return view('admin.User.danhsachnguoidung',compact('users'));
    }
    function getDangNhap(){
        return view('admin.dangnhap');
    }
    function postDangNhap(Request $req){
        $req->validate([
            "email"=>"required|email",
            "password"=>"required"
        ],[
            "email.required"=>"Bạn chưa nhập email",
            "email.email"=>"Email không đúng định dạng",
            "password.required"=>"Chưa nhập mật khẩu"
        ]);
        $chungthuc = array('email'=>$req->email,'password'=>$req->password);
        if(Auth::attempt($chungthuc)){
            return redirect("admin/bills/list");
        }else{
            return redirect()->back()->with(['matb'=>'0','noidung'=>'Đăng nhập thất bại']);
        }
    }
    function getUserInfo(){
        if(Auth::check()){
            return view('admin.thongtin');
        }else{
            return redirect('admin.login');
        }
    }
    function getLogOut(){
        Auth::logout();
        return redirect("admin/login");
    }
    function getThemSanPham(){
        $type_pro = ProductType::all();
        return view('admin.Product.themsanpham',compact('type_pro'));
    }
    function postThemSanPham(Request $req){
        $req->validate([
            "namePro" => "required",
            "loaisp" => "required",
            "price" => "required|numeric|min:1000",
            "pro_price" => "numeric",
            "unit"=> "required",
            "rdoStatus" => "required"
        ],[
            "namePro.required" => "Vui lòng nhap tên sảm phẩm",
            "loaisp.required"=> "Vui lòng chọn loại sản phẩm",
            "price.required"=>"Vui lòng nhập giá sản phẩm",
            "price.numeric"=>"Giá sản phẩm không có chuỗi ký tự",
            "price.min"=>"Giá phải lớn hơn 1000 đồng",
            "pro_price.numeric"=>"Giá sản phẩm không có chuỗi ký tự",
            "unit.required"=>"Vui lòng nhập đơn vị tính",
            "rdoStatus.required"=>"Vui lòng chọn tình trạng sản phẩm"
        ]);
        $pro = new Product();
        $pro->name = $req["namePro"];
        $pro->id_type  =$req["loaisp"];
        $pro->description = $req["des"];
        $pro->unit_price = $req["price"];
        $pro->promotion_price = $req["pro_price"];
        $pro->image = $req["fImages"];
        $pro->unit = $req["unit"];
        $pro->new = $req["rdoStatus"];
        if($req->hasFile('fImages')){
            $file = $req->file('fImages');
            $duoi = $file->getClientOriginalExtension();
            if($duoi != 'jpg' && $duoi != 'png' && $duoi != 'jpeg' && $duoi != 'webp'){
                return redirect('admin/product/themsanpham')->with('loi','Bạn chỉ được thêm file có đuôi jpg,png,jpeg,webp');
            }
            $name=$file->getClientOriginalName();
            $hinh = "hinhmoi".random_int(0,9)."_".$name;
            while(file_exists('resources/frontend/image/product/'.$hinh)){
                $hinh = "hinhmoi".random_int(0,9)."_".$name;
            };
            $file->move('resources/frontend/image/product/',$hinh);
            $pro->image=$hinh;
        }else{
            $pro->image = "";
        };
        $pro->save();
        return redirect()->back()->with('thongbao','Thêm thành công');
    }
}
