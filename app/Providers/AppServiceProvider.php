<?php

namespace App\Providers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\ProductType;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();
        view()->composer('layout.header',function($view){
            $loaibanh = ProductType::all();
            $view->with('loaibanh',$loaibanh);
        });
        view()->composer(['layout.header','pages.dathang'],function($view){
            if(Session('cart')){
                $oldcart = Session::get('cart');
                $cart = new Cart($oldcart);
                $view->with(['cart'=>Session::get('cart'),'product_cart'=>$cart->items,'totalPrice'=>$cart->totalPrice,'totalQty'=>$cart->totalQty]);
            }
        });

    }
}
