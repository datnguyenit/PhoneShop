@extends('client.layout.master')		
@section('content')
		<div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="detail-img">
                        <img src="image/products/{{$product->image}}" alt="{{$product->image}}">
                    </div>
                </div>
                <div class="col-md-8">
                    <H2><strong>{{$product->name}}</strong></H2>
                    <h4>
                        <span>Màu: {{$product->color}}</span>
                        <span class="color-item" data-toggle="tooltip" data-original-title="+0 vnđ" style="background-color: #000000" title="{{$product->color}}"></span>
                        <span style="margin-left:20px"></span>
                       
                    </h4>
                    <h4>
                        <span>Tình trạng:</span> 
                        <span>
                            @if($product->quantity>0)
                                Còn hàng
                            @else
                                Hết hàng
                            @endif
                        </span>
                    </h4>
                    @if(count($others)>0)
                    <h4>
                        <span>Sản phẩm khác:</span>
                        @foreach($others as $other)
                        <span><a href="{{route('dienthoaisanpham',$other->id)}}">{{$other->name}}-{{$other->color}}</a></span>  
                        @endforeach
                    </h4>
                    @endif
                    @if($product->promotion_price>0)
                    <h3>
                        Giá khuyến mãi:
                        <span>{{number_format($product->promotion_price)}} đ</span>
                    </h3>
                    <h3>
                        Giá cũ: <span style="text-decoration: line-through;">{{number_format($product->unit_price)}} đ</span>
                    </h3>
                   @else
                    <h3>
                        Giá:
                        <span>{{number_format($product->unit_price)}} đ</span>
                    </h3>
                    @endif
                    <a href="{{route('pageaddtocart',$product->id)}}" class ="btn btn-success">Thêm vào giỏ hàng <i class= "glyphicon glyphicon-shopping-cart"></i></a>
                    <a href ="{{route('popcompare',$product->id)}}" class="btn btn-sm btn-default">So sánh với</a>
                    <h3>
                        <a href ="{{route('giohang')}}" class ="btn btn-info"><i class= "glyphicon glyphicon-shopping-cart"></i> Xem giỏ hàng </a>
                    </h3>
                    
                </div>

            </div>
        <!-- row -->
        <hr>
        <div class="row">
            <div class="col-md-8">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        Thông số kỹ thuật
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-bordered ">
                                <tr>
                                    <th class="tieude_cauhinh">Màn hình</th>
                                </tr>
                                <tr>
                                    <th>Công nghệ màn hình</th>
                                    <td><%=mh.getCongNgheMH()%></td>
                                </tr>
                                <tr>
                                    <th>Độ phân giải</th>
                                    <td><%=mh.getDoPhanGiai()%></td>
                                </tr>
                                <tr>
                                    <th>Màn hình rộng</th>
                                    <td><%=mh.getManHinhRong()%></td>
                                </tr>
                                <tr>
                                    <th>Cảm ứng</th>
                                    <td><%=mh.getCamUng()%></td>
                                </tr>
                                <tr>
                                    <th>Mặt kính cảm ứng</th>
                                    <td><%=mh.getMatKinhCamUng()%></td>
                                </tr>
                                <tr>
                                    <th class="tieude_cauhinh">Camera sau</th>
                                </tr>
                                <tr>
                                    <th>Độ phân giải</th>
                                    <td><%=camsau.getDoPhanGiai()%></td>
                                </tr>
                                <tr>
                                    <th>Quay phim</th>
                                    <td><%=camsau.getQuayPhim()%></td>
                                </tr>
                                <tr>
                                    <th>Đèn Flash</th>
                                    <td><%=camsau.getDenFlash()%></td>
                                </tr>
                                <tr>
                                    <th>Chụp ảnh nâng cao</th>
                                    <td><%=camsau.getChupAnhNangCao()%></td>
                                </tr>
                                <tr>
                                    <th class="tieude_cauhinh">Camera trước</th>
                                </tr>
                                <tr>
                                    <th>Độ phân giải</th>
                                    <td><%=camtruoc.getDoPhanGiai()%></td>
                                </tr>
                                <tr>
                                    <th>Quay phim</th>
                                    <td><%=camtruoc.getQuayPhim()%></td>
                                </tr>
                                <tr>
                                    <th>Videocall</th>
                                    <td><%=camtruoc.getVideoCall()%></td>
                                </tr>
                                <tr>
                                    <th>Thông tin khác</th>
                                    <td><%=camtruoc.getThongTinKhac()%></td>
                                </tr>
                                <tr>
                                    <th class="tieude_cauhinh">CPU</th>
                                </tr>
                                <tr>
                                    <th>Hệ điều hành</th>
                                    <td><%=cpu.getHDH()%></td>
                                </tr>
                                <tr>
                                    <th>Chipset</th>
                                    <td><%=cpu.getChipSet()%></td>
                                </tr>
                                <tr>
                                    <th>Tốc độ CPU</th>
                                    <td><%=cpu.getTocDoCPU()%></td>
                                </tr>
                                <tr>
                                    <th>Chip đồ họa (GPU)</th>
                                    <td><%=cpu.getGPU()%></td>
                                </tr>
                                <tr>
                                    <th class="tieude_cauhinh">Bộ nhớ</th>
                                </tr>
                                <tr>
                                    <th>RAM</th>
                                    <td><%=bn.getRAM()%></td>
                                </tr>
                                <tr>
                                    <th>ROM</th>
                                    <td><%=bn.getROM()%></td>
                                </tr>
                                <tr>
                                    <th>Bộ nhớ còn lại (khả dụng)</th>
                                    <td><%=bn.getBoNhoKhaDung()%></td>
                                </tr>
                                <tr>
                                    <th>Thẻ nhớ ngoài</th>
                                    <td><%=bn.getTheNhoNgoai()%></td>
                                </tr>
                                <tr>
                                    <th>Hỗ trợ thẻ tối đa</th>
                                    <td><%=bn.getHoTroTheToiDa()%></td>
                                </tr>
                                <tr>
                                    <th class="tieude_cauhinh">Thiết kế</th>
                                </tr>
                                <tr>
                                    <th>Chất liệu</th>
                                    <td><%=tk.getChatLieu()%></td>
                                </tr>
                                <tr>
                                    <th>Kích thước</th>
                                    <td><%=tk.getKichThuoc()%></td>
                                </tr>
                                <tr>
                                    <th>Trọng lượng</th>
                                    <td><%=tk.getTrongLuong()%></td>
                                </tr>
                                <tr>
                                    <th class="tieude_cauhinh">Pin</th>
                                </tr>
                                <tr>
                                    <th>Dung lượng pin</th>
                                    <td><%=pin.getDungLuong()%></td>
                                </tr>
                                <tr>
                                    <th>Loại pin</th>
                                    <td><%=pin.getLoaiPin()%></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="panel panel-warning">
                    <div class="panel-heading">
                        Có thể bạn muốn mua
                    </div>
                    <div class="panel-body">
                        <ul>
                            <%for(SanPham sp2: spDAO.getListSanPhamBanChayNhat(5)){ %>
                            <li><a href="DienThoaiSanPham.jsp?sanpham=<%=sp2.getMaSP()%>"><%=sp2.getTenSP()%></a></li>
                                <% } %>
                        </ul>
                    </div>
                </div>
            </div>
        </div> 

        <!--row-->
        <!--        <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                Nhận xét/Bình luận 
                            </div>
                            <div class="panel panel-body panelBinhLuan">
                                <form class ="form-horizontal">
                                    <div class = "form-group">
                                        <label class = "col-sm-2 control-label">Họ tên: </label>
                                        <div class="col-sm-10">
                                            <input class = "form-control"  placeholder="Nhập họ tên" type="text" >
                                        </div>
                                    </div>
                                    <div class = "form-group">
                                        <label class = "col-sm-2 control-label">Email: </label>
                                        <div class="col-sm-10">
                                            <input class = "form-control"  placeholder="Nhập Email" type="email" >
                                        </div>
                                    </div>
                                    <div class = "form-group">
                                        <label class = "col-sm-2 control-label">Ý kiến: </label>
                                        <div class="col-sm-10">
                                            <textarea class="form-control" placeholder="Nhập ý kiến của bạn" rows="3"></textarea>
                                        </div>
                                    </div>
                                    <input class="btn btn-danger" value="Gửi bình luận" style="margin-left: 40%">
                                    <hr>
                                    <ul class="listComment" style="padding-top: 15px;">
                                        <li class="comment">
                                            <div class="usercomment"><strong>Trương Thanh Quang</strong></div>
                                            <div class="ndcomment">Galaxy J7 Prime giá còn 3 triệu đúng không ạ?</div>
                                            <div class="thoigiancomment">16/11/2016 17:48:00</div>
                                        </li>
                                        <li class="comment">
                                            <div class="usercomment"><strong>Trương Thanh Quang</strong></div>
                                            <div class="ndcomment">Galaxy J7 Prime giá còn 3 triệu đúng không ạ?</div>
                                            <div class="thoigiancomment">16/11/2016 17:48:00</div>
                                        </li>
                                    </ul>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>-->
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        Nhận xét/Bình luận 
                    </div>
                    <!-- Đoạn code tích hơp mang xã hội vào trang (bên header còn 1 đoạn) -->

                    <div class="fb-comments" data-href="DienThoaiSanPham.jsp?sanpham=<%=sp.getMaSP()%>" data-width="1000" data-numposts="5"></div>
                    <!--end Bình Luận-->
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
	<script>(function (d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id))
                return;
            js = d.createElement(s);
            js.id = id;
            js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.8&appId=1376022525742876";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));</script>
@endsection