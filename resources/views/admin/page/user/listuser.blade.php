@extends('admin.layout.master')
@section('content')
	@section('title')
		Admin User
	@endsection
	@section('breadcrumb')
	<ol class="breadcrumb">
	  <li class="breadcrumb-item"><a href="{{route('getadminindex')}}">Home</a></li>
	  <li class="breadcrumb-item active">User</li>
	</ol>
	@endsection
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-success">
				<div class="panel-heading">
					<span class="panel-title">List Users</span>
					<span><a href="{{route('getcreateuser')}}" class=" btn btn-xs btn-success pull-right"><i class="glyphicon glyphicon-plus-sign"></i> Add Admin User</a></span>
				</div>
				<div class="panel-body">
					<table class="table table-bordered table-hover">
						<thead>
							<tr class="title-center">
								<th>No.</th>
								<th>Name</th>
								<th>Email</th>
								<th>Phone</th>
								<th>Role</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							@foreach($users as $user)
							<tr>
								<td>{{$user->id}}</td>
								<td>{{$user->name}}</td>
								<td>{{$user->email}}</td>
								<td>{{$user->phone}}</td>
								<td>{{$user->role_id}}</td>
								<td class="object-center">
									<span><a href="{{route('getedituser',$user->id)}}" class="btn btn-info">Edit</a></span>
									<span><a href="{{route('getdeleteuser',$user->id)}}" class="btn btn-danger">Delete</a></span>
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