<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\products;
use App\bills;
use App\bill_detail;
use App\manufacturers;
use Cart;
use DateTime;
use Response;
use Session;

class HomeController extends Controller
{
    //
    public function getIndex(){
        $products_new = products::where('new',1)->get();
        $products_hot = products::where('hot',1)->get();
        return view('client.page.index',compact('products_new','products_hot'));
    }
   
    public function getDienThoaiSanPham($id){
        $product = products::findOrFail($id);
    	return view('client.page.dienthoaisanpham',compact('product'));
    }
    public function getLogin(){
    	return view('client.page.login');
    }
    public function getTimKiem(){
    	return view('client.page.timkiem');
    }
    
    public function getChiTietTinTuc(){
    	return view('client.page.chitiettintuc');
    }
    public function getGioHang(){
        $products = Cart::content();
    	return view('client.page.giohang',compact('products'));
    }
    public function getTinTuc(){
    	return view('client.page.tintuc');
    }
    public function getDoiMatKhau(){
    	return view('client.page.doimatkhau');
    }


    



    //Thao tác trên form thông tin đăt hàng. Các thông tin này sau khi được request thì lưu trên bảng bills
    public function postPayment(Request $request){
        try{
            $bill = new bills();
            $bill->name = $request->name;
            $bill->email = $request->email;
            $bill->address = $request->address;
            $bill->phone = $request->phone;
            $bill->status = 1;
            // $bill->created_at = new DateTime();

            $bill->total_price = Cart::subtotal();
            $bill->save();

            
            $cart_current = Cart::content();
            foreach($cart_current as $product){
                $bill_detail = new bill_detail();
                $bill_detail->bill_id = $bill->id;
                $bill_detail->product_id = $product->id;
                $bill_detail->quantity = $product->qty;
                $bill_detail->price = $product->price;
                $bill_detail->save();
            }

            $mess = "Đã yêu cầu đặt hàng! Thông tin đơn hàng sẽ được gửi tới email của bạn!";
            Cart::destroy();
            return redirect()->back()->with(['mess'=>$mess]);
        }catch(\Exception $e){
            return abort(404); //it's automatically redirect to your resources/views/errors/404.blade.php
        }
    }


    //Thao tác trên trang so sanh sản phẩm
    public function getCompareProduct($id1,$id2){
        $product1 = products::findOrFail($id1);
        $product2 = products::findOrFail($id2);

        $manu1  = manufacturers::findOrFail($product1->manufacturer_id)->name;
        $manu2  = manufacturers::findOrFail($product2->manufacturer_id)->name;

        //xóa session popup
        Session::forget('popcomp');
        Session::forget('popcomp1');
        Session::forget('popcomp2');
        return view('client.page.compare',compact('product1','product2','manu1','manu2'));
    }


    //Thao tác trên pop up sosanh nằm trên trang header
    public function addPopCompare($id){
        $mess = '';

        $pos=0;
        if(Session::has('popcomp1')) $pos=1;
        switch ($pos) {
            case 0:
                # code...
                // if(Session::has('popcomp1')) {
                //     $mess='Đã tồn tại slot 1';
                // }
                
                    $product1 =  products::findOrFail($id);
                    Session::put('popcomp1',$product1);
                
                break;
            case 1:
                // if(Session::has('popcomp2')) {
                //     $mess='Đã tồn tại slot 2';
                // }
                
                    $product2 =  products::findOrFail($id);
                    Session::put('popcomp2',$product2);
                
                break;
            default:
                # code...
                $mess = 'Hãy quên đi';
                break;
        }
        Session::put('popcomp',true);
        return redirect()->back();
    }
    public function removePopCompare($pos){
        switch ($pos) {
            case 0:
                # code...
                Session::forget('popcomp1');
                break;
            case 1:
                Session::forget('popcomp2');
                break;
            default:
                # code...
                break;
        }
        if(!Session::has('popcomp1') && !Session::has('popcomp2')){
            Session::forget('popcomp');
        }
        return redirect()->back();
    }
}
