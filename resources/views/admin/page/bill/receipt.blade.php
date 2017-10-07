@extends('client.layout.master2')
@section('content')	
	<div class="container receipt" >
		<div class="row">
			<div class="col-md-3 col-sm-3 col-xs-3 obj-center">
				
				Date:<span id="date"></span>
			</div>
			<div class="col-md-6 col-sm-6 col-xs-6 col-md-offset-3 col-sm-offset-3 col-xs-offset-3 obj-center">
				Công ty Di động toàn cầu
				<address>25 Hàn thuyên, Thủ đức</address>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6 col-md-offset-3 obj-center">
				<h1>Receipt phone</h1>
				<h4>Bill no.  {{$bill->id}}</h4>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12 receipt_info">
				<h4><strong>Customer name: </strong>{{$bill->name}}</h4>
				<h4><strong>Address: </strong>{{$bill->address}}</h4>
				<h4><strong>Phone: </strong>{{$bill->phone}}</h4>
				<h4><strong>Ordered at: </strong>{{$bill->created_at}}</h4>
				<table class="table table-bordered">
					<thead>
						<tr>
							<th>No.</th>
							<th>Product</th>
							<th>Quantity</th>
							<th>Unit price</th>
							<th>Price</th>
						</tr>
					</thead>
					<tbody>
						@foreach($bill_detail as $key=>$detail)
						<tr>
							<td>{{$key+1}}</td>
							<td>{{$detail->productname}}</td>
							<td>{{$detail->quantity}}</td>
							<td>{{number_format($detail->price)}} đ</td>
							<td>{{number_format($detail->quantity*$detail->price)}} đ</td>
						</tr>
						@endforeach
						<tr>
							<td><strong>Total</strong></td>
							<td colspan="4" class="receipt_total" style="padding-right: 50px">{{number_format($bill->total_price)}} đ</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
		<div class="row receipt_info">
			<h4><strong>Notes:</strong></h4>
			<p>abc abc abc abc abc abc abc abc abc abc abc abc abc abc abc abc abc abc abc abc abc abc abc abc abc abc abc abc abc abc abc abc abc abc abc abc abc abc abc abc abc abc abc abc abc abc abc abc abc abc abc abc abc abc abc abc abc abc abc abc abc abc abc abc abc abc abc abc abc abc abc abc abc abc abc abc abc abc abc abc abc abc abc abc abc abc abc abc abc abc abc abc abc abc abc abc abc abc abc abc abc abc abc abc abc abc abc abc abc abc abc </p>
		</div>
		<div class="row">
			<div class="col-md-3  col-md-offset-9 col-xs-offset-9 col-lg-offset-9 obj-center receipt_cashier">
				<h4><strong>Cashier</strong></h4>
			</div>
		</div>
	</div>

@endsection
@section('script')
<script>
	// window.print();
	document.getElementById('date').innerHTML = Date();
</script>
@endsection