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
                return redirect('admin/slide/themslide')->with('loi','Bạn chỉ được thêm file có đuôi jpg,png,jpeg,webp');
            }
            $name=$file->getClientOriginalName();
            $hinh = "slide".random_int(0,9)."_".$name;
            while(file_exists('resources/frontend/image/slide/'.$hinh)){
                $hinh = "slide".random_int(0,9)."_".$name;
            };
            $file->move('resources/frontend/image/slide/',$hinh);
            $slide->image=$hinh;
        }else{
            return redirect('admin/slide/themslide')->with('loi','Bạn phải thêm hình');
        };
        $slide->updated_at= date("Y-m-d H:i:s");
        $slide->created_at= date("Y-m-d H:i:s");
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
            while(file_exists('resources/frontend/image/slide/'.$hinh)){
                $hinh = "hinhmoi".random_int(0,9)."_".$name;
            };
            $file->move('resources/frontend/image/slide/',$hinh);
            $slide->image=$hinh;
        }else{
            return redirect('admin/product/themsanpham')->with('loi','Bạn phải thêm hình');
        };
        $slide->updated_at= date("Y-m-d H:i:s");
        $slide->link = $req["link"] != null?$req["link"]:"";
        $slide->save();
        return redirect()->back()->with('thongbao','Sửa Silde Thành công');
    }
    function xoaSlide($id){
        $slide = Slide::find($id);
        $slide->delete();
        return redirect()->back()->with('thongbao','Xóa Silde Thành công');
    }
    function getThemLoai(){
        return view('admin.Type.themloai');
    }
    function postThemLoai(Request $req){
        $req->validate([
            "name"=>"required",
            "des"=>"required",
        ],[
            "name.required"=>"Vui lòng nhập tên loại",
            "des.required"=>"Vui lòng mô tả sản phẩm"
        ]);
        $type = new ProductType();
        $type->name = $req['name'];
        $type->description = $req['des'];
        if($req->hasFile('fImages')){
            $file = $req->file('fImages');
            $duoi = $file->getClientOriginalExtension();
            if($duoi != 'jpg' && $duoi != 'png' && $duoi != 'jpeg' && $duoi != 'webp'){
                return redirect('admin/type/themloai')->with('loi','Bạn chỉ được thêm file có đuôi jpg,png,jpeg,webp');
            }
            $name=$file->getClientOriginalName();
            $hinh = "hinhmoi".random_int(0,9)."_".$name;
            while(file_exists('resources/frontend/image/product/'.$hinh)){
                $hinh = "hinhmoi".random_int(0,9)."_".$name;
            };
            $file->move('resources/frontend/image/product/',$hinh);
            $type->image=$hinh;
        }else{
            return redirect('admin/type/themloai')->with('loi','Bạn phải thêm hình');
        };
        $type->save();
        return redirect()->back()->with('thongbao','Thêm loại sản phẩm thành công');
    }
    function getSuaLoai($id){
        $type = ProductType::find($id);
        return view('admin.Type.sualoai',compact('type'));
    }
    function postSuaLoai(Request $req){
        $req->validate([
            "name"=>"required",
            "des"=>"required",
        ],[
            "name.required"=>"Vui lòng nhập tên loại",
            "des.required"=>"Vui lòng mô tả sản phẩm"
        ]);
        $type = ProductType::find($req['id']);
        $type->name = $req['name'];
        $type->description = $req['des'];
        if($req->hasFile('fImages')){
            $file = $req->file('fImages');
            $duoi = $file->getClientOriginalExtension();
            if($duoi != 'jpg' && $duoi != 'png' && $duoi != 'jpeg' && $duoi != 'webp'){
                return redirect('admin/type/editloai')->with('loi','Bạn chỉ được thêm file có đuôi jpg,png,jpeg,webp');
            }
            $name=$file->getClientOriginalName();
            $hinh = "hinhmoi".random_int(0,9)."_".$name;
            while(file_exists('resources/frontend/image/product/'.$hinh)){
                $hinh = "hinhmoi".random_int(0,9)."_".$name;
            };
            $file->move('resources/frontend/image/product/',$hinh);
            $type->image=$hinh;
        }else{
            return redirect('admin/type/editloai')->with('loi','Bạn phải thêm hình');
        };
        $type->save();
        return redirect()->back()->with('thongbao','Sửa loại sản phẩm thành công');
    }
    function getThemUser(){
        return view('admin.User.themnguoidung');
    }
    function postThemUser(Request $req){
        $req->validate([
            "fullname" => "required",
            "email" => "required|email",
            "pass1" => "required|min:6",
            "pass2" => "same:pass1",
            "phone" => "required|numeric",
            "address" => "required"
        ],[
            "fullname.required" => "Vui lòng nhập họ và tên người dùng",
            "email.required" => "Vui lòng nhập email người dùng",
            "pass1.required" => "Vui lòng nhập password",
            "pass1.min" => "Mật khẩu phải nhiều hơn 6 chữ cái",
            "pass2.same" => "Mật khẩu nhập lại không khớp",
            "phone.required" => "Vui lòng nhập số điện thoại",
            "phone.numeric" => "Số điện thoại không đúng",
            "address.required" => "Vui lòng nhập địa chỉ người dùng"
        ]);
        $user = new User();
        $user->full_name = $req['fullname'];
        $user->email = $req['email'];
        $user->password = $req['pass2'];
        $user->phone = $req["phone"];
        $user->address = $req["address"];
        $user->save();
        return redirect()->back()->with('thongbao','Thêm người dùng thành công');
    }
    function getSuaUser($id){
        $user = User::find($id);
        return view('admin.User.suanguoidung',compact('user'));
    }
    function postSuaUser(Request $req){
        $req->validate([
            "fullname" => "required",
            "email" => "required|email",
            "pass1" => "required|min:6",
            "pass2" => "same:pass1",
            "phone" => "required|numeric",
            "address" => "required"
        ],[
            "fullname.required" => "Vui lòng nhập họ và tên người dùng",
            "email.required" => "Vui lòng nhập email người dùng",
            "pass1.required" => "Vui lòng nhập password",
            "pass1.min" => "Mật khẩu phải nhiều hơn 6 chữ cái",
            "pass2.same" => "Mật khẩu nhập lại không khớp",
            "phone.required" => "Vui lòng nhập số điện thoại",
            "phone.numeric" => "Số điện thoại không đúng",
            "address.required" => "Vui lòng nhập địa chỉ người dùng"
        ]);
        $user = User::find($req->id);
        $user->full_name = $req['fullname'];
        $user->email = $req['email'];
        $user->password = bcrypt($req['pass2']);
        $user->phone = $req["phone"];
        $user->address = $req["address"];
        $user->save();
        return redirect()->back()->with('thongbao','Sửa người dùng thành công');
    }
    function xoaUser($id){
        $user = User::find($id);
        $user->delete();
        return redirect()->back()->with('thongbao',"Xóa người dùng thành công");
    }
}
