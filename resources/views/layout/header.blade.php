<div id="header">
    <div class="header-top">
        <div class="container">
            <div class="pull-left auto-width-left">
                <ul class="top-menu menu-beta l-inline">
                    <li><a href=""><i class="fa fa-home"></i> 90-92 Lê Thị Riêng, Bến Thành, Quận 1</a></li>
                    <li><a href=""><i class="fa fa-phone"></i> 0163 296 7751</a></li>
                </ul>
            </div>
            <div class="pull-right auto-width-right">
                <ul class="top-details menu-beta l-inline">
                    @if (Auth::check())
                    <li><a href="{{route('dangxuat')}}"><i class="fa fa-user"></i>{{Auth::user()->full_name}}</a></li>
                    <li><a href="{{route('dangxuat')}}">Đăng xuất</a>
                    @else
                        <li><a href="{{route('dangky')}}">Đăng kí</a></li>
                        <li><a href="{{route('dangnhap')}}">Đăng nhập</a></li>
                    @endif
                    </ul>
            </div>
            <div class="clearfix"></div>
        </div> <!-- .container -->
    </div> <!-- .header-top -->
    <div class="header-body">
        <div class="container beta-relative">
            <div class="pull-left">
                <a href="index.html" id="logo"><img src="resources/frontend/assets/dest/images/logo-cake.png" width="200px" alt=""></a>
            </div>
            <div class="pull-right beta-components space-left ov">
                <div class="space10">&nbsp;</div>
                <div class="beta-comp">
                    <form role="search" method="get" id="searchform" action="{{route('timkiem')}}">
                        @csrf
                        <input type="text" value="" name="key" id="key" placeholder="Nhập từ khóa..." />
                        <button class="fa fa-search" type="submit" id="searchsubmit"></button>
                    </form>
                </div>

                <div class="beta-comp">
                    <div class="cart">
                        <div class="beta-select"><i class="fa fa-shopping-cart"></i> Giỏ hàng (
                            @if (Session::has('cart'))
                                {{Session('cart')->totalQty}}
                            @else
                                trống
                            @endif
                        ) <i class="fa fa-chevron-down"></i></div>
                        <div class="beta-dropdown cart-body">
                            @if (Session::has('cart'))
                                @foreach ($product_cart as $pro)
                                <div class="cart-item">
                                    <div class="media">
                                        <a class="pull-left" href="{{route('chitiet',$pro['item']['id'])}}"><img src="resources/frontend/image/product/{{$pro['item']['image']}}" alt=""></a>
                                        <div class="media-body">
                                            <span class="cart-item-title">{{$pro['item']['name']}}</span>
                                            <span class="cart-item-amount">{{$pro['qty']}}*<span>
                                                @if ($pro['item']['promotion_price']==0)
                                                {{number_format($pro['item']['unit_price'])}}
                                                @else
                                                {{number_format($pro['item']['promotion_price'])}}
                                                @endif
                                            VND </span></span>
                                        </div>
                                        <div class="media-body">
                                            <a href="{{route('addtocart',$pro['item']['id'])}}"><i class="fa-thin fa-plus"></i></a>
                                            <a href="{{route('minusItem',$pro['item']['id'])}}"><i class="fa-thin fa-minus"></i></a>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                <div class="cart-caption">
                                    <div class="cart-total text-right">Tổng tiền: <span class="cart-total-value">{{number_format(Session('cart')->totalPrice)}}</span></div>
                                    <div class="clearfix"></div>
                                    <div class="center">
                                        <div class="space10">&nbsp;</div>
                                        <a href="{{route('orderitem')}}" class="beta-btn primary text-center">Đặt hàng <i class="fa fa-chevron-right"></i></a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div> <!-- .cart -->
                </div>
            </div>
            <div class="clearfix"></div>
        </div> <!-- .container -->
    </div> <!-- .header-body -->
    <div class="header-bottom" style="background-color: #0277b8;">
        <div class="container">
            <a class="visible-xs beta-menu-toggle pull-right" href="#"><span class='beta-menu-toggle-text'>Menu</span> <i class="fa fa-bars"></i></a>
            <div class="visible-xs clearfix"></div>
            <nav class="main-menu">
                <ul class="l-inline ov">
                    <li><a href="{{route('trangchu')}}">Trang chủ</a></li>
                    <li><a href="{{route('loaisp')}}">Sản phẩm</a>
                        <ul class="sub-menu">
                            @foreach ($loaibanh as $lb)
                            <li><a href="{{route('loaibanh',$lb->id)}}">{{$lb->name}}</a></li>
                            @endforeach
                        </ul>
                    </li>
                    <li><a href="{{route('gioithieu')}}">Giới thiệu</a></li>
                    <li><a href="{{route('lienhe')}}">Liên hệ</a></li>
                </ul>
                <div class="clearfix"></div>
            </nav>
        </div> <!-- .container -->
    </div> <!-- .header-bottom -->
</div> <!-- #header -->
