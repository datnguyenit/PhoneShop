@extends('admin.layout.master')
@section('content')
	@section('title')
		Admin Bill - Detail
	@endsection
	@section('breadcrumb')
	<ol class="breadcrumb">
	  	<li class="breadcrumb-item"><a href="{{route('getadminindex')}}">Home</a></li>
	  	<li class="breadcrumb-item"><a href="
			@if($type==2)
				{{route('getadminreceipt')}}
			@else 
				@if($type==1)
					{{route('getadmincancel')}}
				@else
					{{route('getadminbill')}}
				@endif
			@endif
	  		">
	  	Bills</a></li>
	  	<li class="breadcrumb-item active">Detail</li>
	</ol>
	@endsection
	<div class="row">
		<div class="col-md-12">
			@if(Session::has('mess'))
			<div class="alert alert-{{Session::get('style')}}">
				{{Session::get('mess')}}
			</div>
			@endif
			<div class="panel panel-success">
				<div class="panel-heading">
					<span class="panel-title">Detail of Bill no. <strong>{{$bill->id}}</strong></span>
					<span><a href="#modal-add-product" data-toggle="modal" class="btn btn-xs btn-success pull-right"><i class="glyphicon glyphicon-plus-sign"></i> Add Product</a></span>
				</div>
				<div class="panel-body">
					<table class="table table-bordered table-hover">
						<thead>
							<tr class="title-center">
								<th>No.</th>
								<th>Product</th>
								<th>Image</th>
								<th>Quantity</th>
								<th>Unit_price</th>
								<th>Price</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody id="table_detail">
							@foreach($bill_detail as $detail)
							<tr>
								<td>{{$detail->id}}</td>
								<td class="object-center">{{$detail->productname}}</td>
								<td class="object-center "><img class="height_product_image" src="image/products/{{$detail->image}}" alt="{{$detail->productimage}}"></td>
								<td><input name="detail_quantity" type="number" class="form-control width_quantity_detail" step="1" min="0" max="10" value="{{$detail->quantity}}"></td>
								<td><p class="detail-unitprice">{{number_format($detail->price)}}</p></td>					
								<td><p class="detail-price">{{number_format($detail->price*$detail->quantity)}}</p></td>					
								<td class="object-center">
									<span><button type="button" detail_id="{{$detail->id}}" class="btn btn-warning btn-update-detail">Update</button></span>
									<span><button type="button" detail_id="{{$detail->id}}" class="btn btn-danger btn-delete-detail" >Delete</button></span>
								</td>
							</tr>
							@endforeach
						</tbody>
						<tfoot>
							<tr>
								<td colspan="5" class="object-right"><strong>Total:</strong></td>
								<td colspan="1" class="total_price_bill" id="total_price_bill">{{number_format($bill->total_price)}} đ</td>
								<td ></td>
							</tr>
						</tfoot>
					</table>
					<div class="col-md-6 col-md-offset-3">
						<a href="{{route('getpaymentbill',$bill->id)}}" onclick="return confirm('Pay this bill?')" class="btn btn-success" style="width:100%">Payment and export receipt</a>
					</div>
				</div>
				
				<!-- Model -->
				<div class="modal fade" id="modal-add-product">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								<h4 class="modal-title">Add one</h4>
							</div>
							<div class="modal-body">
								<select id="detail_product" class="form-control" required="required">
									@foreach($products as $product)
									<option value="{{$product->id}}" >{{$product->name}}</option>
									@endforeach
								</select>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
								<button type="button" bill_id="{{$bill->id}}" class="btn btn-primary" id="btn-add-detail">Save changes</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection