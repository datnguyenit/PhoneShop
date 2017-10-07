@extends('admin.layout.master')
@section('content')
	@section('title')
		Admin Receipts
	@endsection
	@section('breadcrumb')
	<ol class="breadcrumb">
	  	<li class="breadcrumb-item"><a href="{{route('getadminindex')}}">Home</a></li>
	  	<li class="breadcrumb-item active">Receipts</li>
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
					<span class="panel-title">List Receipts</span>
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
									<span><a href="{{route('getreceipt',$bill->id)}}" class="btn btn-warning button-max">detail</a></span>
								</td>
								<td class="object-center">
									@if ($bill->status == 2)
									<span><a href="{{route('getactivebill',$bill->id)}}" class="btn btn-danger">Return to Bill</a></span>
									@endif
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