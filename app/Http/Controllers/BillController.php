<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\bills;
use App\bill_detail;
use App\products;
use DateTime;
class BillController extends Controller
{
    //List bill
    public function getListBill(){
    	$bills = bills::where('status',1)->get();
    	return view('admin.page.bill.listbill',compact('bills'));
    }
    //list cancel
    public function getListBillCancel(){
    	$bills = bills::where('status',0)->get();
    	return view('admin.page.bill.listbillcancel',compact('bills'));
    }
    //list with payment
    public function getListBillReceipt(){
    	$bills = bills::where('status',2)->orwhere('status',3)->get();
    	return view('admin.page.bill.listbillreceipt',compact('bills'));
    }

    //bill detail
    public function getBillDetail($id,$type){
    	$type=$type;
    	$bill = bills::findOrFail($id);
    	//detail of this bill id
    	$bill_detail = bill_detail::where('bill_id','=',$id)->join('products','bill_detail.product_id','=','products.id')->select('bill_detail.*','products.id as productid','products.name as productname','products.image as image')->orderBy('created_at','asc')->get();
    	// dd($bill_detail);

    	//list product
    	$products=  products::get();

    	return view('admin.page.bill.billdetail',compact('bill','bill_detail','products','type'));
    }



    //receipt
    public function getReceipt($id){
    	$bill = bills::findOrFail($id);

    	$bill_detail = bill_detail::where('bill_id','=',$id)->join('products','bill_detail.product_id','=','products.id')->select('bill_detail.*','products.id as productid','products.name as productname')->get();

    	// dd($bill_detail);
    	return view('admin.page.bill.receipt',compact('bill','bill_detail'));
    }




    //add bill_detail
    public function getAddDetail($bill_id,$product_id){
    	$mess ='';
    	$status = false;
    	try{
	    	$bill_detail  = new bill_detail();
	    	$bill_detail->bill_id = $bill_id;
	    	$bill_detail->product_id = $product_id;
	    	$bill_detail->quantity = 1;


	    	$bill = bills::findOrFail($bill_id);
	    	$detail_total_price =$bill->total_price;

	    	//search id of product -> product
	    	$product = products::findOrFail($product_id);
	    	$bill_detail->price = ($product->promotion_price<=0)?$product->unit_price:$product->promotion_price;
	    	$bill_detail->save();

	    	$detail_total_price = $this->update_total_price($bill_id);

	    	//return
	    	$mess = 'Added successfully';
	    	$status = true;
	    	$product = products::findOrFail($product_id);
	    	return ['mess'=>$mess,'status'=>$status,'detail'=>$bill_detail,'product'=>$product,'detail_total_price'=>number_format($detail_total_price)];
    	}catch(\Exception $e){
    		$mess = 'Added failly';
    		$status = false;
	    	return ['mess'=>$mess,'status'=>$status,];
    	}
    }
    //update bill_detail
    public function getUpdateDetail($id,$quantity){
    	$mess = '';
    	$status = false;
    	try{
	    	$bill_detail = bill_detail::findOrFail($id);

	    	$bill = bills::findOrFail($bill_detail->bill_id);
	    	$bill_total_price =$bill->total_price;

	    	//if quantity input invalid => do nothing
			if($quantity<=0) {$bill_detail->delete();}
			else{
				if($quantity!=$bill_detail->quantity){
					$bill_detail->quantity = $quantity;
					//check giá mới của sản phẩm cũ
					$product = products::findOrFail($bill_detail->product_id);
					$bill_detail->price = ($product->promotion_price<=0)?$product->unit_price:$product->promotion_price;				
					$bill_detail->save();

					//update 
					$bill_total_price=$this->update_total_price($bill->id);
				}
			}

			$mess="Updated successfully";
			$status = true;

			//return 
			$detail_price = number_format($bill_detail->quantity*$bill_detail->price);
			$detail_unitprice = number_format($bill_detail->price);
			$detail_total_price = number_format($bill_total_price);
	    	return ['mess'=>$mess,'status'=>$status,'detail_price'=>$detail_price,'detail_unitprice'=>$detail_unitprice,'detail_total_price'=>$detail_total_price];
    	}catch(\Exception $e){
    		$mess = "Updated failly";
    		$status = false;
	    	return ['mess'=>$mess,'status'=>$status];
    	}
    }
    //delete bill _detail
    public function getDeleteDetail($id){
    	$mess = '';
    	$status = false;
    	try{
    		$bill_detail = bill_detail::findOrFail($id);
    		$bill = bills::findOrFail($bill_detail->bill_id);
	    	$detail_total_price = $bill->total_price;
			$bill_detail->delete();
    		//update 
			$detail_total_price = $this->update_total_price($bill->id);

    		$mess = 'Deleted successfully';
    		$status = true;
	    	return ['mess'=>$mess,'status'=>$status,'detail_total_price'=>number_format($detail_total_price)];
    	}catch(\Exception $e){
			$mess = 'Deleted failly';
			$status = false;
	    	return ['mess'=>$mess,'status'=>$status];
    	}
    }

    public function update_total_price($id){
    	try{
    		$bill = bills::findOrFail($id);

    		$bill_detail = bill_detail::where('bill_id',$id)->get();
    		//update
    		$total = 0;
    		//foreach
    		foreach($bill_detail as $detail){
    			$total += ($detail->quantity*$detail->price);
    		}
    		$bill->total_price = $total;
    		$bill->save();
    		return $bill->total_price;
    	}
    	catch(\Exception $e){
    		return 0;
    	}
    }






    //CANCLE-ACTIVE WAITING BILL
    public function getCancelBill($id){
    	$bill  = bills::findOrFail($id);
    	$bill->status = 0;
    	$bill->save();
    	return redirect()->back()->with(['mess'=>'The bill has been canceled!']);
    }
    public function getActiveBill($id){
    	$bill  = bills::findOrFail($id);
    	$bill->status = 1;
    	$bill->save();
    	return redirect()->back()->with(['mess'=>'The bill has been actived!']);
    }



    //Payment BILL ->receipt
    public function getPaymentBill($id){
    	$bill = bills::find($id);
    	$bill->status = 2;
    	$bill->save();

    	return redirect()->route('getreceipt',$id);
    }
}
