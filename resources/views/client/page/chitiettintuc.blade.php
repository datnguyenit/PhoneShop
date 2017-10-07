@extends('client.layout.master')
@section('content')
 	<div class="container">
                <div class="row">
                    <div class="col-md-9">
                        <br>
                        <h1 class="chitietsukien"><a href="#"><%=tt.getTenTin()%></a></h1>
                    <div class="nvdangbai">
                        <a href="#">
                        </a>
                        <span>Ngày đăng: <%=tt.getNgayDang()%> bởi <%=tt.getUserID()%></span>
                    </div>
                    <br>
                    <div class="imgwrap">
                        <img width="auto" height="450px" alt="<%=tt.getTenTin()%>" src="<%=tt.getLinkAnh()%>" title="<%=tt.getTenTin()%>">
                    </div>
                    <div class="tinchinh">
                        <p>
                            <%=tt.getNoiDung()%>
                        </p>
                        <p>
                            <i style="font-size: 18px">Về mua điện thoại vui hơn nè:<a href="index.jsp"> Trang chủ</a></i>
                        </p>
                    </div>
                    <hr>
                </div>
                <div class="col-md-3">
                    <div class="xemthem">
                        <br><br><br>
                        <p><a href="TinTuc.jsp">Xem thêm >> </a></p>
                        <%
                            for (TinTuc tt1 : ttDAO.getListTinTucGioiHang(5)) {
                        %>
                        <p><img width="40" height="40" src="<%=tt1.getLinkAnh()%>"><a href="ChiTietTinTuc.jsp?matin=<%=tt1.getMaTin()%>" title="<%=tt1.getTenTin()%>" ><%=tt1.getTenTin()%></a></p>
                            <% }%>
                    </div>
                </div>
            </div>
        </div>
@endsection
@section('script')

@endsection