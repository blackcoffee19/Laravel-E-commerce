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
    function getSuaKhachhang($id){
        $customer = Customer::find($id);
        return view('admin.Customer.suakhachhang',compact('customer'));
    }
    function postSuaKhachhang(Request $req,$id=null){
        $customer = Customer::find($req->id);
        $req->validate([
            "address" => "required",
            "phone" => "required|numeric"
        ],[
            "address.required" =>"Vui lòng nhập địa chỉ",
            "phone.required" => "Vui lòng nhập số điện thoại",
            "phone.numeric"=>"Số điện thoại không hợp lệ"
        ]);
        $customer->phone_number = $req["phone"];
        $customer->address = $req["address"];
        $customer->save();
        return redirect()->back()->with('thongbao',"Cập nhật thành công");
    }
    function getDanhsachSanpham(){
        $products = Product::paginate(5);
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
            "unit"=> "required",
            "rdoStatus" => "required"
        ],[
            "namePro.required" => "Vui lòng nhap tên sảm phẩm",
            "loaisp.required"=> "Vui lòng chọn loại sản phẩm",
            "price.required"=>"Vui lòng nhập giá sản phẩm",
            "price.numeric"=>"Giá sản phẩm không có chuỗi ký tự",
            "price.min"=>"Giá phải lớn hơn 1000 đồng",
            "unit.required"=>"Vui lòng nhập đơn vị tính",
            "rdoStatus.required"=>"Vui lòng chọn tình trạng sản phẩm"
        ]);
        $pro = new Product();
        $pro->name = $req["namePro"];
        $pro->id_type  =$req["loaisp"];
        $pro->description = $req["des"];
        $pro->unit_price = $req["price"];
        $pro->promotion_price = $req["pro_price"] != null ? $req["pro_price"]: 0;
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
    function getSuaSanpham($id){
        $product = Product::find($id);
        $type_pro = ProductType::all();
        return view('admin.Product.suasanpham',compact('product','type_pro'));
    }
    function postSuaSanpham(Request $req){
        $req->validate([
            "namePro"=>"required",
            "loaisp"=>"required",
            "price"=>"required|numeric|min:1000",
            "unit"=>"required",
        ],[
            "namePro.required"=>"Vui lòng nhập tên sản phẩm",
            "loaisp.required"=>"Vui lòng chọn loại sản phẩm",
            "price.required"=>"Vui lòng thêm đơn giá",
            "price.numeric"=>"Đơn giá không hợp lệ",
            "price.min"=>"Đơn giá không nhỏ hơn 1000",
            "unit.required"=>"Vui lòng nhập đơn vị tính",
        ]);
        $product = Product::find($req->id);
        $product->name = $req["namePro"];
        $product->id_type = $req["loaisp"];
        $product->unit_price = $req["price"];
        $product->promotion_price = $req["pro_price"] != null ? $req["pro_price"]: 0;
        $product->description = $req["des"];
        $product->unit = $req["unit"];
        $product->new = $req["rdoStatus"];
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
            $product->image=$hinh;
        }else{
            $product->image = "";
        };
        $product->save();
        return redirect()->back()->with('thongbao',"Sửa sản phẩm thành công");
    }
    function xoaSanPham($id){
        $pro = Product::find($id);
        $pro->delete();
        return redirect()->back()->with('thongbao',"Xóa Sản phẩm thành công");
    }
    function getThemSlide(){
        return view('admin.Slide.themslide');
    }
    function postThemSlide(Request $req){
        $slide =  new Slide();
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
            $slide->image=$hinh;
        }else{
            return redirect('admin/product/themsanpham')->with('loi','Bạn phải thêm hình');
        };
        $slide->link = $req["link"] != null?$req["link"]:"";
        $slide->save();
        return redirect()->back()->with('thongbao','Thêm Silde Thành công');
    }
    function getSuaSlide($id){
        $slide = Slide::find($id);
        return view('admin.Slide.suaslide',compact('slide'));
    }
    function postSuaSlide (Request $req){
        $slide = Slide::find($req->id);
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
            $slide->image=$hinh;
        }else{
            return redirect('admin/product/themsanpham')->with('loi','Bạn phải thêm hình');
        };
        $slide->link = $req["link"] != null?$req["link"]:"";
        $slide->save();
        return redirect()->back()->with('thongbao','Sửa Silde Thành công');
    }
    function getThemLoai(){
        return view('admin.Type.themloai');
    }
    function postThemLoai(Request $req){

        return view('admin.Type.themloai');
    }
}
