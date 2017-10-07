@extends('admin.layout.master')
@section('content')
	@section('title')
		Admin User/ create
	@endsection
	@section('breadcrumb')
	<ol class="breadcrumb">
	  <li class="breadcrumb-item"><a href="{{route('getadminindex')}}">Home</a></li>
	   <li class="breadcrumb-item"><a href="{{route('getadminuser')}}">User</a></li>
	  <li class="breadcrumb-item active">Create</li>
	</ol>
	@endsection
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-success">
				<div class="panel-heading">
					<h3 class="panel-title">Add Admin user</h3>
					
				</div>
				<div class="panel-body">
					<form action="{{route('postcreateuser')}}" method="POST" class="form-horizontal col-md-8 col-md-offset-2" role="form" id="form-create-user">
							<div class="form-group object-center">
								<legend>New Admin</legend>
							</div>
							@if(Session::has('mess'))
							<div class="alert alert-{{Session::get('style')}}">
								{{Session::get('mess')}}
							</div>
							@endif
							<div class="form-group">
								<div class="col-md-3">
									Name:
								</div>
								<div class="col-md-9">
									<input type="text" class="form-control" name="name" value="{{old('name')}}">
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-3">
									Email:
								</div>
								<div class="col-md-9">
									<input type="text" class="form-control" name="email" value="{{old('email')}}">
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-3">
									Password:
								</div>
								<div class="col-md-9">
									<input type="password" class="form-control" name="password" value="{{old('password')}}">
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-3">
									Phone:
								</div>
								<div class="col-md-9">
									<input type="text" class="form-control" name="phone" value="{{old('password')}}">
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-3">
									Role:
								</div>
								<div class="col-md-9">
									<select name="role_id" class="form-control">
										<option selected disabled>-- Choose Role --</option>
										@foreach($roles as $role)
										<option value="{{$role->id}}">{{$role->name}}</option>
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
									<input style="margin-left:15px" type="radio" name="status" value="0"> Non-active
								</div>
							</div>

							{{csrf_field()}}
							<div class="form-group object-center">
								<div class="col-sm-12">
									<button type="submit" class="btn btn-success button-long">Create</button>
								</div>
							</div>
					</form>
				</div>
			</div>
		</div>
	</div>
@endsection