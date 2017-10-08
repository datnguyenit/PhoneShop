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
								<th>Current</th>
								<th>Imported</th>
								<th>Exported</th>
							</tr>
						</thead>
						<tbody>
							@foreach($products as $product)
							<tr>
								<td>{{$product->id}}</td>
								<td>{{$product->name}}</td>
								<td class="object-center"><img src="image/products/{{$product->image}}" alt="{{$product->image}}" height="35px"></td>	
								<td>{{$product->quantity}}</td>
								<td>
								@foreach($products_import as $import) 
									@if($import->id == $product->id)
										{{$import->total_quantity_import}}
										@break
									@endif
								@endforeach
								</td>
								<td>
								@foreach($products_export as $export) 
									@if($export->id == $product->id)
										{{$export->total_quantity_export}}
										@break
									@endif
								@endforeach
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