<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('admin',function(){
	return view('admin.layout.master');
});
Route::get('index',['as'=>'index','uses'=>'HomeController@getIndex']);

Route::get('dienthoaisanpham/{id}',['as'=>'dienthoaisanpham','uses'=>'HomeController@getDienThoaiSanPham']);
Route::get('login',['as'=>'login','uses'=>'HomeController@getLogin']);

Route::get('timkiem',['as'=>'timkiem','uses'=>'HomeController@getTimKiem']);

Route::get('chitiettintuc',['as'=>'chitiettintuc','uses'=>'HomeController@getChiTietTinTuc']);
Route::get('giohang',['as'=>'giohang','uses'=>'HomeController@getGioHang']);
Route::get('tintuc',['as'=>'tintuc','uses'=>'HomeController@getTinTuc']);
Route::get('doimatkhau',['as'=>'doimatkhau','uses'=>'HomeController@getDoiMatKhau']);


// giỏ hàng
Route::get('add-to-cart/{id}',['as'=>'addtocart','uses'=>'CartController@getAddToCart']);
Route::get('cart-content',['as'=>'cartcontent','uses'=>'CartController@getCart']);
// 	update giỏ hàng
Route::get('update-cart/{rowid}/{qty}',['as'=>'updatecart','uses'=>'CartController@updateCart']);
Route::get('delete-product/{id}',['as'=>'deleteproduct','uses'=>'CartController@deleteProduct']);
//	check giỏ hàng
Route::get('check-cart',['as'=>'checkcart','uses' => 'CartController@checkCart']);


//Hóa đơn
Route::post('payment',['as'=>'payment','uses'=>'HomeController@postPayment']);


//Trang so sánh sản phẩm
Route::get('compare/{id1}/{id2}',['as'=>'compare','uses'=>'HomeController@getCompareProduct']);

//Quản lý pop up so sánh sản phẩm
Route::get('add-popcompare/{id}',['as'=>'popcompare','uses'=>'HomeController@addPopCompare']);
Route::get('remove-popcompare/{pos}',['as'=>'popcompare','uses'=>'HomeController@removePopCompare']);




//Trang điện thoại với các chức năng tìm kiếm nâng cao
Route::get('dienthoai',['as'=>'dienthoai','uses'=>'SearchController@getDienThoai']);
Route::post('dienthoai',['as'=>'postdienthoai','uses'=>'SearchController@postDienThoai']);

//Route update toàn bộ giá bán vào cột  price của Sản phẩm (vừa mới tạo cột sản phẩm)
Route::get('update-all-price',['as'=>'updateallprice','uses'=>'SearchController@updateAllPrice']);



//Các trang quản trị viên (Admin)
Route::post('login',['as'=>'postlogin','uses'=>'AdminController@postLogin']);

