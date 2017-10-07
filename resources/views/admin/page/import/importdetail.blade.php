@extends('admin.layout.master')
@section('content')
	@section('title')
		Admin Import - Detail
	@endsection
	@section('breadcrumb')
	<ol class="breadcrumb">
	  	<li class="breadcrumb-item"><a href="{{route('getadminindex')}}">Home</a></li>
	  	<li class="breadcrumb-item"><a href="
	  		@if($type == 0)
	  		{{route('getlistimportcanceled')}}
			@else 
				@if($type==2)
					{{route('getlistimportpaid')}}
				@else
					{{route('getadminimport')}}
				@endif
			@endif
	  	">
	  	Import</a></li>
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
					<span class="panel-title">Detail of Import no. <strong>{{$import->id}}</strong></span>
					<span><a href="#modal-add-product" data-toggle="modal" class="btn btn-xs btn-success pull-right"><i class="glyphicon glyphicon-plus-sign"></i> Add Product to Detail</a></span>
				</div>
				<div class="panel-body">
					<table class="table table-bordered table-hover">
						<thead>
							<tr class="title-center">
								<th>No.</th>
								<th>Product</th>
								<th>Image</th>
								<th>Quantity</th>
								<th>Import_price</th>
								<th>Price</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody id="table_detail">
							@foreach($import_detail as $detail)
							<tr>
								<td>{{$detail->id}}</td>
								<td class="object-center">{{$detail->productname}}</td>
								<td class="object-center "><img class="height_product_image" src="image/products/{{$detail->image}}" alt="{{$detail->productimage}}"></td>
								<td><input name="detail_quantity" type="number" class="form-control width_quantity_detail" step="1" min="0" max="1000" value="{{$detail->quantity}}"></td>
								<td><p class="detail-unitprice">{{number_format($detail->price)}}</p></td>					
								<td><p class="detail-price">{{number_format($detail->price*$detail->quantity)}}</p></td>					
								<td class="object-center">
									<span><button type="button" detail_id="{{$detail->id}}" class="btn btn-warning btn-update-import-detail">Update</button></span>
									<span><button type="button" detail_id="{{$detail->id}}" class="btn btn-danger btn-delete-import-detail" >Delete</button></span>
								</td>
							</tr>
							@endforeach
						</tbody>
						<tfoot>
							<tr>
								<td colspan="5" class="object-right"><strong>Total:</strong></td>
								<td colspan="1" class="total_price_bill" id="total_price_bill">{{number_format($import->total_price)}} đ</td>
								<td ></td>
							</tr>
						</tfoot>
					</table>
					<div class="col-md-6 col-md-offset-3">
						<a href="{{route('getimportupdatequantity',$import->id)}}" onclick="return confirm('Pay this import?')" class="btn btn-success" style="width:100%">Payment and export receipt</a>
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
								<form action="{{route('postaddimportdetail')}}" method="POST" role="form">		
									<div class="form-group">
										<select name="product_id" class="form-control" required="required">
											@foreach($products as $product)
											<option value="{{$product->id}}" >{{$product->name}}</option>
											@endforeach
										</select>
									</div>			
									
									
									<div class="form-group col-md-6">
										<input type="number" class="form-control" min="0" max="1000" step="1" value="0" name="quantity">
										
									</div>
									<div class="form-group col-md-6">
										<input type="number" class="form-control" min="0" max="1000000000" step="1000" name="price">
									</div>
									
									<input type="hidden" name="_token" value="{{csrf_token()}}">
									<input type="hidden" name="import_id" value="{{$import->id}}">
									<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
									
									<button type="submit" class="btn btn-primary">Submit</button>
								</form>
								
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection