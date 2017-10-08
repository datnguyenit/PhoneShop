@extends('admin.layout.master')
@section('content')
	@section('title')
		Admin Product/ edit
	@endsection
	@section('breadcrumb')
	<ol class="breadcrumb">
	  <li class="breadcrumb-item"><a href="{{route('getadminindex')}}">Home</a></li>
	   <li class="breadcrumb-item"><a href="{{route('getadminproduct')}}">Product</a></li>
	  <li class="breadcrumb-item active">Edit</li>
	</ol>
	@endsection
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-success">
				<div class="panel-heading">
					<h3 class="panel-title">Edit Product</h3>
					
				</div>
				<div class="panel-body">
					<form action="{{route('posteditproduct')}}" method="POST" class="form-horizontal col-md-8 col-md-offset-2" role="form" id="form-edit-product" enctype="multipart/form-data">
							<div class="form-group object-center">
								<legend>Product <span><strong>{{$product->name}}</strong></span></legend>
							</div>
							@if(Session::has('mess'))
							<div class="alert alert-{{Session::get('style')}}">
								{{Session::get('mess')}}
							</div>
							@endif
							<input type="hidden" name="id" value="{{$product->id}}">
							<div class="form-group">
								<div class="col-md-3">
									Name:
								</div>
								<div class="col-md-9">
									<input type="text" class="form-control" name="name" value="{{old('name',$product->name)}}">
								</div>
							</div>

							<div class="form-group">
								<div class="col-md-3">
									Detail:
								</div>
								<div class="col-md-9">
									<input type="text" class="form-control" name="detail" value="{{old('detail',$product->detail)}}">
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-3">
									Unit price:
								</div>
								<div class="col-md-9">
									<input type="text" class="form-control" name="unit_price" value="{{old('unit_price',$product->unit_price)}}">
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-3">
									Promotion price:
								</div>
								<div class="col-md-9">
									<input type="text" class="form-control" name="promotion_price" value="{{old('promotion_price',$product->promotion_price)}}">
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-3">
									OS:
								</div>
								<div class="col-md-9">
									<input type="text" class="form-control" name="OS" value="{{old('OS',$product->OS)}}">
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-3">
									Memory:
								</div>
								<div class="col-md-9">
									<input type="text" class="form-control" name="memory" value="{{old('memory',$product->memory)}}">
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-3">
									RAM:
								</div>
								<div class="col-md-9">
									<input type="text" class="form-control" name="RAM" value="{{old('RAM',$product->RAM)}}">
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-3">
									Display:
								</div>
								<div class="col-md-9">
									<input type="text" class="form-control" name="display" value="{{old('display',$product->display)}}">
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-3">
									Color:
								</div>
								<div class="col-md-9">
									<input type="text" class="form-control" name="color" value="{{old('color',$product->color)}}">
								</div>
							</div>

							<div class="form-group">
								<div class="col-md-3">
									Manufacturer:
								</div>
								<div class="col-md-9">
									<select name="manufacturer_id" class="form-control">
										<option selected disabled>-- Choose One --</option>
										@foreach($manufacturers as $manufacturer)
										<option value="{{$manufacturer->id}}" 
										@if($product->manufacturer_id == $manufacturer->id)
											selected 
										@endif
											>{{$manufacturer->name}}</option>
										@endforeach
									</select>
								</div>
							</div>

							<div class="form-group">
								<div class="col-md-3">
									Type:
								</div>
								<div class="col-md-1">
									<div class="checkbox">
										<label>
											<input type="checkbox" id="check-enable-choose-type">
										</label>
									</div>
								</div>
								<div class="col-md-8">
									<select name="type_id" id="choose_type_id" class="form-control " disabled>
										<option selected disabled>-- Choose One --</option>
										@foreach($types as $type)
										<option value="{{$type->id}}"
											@if($type_product->type_id == $type->id)
												selected 
											@endif
											>{{$type->name}}</option>
										@endforeach
									</select>
								</div>
							</div>

							<div class="form-group">
								<div class="col-md-3">
									Status:
								</div>
								<div class="col-md-9">
									<input type="radio" name="status" value="1" checked> Active
									<input style="margin-left:15px" type="radio" name="status" value="0"
										@if($product->status==0) checked @endif
									> Non-active
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-3">
									Upload image:
								</div>
								<div class="col-md-2">
									<img src="image/products/{{$product->image}}" alt="{{$product->image}}" class="product_image">
								</div>
								<div class="col-md-6 upload_file ">
									<input type="file" name="image" >
								</div>
							</div>
							<input type="hidden" name="_token" value="{{csrf_token()}}">
							<div class="form-group object-center">
								<div class="col-sm-12">
									<button type="submit" class="btn btn-success button-long">Edit</button>
								</div>
							</div>
					</form>
				</div>
			</div>
		</div>
	</div>
@endsection
@section('script')
	<script>
		$('#check-enable-choose-type').change(function(){
			if($(this).is(':checked')){
				$('#choose_type_id').removeAttr('disabled');
			}else{
				$('#choose_type_id').attr('disabled','');
			}
			// alert('hi');
		});
	</script>
@endsection