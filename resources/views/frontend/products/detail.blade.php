@extends('frontend.layouts.master')

@section('content')
<section class="bread-crumb">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <ul class="breadcrumb" itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb">
                    <li class="home">
                        <a itemprop="url" href="{{ route('fe.home.index') }}">
                            <span itemprop="title">
                                <i class="fa fa-home"></i>
                            </span>
                        </a>
                        <span>
                            <i class="fa">/</i>
                        </span>
                    </li>
                    <li class="">
                        <a itemprop="url" href="{{ route('fe.home.index') }}">
                            <span itemprop="title">Sản phẩm</span>
                        </a>
                        <span>
                            <i class="fa">/</i>
                        </span>
                    </li>
                    <li class="">
                        <a itemprop="url" href="thoi-trang-nu.html">
                            <span itemprop="title">{{ $productdetail->factory->name }}</span>
                        </a>
                        <span>
                            <i class="fa">/</i>
                        </span>
                    </li>
                    <li>
                        <strong itemprop="title">{{ $productdetail->name }}</strong>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>
<section class="product margin-top-20" itemscope="" itemtype="http://schema.org/Product">
    <div class="container">
        <div class="main-product-page">
            <div class="row">
                <div class="details-product">
                    <div id="content" class="col-sm-12 col-xs-12 col-md-12">
                        <div class="rows">
                            <div class="product-detail-left product-images col-xs-12 col-sm-6 col-md-6 col-lg-6" style="padding-left:5em;">
                                <div class="row">
                                    <!-- product images -->
                                    @php $someArray = json_decode($productdetail->image, true); @endphp
                                    <div class="col_large_default large-image" style="width: 80%;">
                                        <a class="large_image_url checkurl" data-rel="prettyPhoto[product-gallery]">
                                            <div id="zoomWrapper">
                                                    <img
                                                        id="img_01" class="img-responsive"
                                                        alt="{{ $productdetail->name }}"
                                                        src="uploads/images/products/{{ $someArray[0] }}"
                                                        data-zoom-image="uploads/images/products/{{ $someArray[0] }}"
                                                        style="width:100%"
                                                    >
                                                </div>
                                            </a>
                                        <div class="hidden">
                                        </div>
                                    </div>
                                    <div class="product-detail-thumb" >
                                        <div
                                            id="gallery_02"
                                            class="owl-carousel owl-theme thumbnail-product thumb_product_details not-dqowl owl-loaded owl-drag"
                                            style="margin-top: 12px"
                                        >
                                        @foreach (json_decode($productdetail->image) as $item)
                                            <div class="owl-stage-outer">
                                                <div class="item">
                                                    <a data-image="uploads/images/products/{{ $item }}" data-zoom-image="uploads/images/products/{{ $item }}">
                                                        <img
                                                            data-img="uploads/images/products/{{ $item }}"
                                                            src="uploads/images/products/{{ $item }}"
                                                            alt="{{ $productdetail->name }} "
                                                            style="margin-left: 0em;" onclick="myFunction(this);"
                                                        >
                                                    </a>
                                                </div>
                                            </div>
                                        @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {!! Form::open(['url' => 'addCart/'. $productdetail->id]) !!}
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 details-pro">
                                <h1 class="title-product">{{ $productdetail->name }}</h1>
                                <div class="group-status">
                                    <span class="first_status">Khuyến mãi:
                                        @if($productdetail->promotion->status == 1)
                                            @if ($productdetail->promotion->percent == 0)
                                            <span class="status_name">Không có chương trình khuyến mãi</span>
                                            @else
                                            <span class="status_name">{{ $productdetail->promotion->percent }}%</span>
                                            @endif
                                        @else
                                            <span class="status_name">Không có chương trình khuyến mãi</span>
                                        @endif
                                        <span class="space">&nbsp; | &nbsp;</span>
                                    </span>
                                    <span class="first_status">
                                        Tình trạng:
                                        @if( $productdetail->in_stock > 0)
                                        <span class="status_name availabel">Còn Hàng</span>
                                        @else
                                        <span class="status_name availabel">Hết Hàng</span>
                                        @endif
                                    </span>
                                </div>
                                <div class="price-box" itemscope="" itemtype="http://schema.org/Offer">
                                    <span class="special-price">
                                        <span class="price product-price" itemprop="price">
                                            {{ number_format($productdetail->price -($productdetail->price *($productdetail->promotion->percent /100)), 0, ',',',')}}đ
                                        </span>
                                        @if($productdetail->promotion->status == 1)
                                            @if($productdetail->promotion->id != 1)
                                            <strike style="font-size: 1.25em;margin-left: 1em;">
                                                {{ number_format($productdetail->price, 0, ',','.') }}đ
                                            </strike>
                                            @endif
                                        @endif
                                        <br>
                                        <span style="margin-right:1em;">Chọn màu :</span>
                                        @foreach(json_decode($productdetail->color) as $color)
                                            {{ Form::radio('color', $color, true) }}
                                            <span style="margin-right:1em;">{{ $color }}</span>
                                        @endforeach
                                    </span>
                                </div>
                                <br>
                                <br>
                                <div id="product" class="form-product col-sm-12">
                                    <div class="form-group form_button_details">
                                        <div class="form_hai ">
                                            <div class="button_actions">
                                                @if( $productdetail->in_stock > 0)
                                                    {{ Form::hidden('in_stock', $productdetail->in_stock) }}
                                                    {{ Form::button('Thêm vào giỏ hàng',['type' => 'submit', 'class' => 'btn btn-lg btn-block btn-cart button_cart_buy_enable add_to_cart btn_buy', 'id' => 'button-cart']) }}
                                                @else
                                                    {{ Form::button('Thêm vào giỏ hàng',['type' => 'submit', 'class' => 'btn btn-lg btn-block btn-cart button_cart_buy_enable add_to_cart btn_buy', 'id' => 'button-cart', 'disabled' => 'disabled']) }}
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{ Form::close() }}
                        </div>
                        <div id="block-tab-infor" class="col-xs-12 col-lg-12 col-sm-12 col-md-12">
                            <div class="row margin-top-50 xs-margin-top-15">
                                <div class="col-xs-12 col-lg-12 col-sm-12 col-md-12 no-padding">
                                    <div class="product-tab e-tabs">
                                        <ul class="tabs tabs-title clearfix">
                                            <li class="tab-link current" data-tab="tab-description">
                                                <h3>
                                                    <span>Thông Số Kỹ Thuật</span>
                                                </h3>
                                            </li>
                                            <li class="tab-link fren" data-tab="tab-specifications">
                                                <h3>
                                                    <span>Mô tả</span>
                                                </h3>
                                            </li>
                                            <li class="tab-link" data-tab="tab-review">
                                                <h3>
                                                    <span>Bình Luận({{ count($comments) }})</span>
                                                </h3>
                                            </li>
                                        </ul>
                                        <div class="tab-content current" id="tab-description">
                                            <div class="rte">
                                                <table class="table" style="margin-bottom:-3em;">
                                                    @php $someArray = json_decode($productdetail->description, true);
                                                    @endphp
                                                    <tr>
                                                        <td scope="row" style="width:50%;">Màn Hình:</td>
                                                        <td scope="row" style="width:50%; text-align: left; color:blue;">
                                                            {{ $someArray['screen'] }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td scope="row" style="width:50%;">Hệ Điều Hành:</td>
                                                        <td scope="row" style="width:50%; text-align: left; color:blue;">
                                                            {{ $someArray['OS'] }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td scope="row" style="width:50%;">Camera :</td>
                                                        <td scope="row" style="width:50%; text-align: left">
                                                            {{ $someArray['camera'] }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td scope="row" style="width:50%;">CPU :</td>
                                                        <td scope="row" style="width:50%; text-align: left;color:blue;">
                                                            {{ $someArray['cpu'] }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td scope="row" style="width:50%;">Ram :</td>
                                                        <td scope="row" style="width:50%; text-align: left">
                                                            {{ $someArray['ram'] }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td scope="row" style="width:50%;">Sim :</td>
                                                        <td scope="row" style="width:50%; text-align: left">
                                                            {{ $someArray['sim'] }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td scope="row" style="width:50%;">Pin :</td>
                                                        <td scope="row"
                                                            style="width:50%; text-align: left; color:blue;">
                                                            {{ $someArray['pin'] }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td scope="row" style="width:50%;">Cảm Biến Vân Tay :</td>
                                                        <td scope="row" style="width:50%; text-align: left">
                                                            {{ $someArray['fingerprint'] }}
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="tab-content" id="tab-review">
                                            <div class="rte">
                                                @if (!empty($comments) or Auth::check())
                                                <div id="zozoweb-product-reviews" class="zozoweb-product-reviews">
                                                    <div class="">
                                                        @if(Auth::check())
                                                            <div
                                                                class="add-comment"
                                                                style="margin-bottom: 30px; padding-bottom: 40px; border-bottom: 1px solid #e5e5e5;"
                                                            >
                                                                <p style="font-weight:bold;">BÌNH LUẬN VỀ SẢN PHẨM</p>
                                                                {{ Form::open(['method' => 'POST', 'route' => 'fe.comment.store']) }}
                                                                {{ Form::hidden('user_id', Auth::user()->id) }}
                                                                {{ Form::hidden('product_id', $productdetail->id) }}
                                                                <div>
                                                                    <textarea maxlength="1500" id="review_body" name="content" rows="1" placeholder="Mời bạn nhập bình luận ..."></textarea>
                                                                    @if ($errors->has('content'))
                                                                    <span class="invalid-feedback required" role="alert">
                                                                        <strong style="color:red;">{{ $errors->first('content') }}</strong>
                                                                    </span>
                                                                    @endif
                                                                    {{ Form::submit('Đăng',['class' => 'btn btn-warning', 'style' => 'float:right; margin-top: 5px;']) }}
                                                                    {{ Form::close() }}
                                                                </div>
                                                            </div>
                                                        @else
                                                            <h4>Bạn phải
                                                                <a href="{{ route('fe.login')}}" style="color:red; font-weight: bold;">đăng nhập</a>
                                                                để có thể bình luận
                                                            </h4>
                                                        @endif
                                                        @php $i = 0; @endphp
                                                        @foreach ($comments as $comment)
                                                        @php $i++; @endphp
                                                            <div class="comment-reply">
                                                                @if (!empty($comment->user->avatar))
                                                                <img
                                                                    data-img="uploads/images/users/{{ $comment->user->avatar }}"
                                                                    src="uploads/images/users/{{ $comment->user->avatar }}"
                                                                    alt="{{ $comment->user->name }} "
                                                                    style="padding-right: 1em; width:6%; margin-bottom:-1.5em;"
                                                                >
                                                                @endif
                                                                <h5 style="margin-bottom:0em; color:#365899;">
                                                                    {{ $comment->user->username }}</h5>
                                                                <p style="font-size:1.1em; margin-bottom: 0em;">
                                                                    {{ $comment['content'] }}</p>
                                                                <p>
                                                                    {{ $comment['created_at']->diffForHumans() }},
                                                                    {{ date_format($comment['updated_at'], 'd-m-Y') }}
                                                                </p>
                                                                <div style="margin-bottom: 30px; margin-top:10px; padding-bottom: 20px; @if (count($comment['reply']) >0) margin-left:3em; @endif ">
                                                                    @if(!empty($comment['reply']))
                                                                        @foreach($comment['reply'] as $reply)
                                                                            @if (!empty($reply->user->avatar))
                                                                            <img
                                                                                data-img="uploads/images/users/{{ $reply->user->avatar }}"
                                                                                src="uploads/images/users/{{ $reply->user->avatar }}"
                                                                                alt="{{ $reply->user->name }}"
                                                                                style="padding-right: 1em; width:6%; margin-bottom:-1.5em;"
                                                                            >
                                                                            @endif
                                                                            <h5 style="margin-bottom:0em; color:#365899;">
                                                                                {{ $reply->user->username }}
                                                                            </h5>
                                                                            <p style="font-size:1.1em; margin-bottom: 0em;">
                                                                                {{ $reply['content'] }}
                                                                            </p>
                                                                            <p>
                                                                                {{ $reply['created_at']->diffForHumans() }},
                                                                                {{ date_format($comment['updated_at'], 'd-m-Y') }}
                                                                            </p>
                                                                        @endforeach
                                                                    @endif
                                                                    @if(Auth::check())
                                                                        <button onclick="$('#replybl{{$i}}').toggle()"
                                                                            class="btn btn-primary">
                                                                            Trả lời
                                                                        </button>
                                                                        <div
                                                                            class="add-comment"
                                                                            style="margin-top: 1em; display:none"
                                                                            id="replybl{{$i}}"
                                                                        >
                                                                            {{ Form::open(['url' => 'comment', 'id' => "reply$i"]) }}
                                                                            {{ Form::hidden('product_id', $productdetail->id) }}
                                                                            {{ Form::hidden('user_id', Auth::user()->id) }}
                                                                            {{ Form::hidden('parent_id',$comment['id']) }}
                                                                            <div>
                                                                                <textarea maxlength="1500" id="review_body" name="content" rows="1" placeholder="Mời bạn nhập bình luận ..."></textarea>
                                                                                @if ($errors->has('content'))
                                                                                <span class="invalid-feedback required" role="alert">
                                                                                    <strong style="color:red;">{{ $errors->first('content') }}</strong>
                                                                                </span>
                                                                                @endif
                                                                                {{ Form::submit('Đăng',['class' => 'btn btn-warning', 'style' => ' margin-top: 5px; float:right;']) }}
                                                                            </div>
                                                                            {{ Form::close() }}
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                                <div class="clearfix"></div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="tab-content fren" id="tab-specifications">
                                            <div class="rte">
                                                <p>
                                                    <span style="font-weight: 700; color: rgb(85, 85, 85); font-family: Roboto, sans-serif; font-size: 14px;">
                                                        ĐÔI NÉT VỀ SẢN PHẨM {{ strtoupper($productdetail->name) }}
                                                    </span>
                                                    <br style="color: rgb(85, 85, 85); font-family: Roboto, sans-serif; font-size: 14px;">
                                                    <span style="color: rgb(85, 85, 85); font-family: Roboto, sans-serif; font-size: 14px;">
                                                        {!! strip_tags($productdetail->body) !!}
                                                    </span>
                                                    <br>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <hr>
                        <style>
                            .fb-comments,
                            .fb-comments * {
                                width: 100% !important;
                                display: block !important;
                                float: left;
                            }
                        </style>
                        <div
                            class="fb-comments"
                            data-href="http://yennguyen.myzozo.net/ao-hoodie-nu-chu-theu-thoi-trang-sid53235"
                            data-width="100%" data-numposts="5">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 related-product margin-top-30 xs-margin-top-0">
                <div class="section_prd_feature">
                    <div class="heading heading_related_h">
                        <h2 class="title-head">
                            <a href="javascript:void(0)">Sản phẩm Liên quan</a>
                        </h2>
                    </div>
                    <div class="row">
                        <div
                            class="products product_related products-view-grid-bb owl-carousel owl-theme products-view-grid not-dot2 owl-loaded owl-drag"
                            data-dot="false"
                            data-nav="false"
                            data-lg-items="6"
                            data-md-items="4"
                            data-sm-items="3"
                            data-xs-items="2"
                            data-margin="30"
                        >
                            @foreach ($anotherproduct as $anopr)
                                @php $someArray = json_decode($anopr->image, true); @endphp
                                <div class="owl-stage-outer">
                                    <div class="owl-stage" style="transform: translate3d(0px, 0px, 0px); transition: all 0s ease 0s;">
                                        <div class="owl-item active" style="width: 190px;">
                                            <div class="item saler_item col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padding">
                                                <div class="owl_item_product product-col">
                                                    <div class="product-box">
                                                        <div class="product-thumbnail">
                                                            @if($anopr->promotion->id != 1)
                                                            <span class="sale-off">{{ $anopr->promotion->percent }}%</span>
                                                            @endif
                                                            <a
                                                                class="image_link display_flex"
                                                                href="{{ route('fe.product.detail', ['id'=>$anopr->id, 'slug'=>$anopr->slug]) }}"
                                                                title="{{ $anopr->name }}"
                                                            >
                                                                <img
                                                                    src="uploads/images/products/{{ $someArray[0] }}"
                                                                    data-lazyload="uploads/images/products/{{ $someArray[0] }}"
                                                                    alt="{{ $anopr->name }}"
                                                                    style="padding-right:1em;"
                                                                >
                                                            </a>
                                                            <div class="product-action-grid clearfix">
                                                                <form class="variants form-nut-grid">
                                                                    <div>
                                                                        <button
                                                                            class="btn-cart button_wh_40 left-to"
                                                                            title="Mua ngay"
                                                                            type="button"
                                                                            onclick="window.location.href='indexf1a8.html?route=checkout/cart/add&amp;product_id=219&amp;redirect=true'"
                                                                        >
                                                                            Mua ngay
                                                                        </button>
                                                                        <!--onclick="cart.add(, 1)"></button>-->
                                                                        <a
                                                                            title="Xem"
                                                                            href="{{ route('fe.product.detail', ['id'=>$anopr->id, 'slug'=>$anopr->slug]) }}"
                                                                            class="button_wh_40 btn_view right-to quick-view"
                                                                        >
                                                                            <i class="fa fa-eye"></i>
                                                                            <span class="style-tooltip">Xem</span>
                                                                        </a>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                        <div class="product-info effect a-left">
                                                            <div class="info_hhh">
                                                                <h3 class="product-name ">
                                                                    <a
                                                                        href="{{ route('fe.product.detail', ['id'=>$anopr->id, 'slug'=>$anopr->slug]) }}"
                                                                        title="Kính Mát Nam GOLDSUN GS217003 S1 "
                                                                        style="padding-right:1em;"
                                                                    >
                                                                        {{ $anopr->name }}
                                                                    </a>
                                                                </h3>
                                                                <div class="price-box clearfix">
                                                                    @if($anopr->promotion->id != 1)
                                                                        <strike>{{ number_format($anopr->price, 0, ',','.') }}đ</strike>
                                                                    @endif
                                                                    <br>
                                                                    <span class="price product-price">{{ number_format($anopr->price -($anopr->price *($anopr->promotion->percent /100)), 0, ',','.')}}đ</span>
                                                                    <span class="price product-price-old" style="text-decoration: none">&nbsp;</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('script')
<script>
    function myFunction(imgs) {
      var img_01 = document.getElementById("img_01");
      img_01.src = imgs.src;
      img_01.alt = imgs.alt;

      img_01.parentElement.style.display = "block";
    }
    </script>
@endpush
