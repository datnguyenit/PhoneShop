@extends('client.layout.master')
@section('content')
			<div class="main-content">
                <div class="container">
                    <h3>Tìm thấy <%=total%> kết quả cho từ khóa "<%=keyword%>"</h3>
                    <div class="row">
                        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 sp_dienthoai" >					
                            <ul class="products homepage">

                            <%                                for (SanPham sp : spDAO.getListSanPhamTheoKeywordTimKiem(keyword, firstValue, maxValue)) {
                                    Mau mau = mauDAO.getMautheoMa(sp.getMaMau());
                                    CauHinh ch = chDAO.getCauHinhtheoMa(sp.getMaCH());
                                    CPU cpu = cpuDAO.getCPUtheoMa(ch.getMaCPU());
                                    BoNho bn = bnDAO.getBoNhotheoMa(ch.getMaBN());
                                    ManHinh mh = mhDAO.getManHinhtheoMa(ch.getMaMH());
                                    CameraSau camsau = camsauDAO.getCamSautheoMa(ch.getMaCamSau());
                                    Pin pin = pinDAO.getPintheoMa(ch.getMaPin());
                            %>
                            <li> 
                                <a href="DienThoaiSanPham.jsp?sanpham=<%=sp.getMaSP()%>"> 
                                    <img  src="<%=sp.getHinh()%>"  alt ="<%=sp.getTenSP()%>"/>
                                    <h3><%=sp.getTenSP()%></h3>
                                    <% if (spDAO.CheckSanPhamKhuyenMai(sp.getMaSP())) {
                                        Double giakm = spDAO.getGiaSPKhuyenMai(sp.getMaSP());
                                    %>
                                    <h4>
                                        Giá khuyến mãi:
                                        <span><%=format.format(giakm)%></span>
                                    </h4>

                                    <!--<span class="textkm">Khuyến mãi trị gía đến <strong>500.000₫</strong>-->
                                    <!--</span>-->
                                    <p class="info">
                                        <span>Màn hình: <%=mh.getCongNgheMH()%>, <%=mh.getManHinhRong()%>'</span>
                                        <span>HĐH: <%=cpu.getHDH()%></span> 
                                        <span>CPU: <%=cpu.getChipSet()%></span>
                                        <span>Camera: <%=camsau.getDoPhanGiai()%></span>
                                        <span>Dung lượng pin: <%=pin.getDungLuong()%></span>
                                    </p>
                                    <h4 style="text-decoration: line-through;">
                                        Giá cũ:
                                        <span><%=format.format(sp.getGia())%></span>
                                    </h4>
                                    <% } else {
                                    %>
                                    <h4>
                                        Giá :
                                        <span><%=format.format(sp.getGia())%></span>
                                    </h4>

                                    <!--<span class="textkm">Khuyến mãi trị gía đến <strong>500.000₫</strong>-->
                                    <!--</span>-->
                                    <p class="info">
                                        <span>Màn hình: <%=mh.getCongNgheMH()%>, <%=mh.getManHinhRong()%>'</span>
                                        <span>HĐH: <%=cpu.getHDH()%></span> 
                                        <span>CPU: <%=cpu.getChipSet()%></span>
                                        <span>Camera: <%=camsau.getDoPhanGiai()%></span>
                                        <span>Dung lượng pin: <%=pin.getDungLuong()%></span>
                                    </p>
                                    <% }%>
                                </a>
                                <div class="dathangtaicho">
                                    <a href="SoSanhServlet?command=plus&masanpham=<%=sp.getMaSP()%>" class="btn btn-info" 
                                       style="width: 30px; height: 25px;   "><i class="glyphicon  glyphicon-check " title="Mình so sánh nhé!"></i></a>
                                </div>
                                <div class="dathangtaicho">
                                    <a href="CartServlet?command=plus&masanpham=<%=sp.getMaSP()%>" class="btn btn-success" 
                                       style="width: 30px; height: 25px;" title="Đặt hàng bạn nhé!"><i class="glyphicon  glyphicon-shopping-cart "></i></a>
                                </div>
                            </li>
                            <% }
                            %>
                        </ul>

                    </div>
                </div>
                <ul class="pagination" style="position: relative;left:50%;transform: translateX(-50%);">
                    <li onclick="return loading_show()" style="display: <%=(firstValue / maxValue) == 0 ? "none" : ""%>"><a href="ChonLocServlet?command=trangTimKiem&pages=<%=(firstValue / maxValue)%>&sosphienthi=<%=sosphienthi%>"><i class="glyphicon glyphicon-arrow-left"></i></a></li>
                            <%for (int i = 1; i <= (total / sosphienthi) + 1; i++) {
                            %>
                    <li class="<%=((firstValue / maxValue) + 1 == i) ? "active" : ""%>"><a href="ChonLocServlet?command=trangTimKiem&pages=<%=i%>&sosphienthi=<%=sosphienthi%>"><%=i%></a></li>
                        <% }%>
                    <li style="display: <%=((firstValue / maxValue) > ((total / maxValue) - 1)) ? "none" : ""%>"><a href="ChonLocServlet?command=trangTimKiem&pages=<%=(firstValue / maxValue) + 2%>&sosphienthi=<%=sosphienthi%>"><i class="glyphicon glyphicon-arrow-right" ></i></a></li>
                </ul>
            </div>
        </div>
@endsection