@extends('client.layout.master')
@section('content')			
			<div class="container">

                @if(Session::has('mess'))
                <div class="alert alert-info">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <strong>{{Session::get('mess')}}</strong>
                </div>
                @endif
                <div class="col-md-8">
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                <i class="glyphicon glyphicon-shopping-cart"></i> <strong>Giỏ hàng của tôi</strong>
                            </h3>
                        </div>
                        <div class="panel-body"> 
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover table-striped">
                                    <thead>
                                        <tr>
                                            <th>STT</th>
                                            <th>Hình</th>
                                            <th>Sản phẩm </th>
                                            <th>SL</th>
                                            <th>Giá</th>
                                            <th>Thành tiền</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                   
                                   @foreach($products as $product)
                                        
                                    <tr >
                                        <td>@if ($loop->first)
                                            {{$i=1}}
                                        @else
                                            {{++$i}}
                                        @endif</td>
                                        <td class="cell-center  ">
                                            <a href="#"><img src="image/products/{{$product->options->image}}" style ="max-width: 80px; max-height:60px;" alt="{{$product->image}}" title="{{$product->image}}"></a>
                                        </td>
                                        <td>
                                            <a href="DienThoaiSanPham.jsp?sanpham=<%=list.getValue().getSanpham().getMaSP()%>">{{$product->name}}</a>
                                        </td>
                                        <td>
                                            <div class="numbercart">
                                                 <input type="number" name="quantity_product" class="form-control" value="{{$product->qty}}" min="0" max="10" step="1">
                                            </div>
                                           
                                        </td>
                                        <td >{{number_format($product->price)}}</td>
                                        <td class="product_subtotal">{{number_format($product->subtotal())}}</td>
                                        <td>
                                            <div class="numberbuttoncart btn-group btn-group-xs gia">
                                                <button rowid="{{$product->rowId}}" type="button" class="btn btn-warning btn-update-cart" >Cập nhật</button>
                                                <button rowid="{{$product->rowId}}" type="button" class="btn btn-danger btn-delete-cart">Xóa</button>
                                            </div>
                                           
                                        </td>
                                    </tr>
                                    @endforeach
                                    
                                    
                                </tbody>
                            </table>
                        </div>
                        <strong style="float: right">Tổng cộng :<span id="total_price_cart">{{number_format(Cart::subtotal())}}</span> đ</strong>
                    </div>
                </div>
                <div >
                    <a href ="DienThoai.jsp" class="btn btn-primary" style="margin-left:30%"  >Tiếp tục mua hàng</a>
                    <button class="btn btn-warning btnThanhToanDonHang" id="btnThanhToanDonHang">Đặt hàng và thanh toán</button>
                </div>
            </div>

                <div class="col-md-4 thanhtoandonhang" style="display: none"> 
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                <i class="glyphicon glyphicon-piggy-bank"></i> <strong>Thanh toán đơn hàng</strong>
                            </h3>
                        </div>
                        <div class="panel-body"> 
                            <form action="{{route('payment')}}" method="post" id="form-payment">
                                <div class="form-group" name="cart">
                                   
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="name">Họ và tên(*):</label>
                                    <input  type="text" class="form-control" placeholder="Họ và tên" name="name" >
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="email">Email(*):</label>
                                    <input  type="text" class="form-control" placeholder="Email" name="email" >
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="address">Địa chỉ(*):</label>
                                    <input  type="text" class="form-control" placeholder="Địa chỉ" name="address" >
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="phone">Số điện thoại(*):</label>
                                    <input  type="text" class="form-control" placeholder="Số điện thoại" name="phone"> 
                                </div>
                                {{csrf_field()}}
                                <button onclick="return confirm('Bạn có chắc chắn muốn đặt hàng?')" type="submit" class ="btn btn-primary" >Xác nhận</button>
                                <button id="btnTroVeGioHang" class="btn btn-warning" type="button">Trở về</button>
                            </form>
                        </div>
                    </div>
                </div>

            <!-- panel panel-default -->                
        </div>
@endsection
@section('script')
    <script type="text/javascript">
        $(document).ready(function () {
                $('.btnThanhToanDonHang').click(function () {
                    $('.thanhtoandonhang').show();
                });

                $('#btnTroVeGioHang').click(function () {
                    $('.thanhtoandonhang').hide();
                });
        });

    </script>
@endsection