@extends('admin.layout.master')
@section('content')
	@section('title')
		Admin Product
	@endsection
	@section('breadcrumb')
	<ol class="breadcrumb">
	  	<li class="breadcrumb-item"><a href="{{route('getadminindex')}}">Home</a></li>
	  	<li class="breadcrumb-item active">Product</li>
	</ol>
	@endsection
	@if(Session::has('mess'))
	<div class="alert alert-{{Session::get('style')}}">
		{{Session::get('mess')}}
	</div>
	@endif
	<div class="row">
		<div class="col-md-12">
				<a href="{{route('getupdatehotandnew')}}" class="btn btn-success btn-lg">Update HOT and NEW</a>
				<a href="{{route('updateallprice')}}" class="btn btn-success btn-lg">Update PRICE for SORT</a>
		</div>
	</div>
	<br>
	<div class="row">
		<div class="col-md-12">
			
			<div class="panel panel-success">
				<div class="panel-heading">
					<span class="panel-title">List Product</span>
					<span><a href="{{route('getcreateproduct')}}" class=" btn btn-xs btn-success pull-right"><i class="glyphicon glyphicon-plus-sign"></i> Add New Product</a></span>
				</div>
				<div class="panel-body">
					<table class="table table-bordered table-hover">
						<thead>
							<tr class="title-center">
								<th>No.</th>
								<th>Name</th>
								<th>Image</th>
								<th>Manu.</th>
								<th>Unit_price</th>
								<th>Promotion_price</th>
								<th>Quantity</th>
								<th>Hot</th>
								<th>New</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							@foreach($products as $product)
							<tr>
								<td>{{$product->id}}</td>
								<td>{{$product->name}}</td>
								<td class="object-center"><img src="image/products/{{$product->image}}" alt="{{$product->image}}" height="35px"></td>	
								<td>{{$product->manufacturer->name}}</td>
								<td>{{$product->unit_price}}</td>
								<td>{{$product->promotion_price}}</td>
								<td>{{$product->quantity}}</td>
								<td>{{$product->hot}}</td>
								<td>{{$product->new}}</td>
								<td class="object-center">
									<span><a href="{{route('geteditproduct',$product->id)}}" class="btn btn-info">Edit</a></span>
									<span><a href="{{route('getdeleteproduct',$product->id)}}" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete?');">Delete</a></span>
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
@endsection