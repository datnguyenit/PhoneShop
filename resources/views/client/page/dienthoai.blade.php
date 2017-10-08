@extends('client.layout.master')		
@section('content')	
			<div class="main-content">
                <div class="container">
                    
                    <div class="row search-menu">
                        <div class="col-md-12">
                            <form action="{{route('postdienthoai')}}" method="POST" class="form-inline" role="form">
                                <div class="form-group">
                                    Tìm theo <span class="glyphicon glyphicon-hand-right"></span>
                                </div>
                                <div class="form-group">
                                    <label class="sr-only" for="">label</label>
                                    <select name="manufacturer" class="form-control" >
                                        <option value="0" selected disabled>-- Chọn thương hiệu --</option>
                                        <option value="0"  
                                        @if(!session('manufacturer'))
                                                selected
                                        @endif
                                        >Thương hiệu (tất cả)</option>
                                        @foreach($manus as $manu)
                                            @if(session('manufacturer') && session('manufacturer')==$manu->id)
                                            <option value="{{$manu->id}}" selected>{{$manu->name}}</option>
                                            @else
                                            <option value="{{$manu->id}}">{{$manu->name}}</option>
                                            @endif
                                        @endforeach

                                    </select>
                                </div>
                                <div class="form-group">
                                    <select name="price_range" class="form-control">
                                        <option value="" selected disabled>-- Chọn giá --</option>
                                        <option value="0"  
                                            @if(!session('price_range'))
                                            selected
                                            @endif>Giá (tất cả)</option>
                                        <option value="1"
                                        @if(session('price_range') && session('price_range')==1)
                                            selected
                                            @endif>Dưới 5 triệu</option>
                                        <option value="2"
                                        @if(session('price_range') && session('price_range')==2)
                                            selected
                                            @endif>Từ 5-10 triệu</option>
                                        <option value="3"
                                        @if(session('price_range') && session('price_range')==3)
                                            selected
                                            @endif>Từ 10-15 triệu</option>
                                        <option value="4"
                                        @if(session('price_range') && session('price_range')==4)
                                            selected
                                            @endif>Trên 15 triệu</option>
                                    </select>
                                </div>
                                <div class="form-group">  
                                    <select name="order" class="form-control">
                                        <option selected disabled>-- Sắp xếp --</option>
                                        <option value="0" 
                                        @if(Session::has('order') && session('order')==0)
                                            selected
                                            @endif>Giá (từ thấp đến cao)</option>
                                        <option value="1" 
                                        @if(session('order') && session('order')==1)
                                            selected
                                            @endif>Giá (từ cao đến thấp)</option>
                                    </select>
                                </div>
                                 <div class="form-group">  

                                        <input type="text"  class="form-control" placeholder="Tìm kiếm từ khóa" name="keyword" id="keyword" 
                                        @if(session('keyword'))
                                            value="{{session('keyword')}}"
                                        @endif
                                        >                        
                                </div>
                                {{csrf_field()}}
                        
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>
                        </div>
                    </div>
                    <div class="row search-result">
                        Tìm thấy <strong>{{count($products)}}</strong> sản phẩm
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 sp_dienthoai" >					
                            <ul class="products homepage">

                                @foreach($products as $product)
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
@endsection