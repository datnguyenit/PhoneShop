<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\products;
use App\manufacturers;
use DB;
use Carbon\Carbon;
use App\bills;
use App\bill_detail;
use App\import_detail;
use Illuminate\Support\Facades\Input;


use App\types;
use App\type_product;

class ProductController extends Controller
{
    //
    public function getListProduct(){
    	// $products= products::join('manufacturers',function($join){
    	// 	$join->on('products.manufacturer_id','=','manufacturers.id');
    	// })->select('products.*','manufacturers.name as name_man')->get();
    	// dd($products);
    	$products = products::get();
    	return view('admin.page.product.listproduct',compact('products'));
	}
	public function getCreateProduct(){
		$manufacturers = manufacturers::get();
		$types = types::get();
		return view('admin.page.product.createproduct',compact('manufacturers','types'));
	}
	public function postCreateProduct(Request $request){
		try{
			$product=  new products();
			$product->name = $request->name;
			//change to alias
			$product->alias = $this->changToAlias($request->name);

			$product->detail = $request->detail;
			$product->unit_price = $request->unit_price;
			$product->promotion_price = $request->promotion_price;
			$product->OS = $request->OS;
			$product->memory = $request->memory;
			$product->RAM = $request->RAM;
			$product->display = $request->display;
			$product->color = $request->color;
			$product->manufacturer_id = $request->manufacturer_id;
			$product->status = $request->status;


			if(Input::hasFile('image')){
				echo('hello');
				$file = Input::file('image');
				$filename = $file->getClientOriginalName();
				$file->move('image/products',$filename);
				$product->image=$filename;
			}

			//update vào price de de sap xep (filter)
			$product->price = ( $request->promotion_price>0)? $request->promotion_price: $request->unit_price;
			$product->save();

			//chọn đối tượng theo loại
			if($request->type_id){
				$type_product = new type_product();
				$type_product->product_id=$product->id;
				$type_product->type_id = $request->type_id;
				$type_product->save();
			}else{
				//tạo mới loại
				$types = new types();
				$types->name = $product->name;
				$types->save();
				//chọn đối tượng vào loại vừa tạo
				$type_product = new type_product();
				$type_product->product_id=$product->id;
				$type_product->type_id = $types->id;
				$type_product->save();
			}

			return redirect()->back()->with(['mess'=>'Create product successful','style'=>'success']);
		}catch(\Exception $e){
			return redirect()->back()->withInput()->with(['mess'=>'Create product failed','style'=>'danger']);
		}
	}
	
	public function getEditProduct($id){
		$product = products::find($id);
		$manufacturers  = manufacturers::get();
		$types = types::get();
		$type_product = type_product::where('product_id',$product->id)->first();
		return view('admin.page.product.editproduct',compact('product','manufacturers','types','type_product'));
	}
	public function postEditProduct(Request $request){
		try{
			$product=  products::find($request->id);
			$product->name = $request->name;
			//change to alias
			if($request->name) 
				$product->alias = $this->changToAlias($request->name);

			$product->detail = $request->detail;
			$product->unit_price = $request->unit_price;
			$product->promotion_price = $request->promotion_price;
			$product->OS = $request->OS;
			$product->memory = $request->memory;
			$product->RAM = $request->RAM;
			$product->display = $request->display;
			$product->color = $request->color;
			$product->manufacturer_id = $request->manufacturer_id;
			$product->status = $request->status;

			if(Input::hasFile('image')){
				// echo('hello');
				$file = Input::file('image');
				$filename = $file->getClientOriginalName();
				$file->move('image/products',$filename);
				$product->image=$filename;
			}
			//update vào price de de sap xep (filter)
			$product->price = ( $request->promotion_price>0)? $request->promotion_price: $request->unit_price;
			$product->save();
			
           

			//chọn đối tượng theo loại
			if($request->type_id){
				$type_product = type_product::where('product_id',$product->id)->first();
				$type_product->type_id = $request->type_id;
				$type_product->save();
			}
			return redirect()->back()->with(['mess'=>'Edit product successful','style'=>'success']);
		}catch(\Exception $e){
			return redirect()->back()->withInput()->with(['mess'=>'Edit product failed','style'=>'danger']);
		}
	}
	//delete product
	public function getDeleteProduct($id){
		try{
			$product = products::findOrFail($id);
			$product->delete();
			return redirect()->back()->with(['mess'=>'Delete product successful','style'=>'success']);
			
		}catch(\Exception $e){
			return redirect()->back()->withInput()->with(['mess'=>'Delete product failed','style'=>'danger']);
		} 
	}


	public function changToAlias($str){
		return  str_replace(' ', '-',strtolower($str));
	}




	 //function update hot and new products
    public function getUpdateHotAndNew(){
    	try{
	    	//reset ve 0
	    	$products = products::get();
	    	foreach($products as $product){
	            $product->new = 0;
	            $product->hot = 0;
	            $product->save();
	        }

	        //update new
	        $new_products = products::orderBy('created_at','desc')->take(3)->get();
	        foreach($new_products as $product){
	            $product->new = 1;
	            $product->save();
	        }
	        //update hot
	        // lay ra nhung hoa don da xuat hang joiin vs bill_detail
	        // lay ra nhung bill deatil cua cac hoa don tren
	        // Join voi cac san pham co tren bill +detail tren

	        $hot_products = bill_detail::join('bills','bill_detail.bill_id','=','bills.id')->select('bill_detail.product_id',DB::raw('SUM(quantity) as total_quantity'))
	        	->where(function($q){
	        		$q->where('bills.status',3);       
	        		$q->whereMonth('bills.created_at', '=', Carbon::today()->month);		
	        		$q->whereYear('bills.created_at', '=', Carbon::today()->year);		
	        	})
				->groupBy('product_id')->orderBy('total_quantity','desc')->take(3)->get();
	        // dd($hot_products->get());

	        foreach($hot_products as $pro){
	        	$product = products::findOrFail($pro->product_id);
	            $product->hot = 1;
	            $product->save();
	        }
	        return redirect()->back()->with(['mess'=>'Update successfully']);
	    }catch(\Exception $e){
	    	 return redirect()->back()->with(['mess'=>'Update fail']);
	    }
	}


	//function create type auto :: sử dụng lục tạo mới (use one time)
	public function getCreateType(){
		$products = products::get();

		foreach($products as $product){
			$types = new types();
			$types->name = $product->name;
			$types->save();

			$type_product = new type_product();
			$type_product->product_id=$product->id;
			$type_product->type_id=$types->id;
			$type_product->save();
		}
		return types::get()->count();
	}



	//Thống ke sản phẩm
	public function getStatisticProduct(){
		// $products = import_detail::select('product_id', DB::raw('SUM(quantity) as total_quantity'))->groupBy('product_id')->get();
		$products_import = products::leftJoin('import_detail','products.id','=','import_detail.product_id')->groupBy('products.id')->select('products.id', DB::raw('SUM(import_detail.quantity) as total_quantity_import'))->get();
		$products_export = products::leftJoin('export_detail','products.id','=','export_detail.product_id')->groupBy('products.id')->select('products.id', DB::raw('SUM(export_detail.quantity) as total_quantity_export'))->get();
		
		$products = products::get();
		return view('admin.page.statistic.statistic',compact('products','products_import','products_export'));
	}
}
