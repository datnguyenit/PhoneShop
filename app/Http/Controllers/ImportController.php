<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\import;
use App\import_detail;
use App\products;
use App\User;
class ImportController extends Controller
{
    //GET 3 LIST IMPORT - WAITING IMPORT
    public function getListImport(){
    	$imports = import::where('import.status',1)->join('users','import.user_id','=','users.id')->select('import.*','users.name as username')->get();

    	return view('admin.page.import.listimport',compact('imports'));
    }
    // CANCELED IMPORT
    public function getListImportCanceled(){
    	$imports = import::where('import.status',0)->join('users','import.user_id','=','users.id')->select('import.*','users.name as username')->get();

    	return view('admin.page.import.listimportcanceled',compact('imports'));
    }
    //PAID IMPORT
    public function getListImportPaid(){
    	$imports = import::where('import.status',2)->join('users','import.user_id','=','users.id')->select('import.*','users.name as username')->get();

    	return view('admin.page.import.listimportpaid',compact('imports'));
    }

    public function getImportDetail($id,$type){
    	$import = import::findOrFail($id);
    	$products = products::get();
    	$import_detail = import_detail::where('import_id',$id)->join('products','import_detail.product_id','=','products.id')->select('import_detail.*','products.id as productid','products.name as productname','products.image as image')->orderBy('created_at','asc')->get();

    	return view('admin.page.import.importdetail',compact('import','import_detail','products','type'));
    }




        //add import_detail
    public function postAddImportDetail(Request $request){
    	$mess ='';
    	$status = false;
    	try{
	    	$import_detail  = new import_detail();
	    	$import_detail->import_id = $request->import_id;
	    	$import_detail->product_id = $request->product_id;
	    	$import_detail->quantity = $request->quantity;
	    	$import_detail->price = $request->price;
	    	$import_detail->save();

	    	//update total price and total quantity
	    	$this->update_total_quantity_price($request->import_id);

	    	//return
	    	$mess = 'Added successfully';
	    	$status = true;

    	}catch(\Exception $e){
    		$mess = 'Added failly';
    		$status = false;
    	}
    	return redirect()->back()->with(['mess'=>$mess,'status'=>$status]);
    }
    //update bill_detail
    public function getUpdateImportDetail($id,$quantity){
    	$mess = '';
    	$status = false;
    	try{
	    	$import_detail = import_detail::findOrFail($id);
	    	$import_id = $import_detail->import_id;
	    	//if quantity input invalid => do nothing
			if($quantity<=0) {$import_detail->delete();}
			else{
				$import_detail->quantity = $quantity;			
				$import_detail->save();
			}
			//update total price and total quantity
			$this->update_total_quantity_price($import_id);	

			$mess="Updated successfully";
			$status = true;		
    	}catch(\Exception $e){
    		$mess = "Updated failly";
    		$status = false;
    	}
    	return ['mess'=>$mess,'status'=>$status];
    }
    //delete import _detail
    public function getDeleteImportDetail($id){
    	$mess = '';
    	$status = false;
    	try{
    		$import_detail = import_detail::findOrFail($id);
    		$import_id = $import_detail->import_id;
    		$import_detail->delete();
    		$this->update_total_quantity_price($import_id);

    		$mess = 'Deleted successfully';
    		$status = true;
	    	
    	}catch(\Exception $e){
			$mess = 'Deleted failly';
			$status = false;
    	}
    	return ['mess'=>$mess,'status'=>$status];
    }

    public function update_total_quantity_price($id){
    	try{
    		$import = import::findOrFail($id);

    		$import_details = import_detail::where('import_id',$id)->get();
    		//update
    		$total_quantity = 0;
    		$total_price = 0;

    		//foreach
    		foreach($import_details as $detail){
    			$total_quantity += $detail->quantity;
    			$total_price += ($detail->quantity*$detail->price);
    		}
    		$import->total_quantity = $total_quantity;
    		$import->total_price = $total_price;
    		$import->save();
    		return ['total_quantity'=>$import->total_quantity,'total_price'=>$import->total_price];
    	}
    	catch(\Exception $e){
    		return ['total_quantity'=>0,'total_price'=>0];
    	}
    }




    //CANCLE-ACTIVE WAITING IMPORT
    public function getCancelImport($id){
    	$import  = import::findOrFail($id);
    	$import->status = 0;
    	$import->save();
    	return redirect()->back()->with(['mess'=>'The import has been canceled!']);
    }
    //ACTIVE-
    public function getActiveImport($id){
    	$import  = import::findOrFail($id);
    	$import->status = 1;
    	$import->save();
    	return redirect()->back()->with(['mess'=>'The import has been actived!']);
    }


    //Update kho hàng -> cập nhật số lượng sản phẩm
    public function getImportUpdateQuantity($id){
    	try{
    		//update status
    		$import = import::findOrFail($id);
    		$import->status = 2;
    		$import->save();

    		$details = import_detail::where('import_id',$id)->get();
    		//update 
    		foreach($details as $detail){
    			$product = products::findOrFail($detail->product_id);
    			$product->quantity += $detail->quantity;
    			$product->save(); 
    		}
    	}catch(\Exception $e){
    		return redirect()->back()->with(['mess'=>'Updated product failed']);
    	}
    	return redirect()->route('getimportreceipt',$id);
    }


    //page view receipt of a import 
    public function getImportReceipt($id){
    	$import = import::where('import.id',$id)->join('users','import.user_id','=','users.id')->select('import.*','users.name as username')->first();
    	$details = import_detail::where('import_id',$id)->join('products','import_detail.product_id','=','products.id')->select('import_detail.*','products.id as productid','products.name as productname')->orderBy('created_at','asc')->get();
    	return view('admin.page.import.importreceipt',compact('import','details'));
    }


    //Create new import
    public function getCreateImport($user_id){
    	$import =  new import();
    	try{
    		//check user id
    		$user  = User::findOrFail($user_id);
    		$import->user_id=$user->id;
    		$import->save();
    		return redirect()->back()->with(['mess'=>'Create import successfully']);
    	}catch(\Exception $e){
    		return redirect()->back()->with(['mess'=>'Create import failed']);
    	}
    }


    //Return import receipt to understand import
    //Update lai5 kho hang2 - 
    // Diff quantity from stock
    public function getReceiptReturnToImport($id){
    	$status = true;
    	try{
    		$import = import::findOrFail($id);
    		$details = import_detail::where('import_id',$import->id)->get();

    		foreach($details as $detail){
    			$product = products::findOrFail($detail->product_id);

    			$product->quantity -= $detail->quantity;

    			if($product->quantity<0) {
    				$status = false;
    				return;
    			}else{
    				$product->save(); 
    			}
    		}
    		$import->status = 1;
    		$import->save();

    	}catch(\Exception $e){
    		$status = false;
    	}
    	if($status){
    		return redirect()->route('getadminimport');
    	}
    	return redirect()->back()->with(['mess'=>'Return fail']);
    }
}
