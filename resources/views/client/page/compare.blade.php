@extends('client.layout.master')
@section('content')
        <div class="container">
                <div class="row">
                    <h3>So sánh điện thoại: <strong>{{$product1->name}}</strong> và <strong>{{$product2->name}}</strong></h3>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-bordered table-hover ">
                        <thead>
                            <tr>
                                <th style="width: 20%"></th>
                                <th style="width: 40%" >
                                    <p style="text-align: center;">{{$product1->name}}</p>

                                </th>
                                <th style="width: 40%">
                                    <p style="text-align: center;">{{$product2->name}}</p>
                                </th>
                            </tr>
                        </thead>
                        <!--Phần so sanh các điểm nổi bật-->
                        <tbody>
                            <tr>
                                <td></td>
                                <td class="compare-img">
                                    <a href="DienThoaiSanPham.jsp?sanpham=<%=sp.getMaSP()%>" >
                                        <img src="image/products/{{$product1->image}}" width="auto " height="365px;" >
                                    </a>
                                    
                                </td>
                                <td class="compare-img">
                                     <a href="DienThoaiSanPham.jsp?sanpham=<%=sp2.getMaSP()%>"><img src="image/products/{{$product2->image}}" width="auto" height="365px;">
                                     </a>
                                   
                                </td>
                            </tr>
                            <tr>
                                <td>Giá</td>
                                <td>
                                    @if($product1->promotion_price>0)
                                        <span class="price-product-old">{{number_format($product1->unit_price)}}đ</span>
                                        <span class="price-product-promotion">{{number_format($product1->promotion_price)}}đ</span>
                                    @else
                                        <span class="price-product">{{number_format($product1->unit_price)}}đ</span>
                                    @endif
                                </td>
                                <td>
                                    @if($product2->promotion_price>0)
                                        <span class="price-product-old">{{number_format($product2->unit_price)}}đ</span>
                                        <span class="price-product-promotion">{{number_format($product2->promotion_price)}}đ</span>
                                    @else
                                        <span class="price-product">{{number_format($product2->unit_price)}}đ</span>
                                    @endif
                                </td>
                            </tr>
                             <tr>
                                <td>Màu</td>
                                <td>{{$product1->color}}</td>
                                <td>{{$product2->color}}</td>
                            </tr>
                            <tr>
                                <td>Hãng SX</td>
                                <td>{{$manu1}}</td>
                                <td>{{$manu2}}</td>
                            </tr>
                            <tr>
                                <td>Màn hình</td>
                                <td>
                                    {{$product1->display}}
                                </td>
                                <td>
                                    {{$product2->display}}
                                </td>
                            </tr>
                            <tr>
                                <td>Hệ điều hành</td>
                                <td>
                                    {{$product1->OS}}
                                </td>
                                <td>
                                    {{$product2->OS}}
                                </td>
                            </tr>
                            <tr>
                                <td>Bộ nhớ</td>
                                <td>
                                    {{$product1->memory}}
                                </td>
                                <td>
                                    {{$product2->memory}}
                                </td>
                            </tr>
                            <tr>
                                <td>RAM</td>
                                <td>
                                    {{$product1->RAM}}
                                </td>
                                <td>
                                    {{$product2->RAM}}
                                </td>
                            </tr>
            
                            <tr>
                                <td></td>
                                <td class="obj-center">
                                   <button type="button" onclick="dathang({{$product1->id}})" class="btn btn-success"><i class="glyphicon glyphicon-shopping-cart"></i>Thêm vào giỏ hàng </button>
                                </td>
                                <td class="obj-center">
                                    <button type="button" onclick="dathang({{$product2->id}})" class="btn btn-success"><i class="glyphicon glyphicon-shopping-cart"></i>Thêm vào giỏ hàng </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
@endsection