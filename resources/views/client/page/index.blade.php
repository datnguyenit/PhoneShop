@extends('client.layout.master')
@section('content')    

            <div class="main-content">
                <div class="container">
                    <div class="row">
                        <div class="col-md-8 col-lg-8 col-sm-12 col-xs-12">
                            <div class="trungbaysanpham">
                                <ul class="nav nav-tabs" role="tablists">
                                    <li class="active" role="tab">
                                        <a href="#sanphammoi" role = "tab" data-toggle = "tab" title = "Sản phẩm mới"><i class = "glyphicon glyphicon-asterisk"></i> Sản phẩm mới</a>
                                    </li>
                                    <li >
                                        <a href="#sanphambanchay" role = "tab" data-toggle = "tab" title = "Sản phẩm bán chạy"><i class = "glyphicon glyphicon-fire"></i> Sản phẩm bán chạy</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane fade active in sp_dienthoai" id="sanphammoi" >
                                    <ul class="products homepage">
                                    @foreach($products_new as $product)
                                    <li>
                                        @if($product->new == 1)
                                        <div class="product_new badge" ><p>New</p></div>
                                        @endif
                                        @if($product->hot == 1)
                                        <div class="product_hot badge" ><p>Hot</p></div>
                                        @endif
                                        <a href="{{route('dienthoaisanpham',$product->id)}}"> 
                                            <img  src="image/products/{{$product->image}}"  alt ="{{$product->image}}"/>
                                            <h3>{{$product->name}}</h3>
                                            <h4>
                                                <span class="price-product">Giá:</span>
                                                @if($product->promotion_price<=0)
                                                <span class="price-product">{{number_format($product->unit_price)}}đ</span>
                                                @else
                                                 <span class="price-product-old">{{number_format($product->unit_price)}}đ</span>

                                                <span class="price-product-promotion">{{number_format($product->promotion_price)}}đ</span>
                                                @endif
                                            </h4> 
                                            <!-- <span class="textkm">Khuyến mãi trị gía đến <strong>500.000₫</strong> -->
                                            <!--</span>-->
                                            <p class="info">
                                                <span>Màn hình: {{$product->display}}'</span>
                                                <span>HĐH: {{$product->OS}}</span> 
                                                <span>Bộ nhớ: {{$product->memory}}</span>
                                                <span>Màu: {{$product->color}}</span>
                                            </p>
                                        </a>
                                
                                        <div class="btn-group btn-group-xs alignright">
                                            <button type="button" onclick="addCompare({{$product->id}})" class="btn btn-primary ">So sánh</button>
                                            <button type="button" onclick="dathang({{$product->id}})" class="btn btn-success ">Đặt hàng</button>
                                        </div>
                                       
                                    </li>
                                    @endforeach
                                    
                                </ul>
                            </div>

                            <div role="tabpanel" class="tab-pane fade " id="sanphambanchay">
                                <div id="site-wrapper" class="sp_dienthoai">
                                    <ul class="products homepage">
                                       @foreach($products_hot as $product)
                                    <li> 
                                         @if($product->new == 1)
                                        <div class="product_new badge" ><p>New</p></div>
                                        @endif
                                        @if($product->hot == 1)
                                        <div class="product_hot badge" ><p>Hot</p></div>
                                        @endif
                                      <a href="{{route('dienthoaisanpham',$product->id)}}"> 
                                            <img  src="image/products/{{$product->image}}"  alt ="{{$product->image}}"/>
                                            <h3>{{$product->name}}</h3>
                                            <h4>
                                               <span class="price-product">Giá:</span>
                                                @if($product->promotion_price<=0)
                                                <span class="price-product">{{number_format($product->unit_price)}}đ</span>
                                                @else
                                                 <span class="price-product-old">{{number_format($product->unit_price)}}đ</span>

                                                <span class="price-product-promotion">{{number_format($product->promotion_price)}}đ</span>
                                                @endif
                                            </h4> 
                                            <!--<span class="textkm">Khuyến mãi trị gía đến <strong>500.000₫</strong>-->
                                            <!--</span>-->
                                            <p class="info">
                                                <span>Màn hình: {{$product->display}}'</span>
                                                <span>HĐH: {{$product->OS}}</span> 
                                                <span>Bộ nhớ: {{$product->memory}}</span>
                                                <span>Màu: {{$product->color}}</span>
                                            </p>
                                        </a>
                                        <div class="btn-group btn-group-xs alignright">
                                            <button type="button" onclick="addCompare({{$product->id}})" class="btn btn-primary ">So sánh</button>
                                            <button type="button" onclick="dathang({{$product->id}})" class="btn btn-success ">Đặt hàng</button>
                                        </div>
                                    </li>
                                    @endforeach


                                    </ul>
                                </div>
                            </div>
                        </div>	
                    </div>
                    <div class="col-md-4 col-lg-4 col-sm-12 col-xs-12">
                        <div class="selloff">
                            <div class="top_right"><h2>Khuyến mãi</h2></div>
                            <ul class="right-content">
                                <li class =" right-main">
                                    <a href="ChiTietKhuyenMai.jsp" title="Note7 nổ banh nhà banh cửa">Khuyến mãi khủng giá sốc tháng 11/2016</a>
                                </li>
                                <div class="scroll">
                                    <li>
                                        <a href="">Note7 giá 3 triệu đồng</a>
                                    </li>
                                    <li>
                                        <a href="">Khuyến mãi ngày tựu trường</a>
                                    </li>
                                    <li>
                                        <a href="">Giảm giá trên các sản phẩm Samsang tháng 10</a>
                                    </li>
                                    <li>
                                        <a href="">Lumia XL giá chỉ còn 1 nửa</a>
                                    </li>
                                </div>
                            </ul>
                        </div>
                        <div class="news">
                            <div class="top_right"><h2>Tin Tức</h2></div>
                            <ul class="right-content">
                                <li class =" right-main">
                                    <a href="" title="Note7 nổ banh nhà banh cửa">Note7 nổ banh nhà banh cửa</a>
                                </li>
                                <div class="scroll">
                                    <li>
                                        <a href="ChiTietTinTuc.jsp">Note7 nổ banh nhà banh cửa</a>
                                    </li>
                                    <li>
                                        <a href="">Note7 nổ banh nhà banh cửa</a>
                                    </li>
                                    <li>
                                        <a href="">Note7 nổ banh nhà banh cửa</a>
                                    </li>
                                    <li>
                                        <a href="">Note7 nổ banh nhà banh cửa</a>
                                    </li>
                                </div>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
@section('script')

@endsection