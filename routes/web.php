<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoaiBanh;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;
use App\Models\Bill;
use App\Models\Bill_Detail;
use App\Models\Customer;
use App\Models\Product;
use App\Models\ProductType;
use App\Models\Slide;
use App\Models\User;
use App\Http\Middleware\AdminLogin;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/index',[PageController::class,'getTrangchu'])->name('trangchu');
Route::get('/loaisanpham',[PageController::class,'getLoaisp'])->name('loaisp');
Route::get('/chitiet/{id}',[PageController::class,'chitietSP'])->name('chitiet');
Route::get('/lienhe',[PageController::class,'lienhe'])->name('lienhe');
Route::get('/gioithieu',[PageController::class,'gioithieu'])->name('gioithieu');
Route::get('/loaibanh/{id}',[PageController::class,'getLoaiBanh'])->name('loaibanh');
Route::get('/themgiohang/{id}',[PageController::class,'themgiohang'])->name('addtocart');
Route::get('/orderitem',[PageController::class,'getDathang'])->name('orderitem');
Route::post('/orderitem',[PageController::class,'postDatHang'])->name('orderitem');;
Route::get('/minusItem/{id}',[PageController::class,'minusItem'])->name('minusItem');
Route::get('/dangnhap',[PageController::class,'getDangNhap'])->name('dangnhap');
Route::post('/dangnhap',[PageController::class,'postDangNhap'])->name('dangnhap');
Route::get('/dangky',[PageController::class,'getDangKy'])->name('dangky');
Route::post('/dangky',[PageController::class,'postDangKy'])->name('dangky');
Route::get('/dangxuat',[PageController::class,'getDangXuat'])->name('dangxuat');
Route::get('/timkiem',[PageController::class,'getTimKiem'])->name('timkiem');
Route::group(["prefix"=>"admin",'middleware'=>'AdminLogin'],function(){

    Route::group(["prefix"=>"bills"],function(){
        Route::get("/list",[AdminController::class,'getDanhsachDonhang'])->name('billslist');
        Route::get("/edit/{id}",[AdminController::class,'suaDonHang'])->name('editdh');
        Route::post("/edit/{id}",[AdminController::class,'postsuaDH'])->name('editdh');
        Route::get('/detailbill/{id}',[AdminController::class,'chitietDH'])->name('chitietdonhang');
    });
    Route::group(['prefix'=>'customer'],function(){
        Route::get('/customerlist',[AdminController::class,'getDanhsachCustomer'])->name('customerlist');
        Route::get('/editkhachhang/{id?}',[AdminController::class,'getSuaKhachhang'])->name('editkhachhang');
        Route::post('/editkhachhang/{id?}',[AdminController::class,'postSuaKhachhang'])->name('editkhachhang');
    });
    Route::group(['prefix'=>'product'],function(){
        Route::get('/dssanpham',[AdminController::class,'getDanhsachSanpham'])->name('dssanpham');
        Route::get('/themsanpham',[AdminController::class,'getThemSanPham'])->name('themsanpham');
        Route::post('/themsanpham',[AdminController::class,'postThemSanPham'])->name('themsanpham');
        Route::get('/editsanphan/{id?}',[AdminController::class,'getSuaSanpham'])->name('editsanpham');
        Route::post('/editsanphan/{id?}',[AdminController::class,'postSuaSanpham'])->name('editsanpham');
        Route::get('/xoasanpham/{id}',[AdminController::class,'xoaSanPham'])->name('xoasanpham');
    });
    Route::group(["prefix"=>"slide"],function(){
        Route::get('/dsslide',[AdminController::class,'getdsSlide'])->name('dsslide');
        Route::get('/themslide',[AdminController::class,'getThemSlide'])->name('themslide');
        Route::post('/themslide',[AdminController::class,'postThemSlide'])->name('themslide');
        Route::get('/editSlide/{id?}',[AdminController::class,'getSuaSlide'])->name('editslide');
        Route::post('/editSlide/{id?}',[AdminController::class,'postSuaSlide'])->name('editslide');
        Route::get('/xoaslide/{id}',[AdminController::class,'xoaSlide'])->name('xoaslide');
    });
    Route::group(["prefix"=>"type"],function(){
        Route::get('/loaisanpham',[AdminController::class,'getLoaiSanpham'])->name('dsloai');
        Route::get('/themloai',[AdminController::class,'getThemLoai'])->name('themloai');
        Route::post('/themloai',[AdminController::class,'postThemLoai'])->name('themloai');
        Route::get('/editloai/{id?}',[AdminController::class,'getSuaLoai'])->name('editloai');
        Route::post('/editloai/{id?}',[AdminController::class,'postSuaLoai'])->name('editloai');
        Route::get('/xoaloai/{id}',[AdminController::class,'xoaLoai'])->name('xoaloai');
    });
    Route::group(["prefix"=>"user"],function(){
        Route::get('/dsuser',[AdminController::class,'getdsuser'])->name('dsuser');
        Route::get('/themuser',[AdminController::class,'getThemUser'])->name('themuser');
        Route::post('/themuser',[AdminController::class,'postThemUser'])->name('themuser');
        Route::get('/edituser/{id?}',[AdminController::class,'getSuaUser'])->name('edituser');
        Route::post('/edituser/{id?}',[AdminController::class,'postSuaUser'])->name('edituser');
        Route::get('/xoauser/{id}',[AdminController::class,'xoaUser'])->name('xoauser');

    });
});
Route::get("admin/thongtin",[AdminController::class,'getUserInfo'])->name('thongtin');
Route::get("admin/logout",[AdminController::class,'getLogOut'])->name('logout');
Route::get("admin/login",[AdminController::class,'getDangNhap'])->name('dangnhap');
Route::post("admin/login",[AdminController::class,'postDangNhap'])->name('dangnhap');
Route::get('/test',function(){
    $bills = Bill::find(11);
    dd($bills->bill_detail);
});
