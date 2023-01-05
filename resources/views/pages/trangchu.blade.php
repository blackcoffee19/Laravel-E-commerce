@extends('layout.master')
@section('content')
<div class="rev-slider">
	<div class="fullwidthbanner-container">
        <div class="fullwidthbanner">
				<div class="bannercontainer" >
			        <div class="banner" >
                        <ul>
                        @foreach ($slide as $sl)
                            {{-- <li>{{$sl->image}}</li> --}}
                            <li data-transition="boxfade" data-slotamount="20" class="active-revslide" style="width: 100%; height: 100%; overflow: hidden; z-index: 18; visibility: hidden; opacity: 0;">
                                <div class="slotholder" style="width:100%;height:100%;" data-duration="undefined" data-zoomstart="undefined" data-zoomend="undefined" data-rotationstart="undefined" data-rotationend="undefined" data-ease="undefined" data-bgpositionend="undefined" data-bgposition="undefined" data-kenburns="undefined" data-easeme="undefined" data-bgfit="undefined" data-bgfitend="undefined" data-owidth="undefined" data-oheight="undefined">
                                    <div class="tp-bgimg defaultimg" data-lazyload="undefined" data-bgfit="cover" data-bgposition="center center" data-bgrepeat="no-repeat" data-lazydone="undefined" src="resources/frontend/image/slide/{{$sl->image}}" data-src="resources/frontend/image/slide/{{$sl->image}}" style="background-color: rgba(0, 0, 0, 0); background-repeat: no-repeat; background-image: url('resources/frontend/image/slide/{{$sl->image}}'); background-size: cover; background-position: center center; width: 100%; height: 100%; opacity: 1; visibility: inherit;">
                                    </div>
                                </div>
                            </li>
                        @endforeach
				    	</ul>
				    </div>
				</div>
				<div class="tp-bannertimer"></div>
		</div>
	</div>
</div>
	<div class="container">
		<div id="content" class="space-top-none">
			<div class="main-content">
				<div class="space60">&nbsp;</div>
				<div class="row">
					<div class="col-sm-12">
						<div class="beta-products-list">
							<h4>New Products</h4>
							<div class="beta-products-details">
								<p class="pull-left">{{count($product_new)}} styles found</p>
								<div class="clearfix"></div>
							</div>
							<div class="row">
                                @foreach ($product_new as $item)
								<div class="col-sm-3">
									<div class="single-item">
                                        @if ($item->promotion_price != 0)
										<div class="ribbon-wrapper"><div class="ribbon sale">Sale</div></div>
                                        @endif
										<div class="single-item-header">
											<a href="{{route('chitiet',$item->id)}}"><img src="resources/frontend/image/product/{{$item->image}}" alt="" height="200"></a>
										</div>
										<div class="single-item-body">
											<p class="single-item-title">{{$item->name}}</p>
											<p class="single-item-price">
												@if ($item->promotion_price != 0)
                                                <span class="flash-del">{{$item->unit_price}} vnd</span>
												<span class="flash-sale">{{$item->promotion_price}} vnd</span>
                                                @else
                                                <span>{{$item->unit_price}} vnd</span>
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
                                <div class="row">{{$product_new->appends(['pagenor'=>$product_top->currentPage()])->links()}}</div>
                            </div>
						</div> <!-- .beta-products-list -->

						<div class="space50">&nbsp;</div>

						<div class="beta-products-list">
							<h4>Top Products</h4>
							<div class="beta-products-details">
								<p class="pull-left">{{count($product)}} styles found</p>
								<div class="clearfix"></div>
							</div>

							<div class="row">
                                @foreach ($product_top as $item)
								<div class="col-sm-3">
									<div class="single-item" style="margin-bottom: 10px;">
                                        @if ($item->promotion_price != 0)
										<div class="ribbon-wrapper"><div class="ribbon sale">Sale</div></div>
                                        @endif
										<div class="single-item-header">
											<a href="{{route('chitiet',$item->id)}}"><img src="resources/frontend/image/product/{{$item->image}}" height="250"alt=""></a>
										</div>
										<div class="single-item-body">
											<p class="single-item-title">{{$item->name}}</p>
											<p class="single-item-price">
												@if ($item->promotion_price != 0)
                                                <span class="flash-del">{{$item->unit_price}} vnd</span>
												<span class="flash-sale">{{$item->promotion_price}} vnd</span>
                                                @else
                                                <span>{{$item->unit_price}} vnd</span>
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
                                <div class="row">{{$product_top->appends(['pagenew'=>$product_new->currentPage()])->links()}}</div>

							</div>
						</div> <!-- .beta-products-list -->
					</div>
				</div> <!-- end section with sidebar and main content -->
			</div> <!-- .main-content -->
		</div> <!-- #content -->
	</div> <!-- .container -->
@endsection