Route::group(['prefix'=>'admin','middleware'=>['admin','preventback']],function(){
	Route::get('index',['as'=>'getadminindex','uses'=>'AdminController@getIndex']);
	Route::get('logout',['as' => 'getlogout','uses'=>'AdminController@getLogout']);

	//trang check có tồn tại user không?
	Route::get('check-email',['as'=>'getcheckemail','uses'=>'AdminController@getCheckEmail']);
	//user
	Route::group(['prefix'=>'adminuser'],function(){
		Route::get('/',['as' => 'getadminuser','uses'=>'AdminController@getListUser']);
		//create user
		Route::get('create',['as'=>'getcreateuser','uses'=>'AdminController@getCreateUser']);
		Route::post('create',['as'=>'postcreateuser','uses'=>'AdminController@postCreateUser']);
		//edit user
		Route::get('edit/{id}',['as'=>'getedituser','uses'=>'AdminController@getEditUser']);
		Route::post('edit',['as'=>'postedituser','uses'=>'AdminController@postEditUser']);
		//delete user
		Route::get('delete/{id}',['as'=>'getdeleteuser','uses'=>'AdminController@getDeleteUser']);
	});
	//Product
	Route::group(['prefix'=>'adminproduct'],function(){
		Route::get('/',['as'=>'getadminproduct','uses'=>'ProductController@getListProduct']);
		//craete product
		Route::get('create',['as'=>'getcreateproduct','uses'=>'ProductController@getCreateProduct']);
		Route::post('create',['as'=>'postcreateproduct','uses'=>'ProductController@postCreateProduct']);
		//edit product
		Route::get('edit/{id}',['as'=>'geteditproduct','uses'=>'ProductController@getEditProduct']);
		Route::post('edit',['as'=>'posteditproduct','uses'=>'ProductController@postEditProduct']);
		//delete product
		Route::get('delete/{id}',['as'=>'getdeleteproduct','uses'=>'ProductController@getDeleteProduct']);




		//update hot and new
		Route::get('update-hot-and-new',['as'=>'getupdatehotandnew','uses'=>'ProductController@getUpdateHotAndNew']);
	});
	//Bills
	Route::group(['prefix'=>'adminbill'],function(){
		//list bill...
		Route::get('/',['as'=>'getadminbill','uses'=>'BillController@getListBill']);
		Route::get('cancel',['as'=>'getadmincancel','uses'=>'BillController@getListBillCancel']);
		Route::get('receipt',['as'=>'getadminreceipt','uses'=>'BillController@getListBillReceipt']);

		//Bill_detail
		Route::get('detail/{id}/{type}',['as'=>'getbilldetail','uses'=>'BillController@getBillDetail']);

		//CURD bill_detail
		Route::get('adddetail/{bill_id}/{product_id}',['as'=>'getadddetail','uses'=>'BillController@getAddDetail']);
		Route::get('updatedetail/{id}/{quantity}',['as'=>'getupdatedetail','uses'=>'BillController@getUpdateDetail']);
		Route::get('deletedetail/{id}',['as'=>'getdeletedetail','uses'=>'BillController@getDeleteDetail']);

		//Active - Cancel bills
		Route::get('getCancelBill/{id}',['as'=>'getcancelbill','uses'=>'BillController@getCancelBill']);
		Route::get('getActiveBill/{id}',['as'=>'getactivebill','uses'=>'BillController@getActiveBill']);


		//Receipt
		Route::get('receipt/{id}',['as'=>'getreceipt','uses'=>'BillController@getreceipt']);

		//Payment
		Route::get('paymentBill/{id}',['as'=>'getpaymentbill','uses'=>'BillController@getPaymentBill']);
	});

	//Imports
	Route::group(['prefix'=>'adminimport'],function(){
		Route::get('/',['as'=>'getadminimport','uses'=>'ImportController@getListImport']);
		Route::get('canceled',['as'=>'getlistimportcanceled','uses'=>'ImportController@getListImportCanceled']);
		Route::get('paid',['as'=>'getlistimportpaid','uses'=>'ImportController@getListImportPaid']);

		Route::get('detail/{id}/{type}',['as'=>'getimportdetail','uses'=>'ImportController@getImportDetail']);

		//Add new import_detail
		Route::post('adddetail',['as'=>'postaddimportdetail','uses'=>'ImportController@postAddImportDetail']);
		//Update quantity  for import detail
		Route::get('updatedetail/{id}/{quantity}',['as'=>'getupdateimportdetail','uses'=>'ImportController@getUpdateImportDetail']);
		//Delete import_ detail
		Route::get('deletedetail/{id}',['as'=>'getdeleteimportdetail','uses'=>'ImportController@getDeleteImportDetail']);



		//active and canceled
		Route::get('cancelimport/{id}',['as'=>'getcancelimport','uses'=>'ImportController@getCancelImport']);
		Route::get('activeimport/{id}',['as'=>'getactiveimport','uses'=>'ImportController@getActiveImport']);

		//update product -> sớ lượng

		Route::get('updatequantity/{id}',['as'=>'getimportupdatequantity','uses'=>'ImportController@getImportUpdateQuantity']);
		

		//import receipt
		Route::get('importreceipt/{id}',['as'=>'getimportreceipt','uses'=>'ImportController@getImportReceipt']);


		//create import
		Route::get('create/{user_id}',['as'=>'getcreateimport','uses'=>'ImportController@getCreateImport']);


		//Return paid import To Wating import and diff product_quantity from stock
		Route::get('importreturn/{id}',['as'=>'getimportreturn','uses'=>'ImportController@getReceiptReturnToImport']); 
	});


	//Exports
	Route::group(['prefix'=>'adminexport'],function(){
		//list waiting receipt
		Route::get('waitingreceipt',['as'=>'getwaitingreceipt','uses'=>'ExportController@getListWaitingReceipt']);
		//list export receipt
		Route::get('exportreceipt',['as'=>'getexportreceipt','uses'=>'ExportController@getListExportReceipt']);

		//Get product from stock
		Route::get('exportproduct/{user}/{id}',['as'=>'getexportproduct','uses'=>'ExportController@getExportProduct']);

	});
});


//Các trang có Ajax sử dụng
Route::get('test',function(){return view('test');});