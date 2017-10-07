@extends('client.layout.master2')
@section('content')
		<div class="container">
            <form class="frm_DangNhap" action="{{route('postlogin')}}" method="POST" id="form-login">
                <h2 style="margin-top: 0">Đăng nhập quản trị viên</h2>
                <small>Nếu bạn đã có tài khoản, xin mời đăng nhập bên dưới</small>
                @if(Session::has('mess'))
                <div class="alert alert-danger alert-error-login" >
                    <strong>{{Session::get('mess')}}</strong>
                </div>
                @endif
                <div class="form-group">
                    <label for="email">Email</label>
                    <input name = "email" type ="text" class="form-control" value="{{old('email')}}">
                </div>
                <div class="form-group">
                    <label for="password">Mật khẩu</label>
                    <input name="password" type ="password" class="form-control" value="{{old('password')}}">
                </div>
                <a href="#QuenMKModal" data-toggle="modal" data-target="#QuenMKModal">Quên mật khẩu?</a>
                {{csrf_field()}}
                <div class="obj-center ">
                    <input type="submit" class="btn btn-success button-login" value="Đăng nhập">
                </div>
            </form>
        </div>

        <div class="modal fade" id="QuenMKModal" tabindex="-1">
            <div class="modal-dialog ">
                <div class="modal-content">
                    <div class="modal-header">
                        <button class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Quên mật khẩu</h4>
                    </div>
                    <div class="modal-body">
                        <p>Bạn vui lòng nhập tên tài khoản của mình và Email đăng ký vào đây để lấy lại mật khẩu mới.</p>
                        <form action="QuenMatKhauServlet" method="post" class="form-horizontal" id="formSendQuenMK">
                            <div class="form-group">
                                <label for="lmk_name" class="col-xs-3 control-label">Tên đăng nhập:</label>
                                <div class="col-xs-9">
                                    <input type="text" name="lmk_name" class="form-control" placeholder="Username" required="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="lmk_email" class="col-xs-3 control-label">Email đăng ký:</label>
                                <div class="col-xs-9">
                                    <input type="email" name="lmk_email" class="form-control" placeholder="Email" required="">
                                </div>
                            </div>
                            <input type="submit" value="Lấy lại mật khẩu" class="btn btn-primary">
                        </form>
                        <p>Vui lòng check email để lấy lại mật khẩu</p>
                    </div>
                </div>
            </div>
        </div>
@endsection