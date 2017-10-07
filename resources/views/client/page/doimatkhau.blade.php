@extends('client.layout.master')
@section('content')
		<div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="logoChangPassword"></div>
                    <h2 ><strong>Chào mừng bạn đến trang đổi mật khẩu</strong></h2>
                    <h4><i>Bạn đang gặp vấn đề về bảo mật tài khoản?</i></h4>
                    <h4><i>Kẻ nào đó dường như đã biết mật khẩu của bạn?</i></h4>
                    <h3><i><strong>Hãy đổi mật khẩu ngay bây giờ!</strong></i></h3>
                </div>
                <div class="col-md-6">
                    <h2>Đổi mật khẩu</h2>
                    <form class ="form-horizontal frm_label" role="form">
                         <div class="form-group">
                            <label for="tentaikhoan" class = "col-md-4 control-label">Tên tài khoản</label>
                            <div class ="col-md-8">
                                <input type="text" class="form-control " id="tentaikhoan" disabled>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputOldPass" class = "col-md-4 control-label">Nhập mật khẩu cũ</label>
                            <div class ="col-md-8">
                                <input type="password" class="form-control " id="inputOldPass" placeholder="Mật khẩu cũ">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputNewPass" class = "col-md-4 control-label" >Nhập mật khẩu mới</label>
                            <div class ="col-md-8">
                                <input type="password" class="form-control" id="inputNewPass" placeholder="Mật khẩu mới">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputNewPassAgain" class = "col-md-4 control-label">Nhập lại mật khẩu</label>
                            <div class ="col-md-8">
                                <input type="password" class="form-control" id="inputNewPassAgain" placeholder="Nhập lại mật khẩu mới">
                            </div>
                        </div>
                    </form>
                    <div>
                        <div class="row">
                            <div class="col-md-offset-4 col-xs-offset-1">
                                <input type="submit" class="btn btn-primary" value="Xác nhận" />
                                <button class="btn btn-warning " data-dismiss="#">Hủy bỏ</button>
                            </div>
                        </div>
                    </div>				
                </div><!-- /Form  -->
            </div><!-- /row -->
        </div><!-- /Phần Đổi MK -->
@endsection