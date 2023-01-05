@extends('layout.master')
@section('content')
<div class="inner-header">
    <div class="container">
        <div class="pull-left">
            <h6 class="inner-title">Product</h6>
        </div>
        <div class="pull-right">
            <div class="beta-breadcrumb font-large">
                <a href="index.html">Home</a> / <span>Product</span>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
</div>

<div class="container">
    <div id="content">
        <div class="row">
            <div class="col-sm-9">

                <div class="row">
                    <div class="col-sm-4">
                        <img src="resources/frontend/image/product/{{$product->image}}" alt="">
                    </div>
                    <div class="col-sm-8">
                        <div class="single-item-body">
                            <p class="single-item-title">{{$product->name}}</p>
                            <p class="single-item-price">
                                @if ($product->promotion_price != 0)
                                <span class="flash-del">{{$product->unit_price}} vnd</span>
								<span class="flash-sale">{{$product->promotion_price}} vnd</span>
                                @else
                                <span>{{$product->unit_price}} vnd</span>
                                @endif
                            </p>
                        </div>

                        <div class="clearfix"></div>
                        <div class="space20">&nbsp;</div>

                        <div class="single-item-desc">
                            <p>{{$product->description}}</p>
                        </div>
                        <div class="space20">&nbsp;</div>
                        <form action="{{route('addtocart',$product->id)}}" method="get">
                            @csrf
                            <p>Options:</p>
                        <div class="single-item-options">
                            <select class="wc-select" name="unit">
                                <option>Size</option>
                                <option value="cái" {{$product->unit == "cái" ? "selected":""}}>Cái</option>
                                <option value="hộp" {{$product->unit == "hộp" ? "selected":""}}>Hộp</option>

                            </select>
                            <input name="qty" type="number" id="qty" value="1">
                            <button class="add-to-cart" type="submit"><i class="fa fa-shopping-cart"></i></button>

                            <div class="clearfix"></div>
                        </div>
                    </form>
                    </div>
                </div>

                <div class="space40">&nbsp;</div>
                <div class="woocommerce-tabs">
                    <ul class="tabs">
                        <li><a href="#tab-description">Description</a></li>
                        <li><a href="#tab-reviews">Reviews (0)</a></li>
                    </ul>

                    <div class="panel" id="tab-description">
                        <p>Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet.</p>
                        <p>Consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequaturuis autem vel eum iure reprehenderit qui in ea voluptate velit es quam nihil molestiae consequr, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur? </p>
                    </div>
                    <div class="panel" id="tab-reviews">
                        <p>No Reviews</p>
                    </div>
                </div>
                <div class="space50">&nbsp;</div>
                <div class="beta-products-list">
                    <h4>Related Products</h4>

                    <div class="row">
                        @foreach ($rela_product as $item)
                        <div class="col-sm-4">
                            <div class="single-item">
                                <div class="single-item-header">
                                    <a href="{{route('chitiet',$item->id)}}"><img src="resources/frontend/image/product/{{$item->image}}" height="100" alt=""></a>
                                </div>
                                <div class="single-item-body">
                                    <p class="single-item-title">{{$item->name}}</p>
                                    <p class="single-item-price">
                                        @if ($item->promotion_price != 0)
                                        <span class="flash-del" style="font-size: 14px;">{{$item->unit_price}} vnd</span>
										<span class="flash-sale" style="font-size: 14px;">{{$item->promotion_price}} vnd</span>
                                        @else
                                        <span style="font-size: 14px;">{{$item->unit_price}} vnd</span>
                                        @endif
                                    </p>
                                </div>
                                <div class="single-item-caption">
                                    <a class="add-to-cart pull-left" href="{{route('addtocart',$item->id)}}"><i class="fa fa-shopping-cart"></i></a>
                                    <a class="beta-btn primary" href="{{route('chitiet',$item->id)}}">Details <i class="fa fa-chevron-right"></i></a>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        {{$rela_product->links()}}
                    </div>
                </div> <!-- .beta-products-list -->
            </div>
            <div class="col-sm-3 aside">
                <div class="widget">
                    <h3 class="widget-title">Best Sellers</h3>
                    <div class="widget-body">
                        <div class="beta-sales beta-lists">
                            @foreach ($topsell as $item)
                            <div class="media beta-sales-item">
                                <a class="pull-left" href="{{route('chitiet',$item->id_product)}}l"><img src="resources/frontend/image/product/{{$item->product->image}}" alt=""></a>
                                <div class="media-body">
                                    {{$item->product->name}}<br>
                                    @if ($item->product->promotion_price != 0)
                                    <span class="flash-del" style="font-size: 14px;">{{$item->product->unit_price}} vnd</span><br>
									<span class="flash-sale" style="font-size: 14px;">{{$item->product->promotion_price}} vnd</span>
                                    @else
                                    <span style="font-size: 14px;">{{$item->product->unit_price}} vnd</span>
                                    @endif
                                </div>

                            </div>
                            @endforeach
                        </div>
                    </div>
                </div> <!-- best sellers widget -->
                <div class="widget">
                    <h3 class="widget-title">New Products</h3>
                    <div class="widget-body">
                        <div class="beta-sales beta-lists">
                            @foreach ($new_product as $item)
                            <div class="media beta-sales-item">
                                <a class="pull-left" href="{{route('chitiet',$item->id)}}"><img src="resources/frontend/image/product/{{$item->image}}" alt=""></a>
                                <div class="media-body">
                                    {{$item->name}}<br>
                                    @if ($item->promotion_price != 0)
                                    <span class="flash-del" style="font-size: 14px;">{{$item->unit_price}} vnd</span><br>
									<span class="flash-sale" style="font-size: 14px;">{{$item->promotion_price}} vnd</span>
                                    @else
                                    <span style="font-size: 14px;">{{$item->unit_price}} vnd</span>
                                    @endif
                                </div>
                            </div>

                            @endforeach

                        </div>
                    </div>
                </div> <!-- best sellers widget -->
            </div>
        </div>
    </div> <!-- #content -->
</div> <!-- .container -->

@endsection
