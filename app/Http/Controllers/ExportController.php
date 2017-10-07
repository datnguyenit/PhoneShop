<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\bills;
use App\bill_detail;
use App\export;
use App\export_detail;
use App\User;
use App\products;
class ExportController extends Controller
{
    //
    public function getListWaitingReceipt(){
    	//get ra  LIST hóa đơn đã được thanh toán - Bill['status'] =2
    	$bills = bills::where('status',2)->get();
    	return view('admin.page.export.listwaitingreceipt',compact('bills'));
    }

     public function getListExportReceipt(){
    	//get ra  LIST hóa đơn đã được thanh toán - Bill['status'] =2
    	$bills = bills::where('status',3)->get();
    	return view('admin.page.export.listexportreceipt',compact('bills'));
    }


    public function getExportProduct($userid,$id){
    	$status = true;
    	try{
    		//check data
    		$bill = bills::findOrFail($id);
    		$user = User::findOrFail($userid);
    		//tạo mới export dựa tên userid
    		$export  = new export();
    		$export->user_id = $userid;
    		$export->status = 1;
    		$export->save();

    		//bill detail
    		$bill_detail = bill_detail::where('bill_id',$bill->id)->get();
    		// dd($bill_detail);
    		//copy data from bill detail to export detail
    		foreach($bill_detail as $detail){
    			$export_detail = new export_detail();
    			$export_detail->export_id = $export->id;
    			$export_detail->product_id = $detail->product_id;
    			$export_detail->quantity = $detail->quantity;
    			$export_detail->price = $detail->price;
    			$export_detail->save();
    		}
    		//update total quantity anh price
    		$total_quantity =0;$total_price= 0;
    		$export_detail = export_detail::where('export_id',$export->id)->get();
    		foreach($export_detail as $detail){
    			$total_quantity +=$detail->quantity;
    			$total_price +=($detail->quantity*$detail->price);

    			//update total of product
    			$product = products::findOrFail($detail->product_id);
    			$product->quantity -= $detail->quantity;
    			$product->save();
    		}
    		$export->total_quantity =$total_quantity;
    		$export->total_price =$total_price;
    		$export->save();

    		//update status of bill: This bill has paid and product has got
    		$bill->status = 3;
    		$bill->save();
    		$status = true;
    	}catch(\Excetion $e){
    		$status =false;
    	}
    	if($status)
    		return redirect()->back()->with(['mess'=>'Get stock successfully']);
    	return redirect()->back()->with(['mess'=>'Get stock failed']);
    }
}
