<header>
            <nav class="navbar navbar-default " role="navigation">
                <div class="container">
                    <div class="nav navbar-nav col-lg-2 col-xs-6 col-md-2 col-sm-4 ">
                        <a href="{{route('index')}}"><img src="Image/iconF5.png" class = "logo img-responsive" alt=""></a>
                    </div>
                    <div class="col-lg-3 col-xs-12 col-md-3 col-sm-8">
                        <form class="navbar-form" role="search">
                            <div class="input-group" id="TimKiem">
                                <input type="text"  class = "form-control" placeholder="Nhập điện thoại">	
                                <div class="input-group-btn">
                                    <button type="submit" class = "btn btn-default"><i class=" glyphicon glyphicon-search"></i></button>
                                </div>				
                            </div>
                        </form>
                    </div>
                    <div class="col-lg-7 ol-xs-12 col-md-7 col-sm-12"">
                        <div class="row">
                            <ul class = "nav navbar-nav col-lg-9 col-xs-12 col-md-9 col-sm-10 hoverthanhnav">
                                <li ><a  href="{{route('dienthoai')}}" title="Điện Thoại">
                                        <i class="glyphicon glyphicon-phone"></i> Điện thoại </a></li>
                                <li><a href="KhuyenMai.jsp" title="Khuyến Mãi">
                                        <i class="glyphicon glyphicon-gift"></i> Khuyến Mãi</a></li>
                                <li><a href="TinTuc.jsp" title="Tin Tức"><i class= "glyphicon glyphicon-signal"></i> Tin tức</a></li>
                                <!--Giỏ hàng-->
                                <li>
                                    <a href="{{route('giohang')}}" title="Tin Tức"><i class= "glyphicon glyphicon-shopping-cart"></i> Giỏ Hàng <span class="badge" id="total_quantity_cart" style="color:#F9F9F9;background: #c7254e;">{{Cart::count()}}</span></a>
                                </li>
                                <!--Giỏ hàng-->
                            </ul>
                            <div class="nav navbar-nav dangnhap_nav col-lg-3 col-xs-12 col-md-3 col-sm-2">
                                

                                <ul class="nav navbar-nav navbar-right">

                                    <li class="navbar-right dropdown">
                                        <a href = "" class="navbar-right dropdown-toggle" data-toggle="dropdown"><span>Xin Chào:  </span><span class="caret"></span></a>
                                        <ul class = "dropdown-menu">
                                            <li><a href="Admin_QLNhanVien.jsp">Trang quản lý</a></li>
                                            <li><a href="LogoutServlet">Đăng xuất</a></li>
                                        </ul>

                                    </li>		           
                                </ul>

                                
                                <a href="{{route('login')}}" ><i class="glyphicon glyphicon-log-in"></i> Đăng nhập </a>

                               
                            </div>
                        </div>
                    </div>
                </div>
            </nav><!-- /Phần menu -->
        </header>
        @if(Session::has('popcomp'))
                <div class="col-md-4 compare-info">
                     <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            @if(Session::has('popcomp1'))
                                            <td><img src="image/products/{{Session::get('popcomp1')->image}}" alt="{{Session::get('popcomp1')->image}}"></td>
                                            <td>{{Session::get('popcomp1')->name}}</td>
                                            <td><button type="button" class="btn btn-danger btn-xs" onclick="removeCompare(0)">Xóa</button></td>
                                            @else
                                            <td>Hình</td>
                                            <td>Tên</td>
                                            <td>Xóa</td>
                                            @endif
                                        </tr>
                                        <tr>
                                            @if(Session::has('popcomp2'))
                                            <td><img src="image/products/{{Session::get('popcomp2')->image}}" alt="{{Session::get('popcomp2')->image}}"></td>
                                            <td>{{Session::get('popcomp2')->name}}</td>
                                            <td><button type="button" class="btn btn-danger btn-xs" onclick="removeCompare(1)">Xóa</button></td>
                                            @else
                                            <td>Hình</td>
                                            <td>Tên</td>
                                            <td>Xóa</td>
                                            @endif
                                        </tr>
                                        <tr>
                                            @if(Session::has('popcomp1')&&Session::has('popcomp2'))
                                           <td colspan="3" style="text-align: center;">
                                            <a href="{{route('compare',[Session::get('popcomp1')->id,Session::get('popcomp2')->id])}}" class="btn btn-primary">So sánh</a>
                                           </td>
                                           @endif
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
        @endif
       