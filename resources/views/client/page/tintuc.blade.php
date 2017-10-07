@extends('client.layout.master')
@section('content')			
			<div class="container">
                <br>
                <div class="row">
                    <div class="col-md-8">
                        <H3 style="text-align: center;"><strong>Tin tức</strong></H3>
                        <ul>
                        <%                            for (TinTuc tt : ttDAO.getListTinTucGioiHang(5)) {
                        %>
                        <li><a href = "ChiTietTinTuc.jsp?matin=<%=tt.getMaTin()%>">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                    </div>
                                    <div class="panel-body">
                                        <div class="row">
                                            <img src="<%=tt.getLinkAnh()%>" style="width: 100%; height: 300px;">
                                        </div>
                                        <div class="row">
                                            <h3 style="padding-left: 35px;"><%=tt.getTenTin()%></h3>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <% }%>
                    </ul>
                </div>
                <div class="col-md-4" style="margin-top: 50px;">
                    <div class="panel panel-warning">
                        <div class="panel-heading">
                            Các điện thoại hot
                        </div>
                        <div class="panel-body">
                            <ul>
                                <%
                                    for (SanPham sp : spDAO.getListSanPhamBanChayNhat(6)) {
                                %>
                                <li><a href="DienThoaiSanPham.jsp?sanpham=<%=sp.getMaSP()%>"><%=sp.getTenSP()%></a></li>
                                    <% }%>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

        </div>
@endsection