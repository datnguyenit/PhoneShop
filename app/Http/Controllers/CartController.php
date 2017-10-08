<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cart;
use App\products;
use App\bills;
use App\bill_detail;
use Response;

class CartController extends Controller
{
    //Thêm vao gio hang without ajax
    public function getPageAddToCart($id){
        $status = ($this->getAddToCart($id));
        if($status['status'])
            return redirect()->back();
    }
    //các thao tác trên giỏ hàng
    public function getAddToCart($id){
        $product = products::findOrFail($id);
        $mess='';
        $status=true;
        $price = ($product->promotion_price<=0)?$product->unit_price:$product->promotion_price;
        try{
            Cart::add(['id'=>$id,'name'=>$product->name,'qty'=>1,'price'=>$price,'options'=>['image'=>$product->image]]);
            $mess="Đã thêm vào giỏ hàng";
            $status=true;
        }catch(\Exception $e){
            $mess="Thêm vào giỏ hàng thất bại";$status=false;
        }
        return ['cart_count'=>Cart::count(),'mess'=>$mess,'status'=>$status];
    }
    public function getCart(){
        return Cart::content();
    }

    public function updateCart($rowid,$qty){
        $mess='';
        $subtotal=null;
        $status = false;
        try{
            Cart::update($rowid,$qty);
            $subtotal = Cart::get($rowid)->subtotal();
            $mess = 'Cập nhật giỏ hàng thành công';
            $status = true;
         }catch(\Exception $e){
            $mess='Cập nhật giỏ hàng thất bại';
             $status = false;
            // return ['cart_count'=>Cart::count(),'mess'=>$mess];
         }
         return ['cart_count'=>Cart::count(),'cart_total'=>number_format(Cart::subtotal()),'mess'=>$mess,'subtotal'=>number_format($subtotal),'status'=>$status];
    }

    public function deleteProduct($rowid){
        $mess='';
        $status = false;
        try{
            Cart::remove($rowid);
            $mess="Đã xóa";
            $status = true;
        }catch(\Exception $e){
            $mess="Xóa thất bại";
            $status = false;
        }
        return ['cart_count'=>Cart::count(),'cart_total'=>number_format(Cart::subtotal()),'mess'=>$mess,'status'=>$status];
    }

    public function checkCart(){
        if(Cart::count()<=0) 
            return Response::json('Giỏ hàng không có gì');
        return Response::json('true');
    }
}
