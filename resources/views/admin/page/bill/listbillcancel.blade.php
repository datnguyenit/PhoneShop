@extends('admin.layout.master')
@section('content')
	@section('title')
		Admin Bills
	@endsection
	@section('breadcrumb')
	<ol class="breadcrumb">
	  	<li class="breadcrumb-item"><a href="{{route('getadminindex')}}">Home</a></li>
	  	<li class="breadcrumb-item active">Bill</li>
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
					<span class="panel-title">List Bills</span>
					<!-- <span><a href="{{route('getcreateproduct')}}" class=" btn btn-xs btn-success pull-right"><i class="glyphicon glyphicon-plus-sign"></i> Add New Product</a></span> -->
				</div>
				<div class="panel-body">
					<table class="table table-bordered table-hover">
						<thead>
							<tr class="title-center">
								<th>No.</th>
								<th>Name</th>
								<th>Address</th>
								<th>Phone</th>
								<th>Total Price</th>
								<th>Status</th>
								<th>Detail</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							@foreach($bills as $bill)
							<tr>
								<td>{{$bill->id}}</td>
								<td>{{$bill->name}}</td>							
								<td>{{$bill->address}}</td>
								<td>{{$bill->phone}}</td>
								<td>{{$bill->total_price}}</td>
								<td>{{$bill->status}}</td>
								<td>
									<span><a href="{{route('getbilldetail',[$bill->id,1])}}" class="btn btn-warning">detail</a></span>
									@if($bill->status == 1)
									<span><a href="{{route('getcancelbill',$bill->id)}}" class="btn btn-default">Cancel</a></span>
									@else
										@if($bill->status == 0)
											<span><a href="{{route('getactivebill',$bill->id)}}" class="btn btn-success">Active</a></span>
										@endif
									@endif
								</td>
								<td class="object-center">
									<span><a href="#" class="btn btn-info">Edit</a></span>
									<span><a href="#" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete?');">Delete</a></span>
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