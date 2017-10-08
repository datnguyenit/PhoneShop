<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\products;
use App\manufacturers;
use DB;
use Input;
use Illuminate\Database\Query\Builder;


class SearchController extends Controller
{
    //
    public function getDienThoai(Request $request){
      	$products = products::get();
      	$manus = manufacturers::get();
    	return view('client.page.dienthoai',compact('products','manus','name'));
    }
    public function postDienThoai(Request $request){
        $request->session()->reflash();
    	$manu = $request->manufacturer;
    	$price_range = $request->price_range;
    	$order = $request->order;
        $keyword = $request->keyword;

        //IF clause in SELECT
        $q = products::query();
        
        //handle with select manufacturer
        ($manu>0)?$q->where('manufacturer_id',$manu):null;
        //handle with keyword
        (strlen($keyword)>0)?$q->where('name','like','%'.$keyword.'%'):null;
        //handle with select range of price
        switch ($price_range) {
            case 0:
                break;
            case 1:
                $q->whereBetween('price',[0,5000000]);
                break;
            case 2:
                 $q->whereBetween('price',[5000000,10000000]);
                break;
            case 3:
                 $q->whereBetween('price',[10000000,15000000]);
            case 4:
                 $q->where('price','>=',15000000);
                break;
            default:
                break;
        }
         //handle with select order
        // dd($order);
        switch ($order) {
            case null:
                break;
            case 0:
                $q->orderBy('price','asc');
                break;
            case 1:
                $q->orderBy('price','desc');
                break;
            default:          
                break;
        }
        // dd($q->toSql());
        //get all()
        $products = $q->get();
        $manus = manufacturers::get();
        // dd($q->toSql());
        // dd($q->get());

        session()->flash('manufacturer', $manu);
        session()->flash('price_range', $price_range);
        session()->flash('order', $order);
        session()->flash('keyword', $keyword);

    	return view('client.page.dienthoai',compact('products','manus'));
    }

    //update toàn bộ giá bán của sản phẩm vào cột price vừa tạo
    public function updateAllPrice(){
        try{
            $products = products::get();

            foreach($products as $product){
                $product->price = ( $product->promotion_price>0)? $product->promotion_price: $product->unit_price;
                $product->save();
            }
            return redirect()->back()->with(['mess'=>'Update successfully']);
        }catch(\Exception $e){
            return redirect()->back()->with(['mess'=>'Update failed']);
        }
    }
}
