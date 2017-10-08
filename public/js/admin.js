function test(){
	alert('hello');
	console.log('hello');
}

$('#form-create-user').validate({
	rules:{
		name: "required",
		email: {
			required: true,
			email: true,
			remote:{
				url:'admin/check-email',
				type:'GET',
			}
		},
		password: {
			required: true,
			minlength: 6,
		},
		phone: 'required',
		role_id: 'required',
	},
	submitHandler: function(form){
		// alert('OK');
		form.submit();
	}
});

$('#form-edit-user').validate({


	rules:{
		name: "required",
		email: {
			required: true,
			email: true,
			
		},
		password: {
			required: true,
			minlength: 6,
		},
		re_password: {
			required: true,
			minlength: 6,
			equalTo: '#password',
		},
		
		phone: 'required',
		role_id: 'required',
	},
	submitHandler: function(form){
		// alert($('#check-enable-edit-password').is(':checked'));
		form.submit();
	}
});

//form create product
$('#form-create-product').validate({
	rules:{
		name: "required",
		//alias: "required",
		unit_price: {
			required:true,
			number: true,
			range: [0,100000000],
			step:1000
		},
		promotion_price: {
			required:true,
			number: true,
			range: [0,100000000],
			step:1000,
			max: '#unit_price',
		},
		OS: "required",
		memory: "required",
		RAM: "required",
		display: "required",
		color: "required",

		manufacturer_id: 'required',
		type_id: 'required',
	},
	submitHandler: function(form){
		//alert('OK');
		form.submit();
	}
});


// form edit product 
$('#form-edit-product').validate({
	rules:{
		name: "required",
		//alias: "required",
		unit_price: {
			required:true,
			number: true,
			range: [0,100000000],
			step:1000
		},
		promotion_price: {
			required:true,
			number: true,
			range: [0,100000000],
			step:1000
		},
		OS: "required",
		memory: "required",
		RAM: "required",
		display: "required",
		color: "required",

		manufacturer_id: 'required',
		type_id: 'required',
	},
	submitHandler: function(form){
		// alert('OK');
		form.submit();
	}
});


$("input[name='image']").change(function(){
   if (this.files && this.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
        	// alert(e.target.result);
            $('.product_image').attr('src', e.target.result);
        }

        reader.readAsDataURL(this.files[0]);
    }
});




//PAGE BILL DETAIL - SOME EVENT
// click update 
$(document).on("click", ".btn-update-detail", function() {
	var id = $(this).attr('detail_id');
	var quantity = $(this).parent().parent().parent().find('input[name="detail_quantity"]').val();

	//element update
	var detail_unitprice = $(this).parent().parent().parent().find('.detail-unitprice');
	var detail_price = $(this).parent().parent().parent().find('.detail-price');
	var detail_total_price =$('#total_price_bill');
	// console.log(detail_unitprice);
	var row = $(this).closest('tr');

	if(quantity>0){
	//hàm update
		updateBillDetail(id,quantity,
			function(output){
				console.log(output);
				alert(output['mess']);
				if(output['status']){
					detail_unitprice.html(output['detail_unitprice']);
					detail_price.html(output['detail_price']);
					detail_total_price.html(output['detail_total_price']);
				}
			}
		);
	}else{
		//delete
		if(confirm('Bạn có muốn xóa!')){
			deleteBillDetail(id,function(output){
				console.log(output);
				alert(output['mess']);
				if(output['status']){
					row.remove();
					detail_total_price.html(output['detail_total_price']);
				}
			});
		}
	}
});
//click delete
$(document).on("click", ".btn-delete-detail", function() {
	if(confirm('Are you sure you want to delete?')){
		var id = $(this).attr('detail_id');

		//element update
		var row = $(this).closest('tr');
		var detail_total_price =$('#total_price_bill');

		deleteBillDetail(id,function(output){
			console.log(output);
			alert(output['mess']);
			if(output['status']){
				row.remove();
				detail_total_price.html(output['detail_total_price']);
			}
		});
	}
});

$('#btn-add-detail').click(function(){
	var bill_id = $(this).attr('bill_id');
	var table_detail = $('#table_detail');
	var detail_product = $('#detail_product').val();
	var detail_total_price =$('#total_price_bill');

	// table_detail.append('<tr><td>Hello</td></tr>');

	addBillDetail(bill_id,detail_product,function(output){
		//element
		console.log(output);
		alert(output['mess']);
		if(output['status']){
			//some element

			var detail_no = output['detail']['id'];
			var product_name = output['product']['name'];
			var product_image = output['product']['image'];
			var detail_quantity = output['detail']['quantity'];
			var detail_unitprice = output['detail']['price'];
			
			var html = '<tr><td>'+detail_no+'</td><td class="object-center">'+product_name+'</td><td class="object-center "><img class="height_product_image" src="image/products/'+product_image+'" alt=""> </td><td><input name="detail_quantity" type="number" class="form-control width_quantity_detail" step="1" min="0" max="10" value="1"> </td><td><p class="detail-unitprice">'+detail_unitprice+'</p></td><td><p class="detail-price">'+detail_unitprice+'</p></td><td class="object-center"> <span><button type="button" detail_id="'+detail_no+'" class="btn btn-warning btn-update-detail">Update</button></span> <span><button type="button" detail_id="'+detail_no+'" class="btn btn-danger btn-delete-detail" >Delete</button></span> </td></tr>';

			table_detail.append(html);
			detail_total_price.html(output['detail_total_price']);
		}
	});
});

//SOME FUNCTION FOR DETAIL
function addBillDetail(bill_id,product_id,handleData){
	$.ajax({
		url: 'admin/adminbill/adddetail/'+bill_id+'/'+product_id,
		type: 'get',

	}).done(function(data){
		handleData(data); // Pass data to a function
	}).fail(function(data){
		console.log(data);
	});
}
function updateBillDetail(id,quantity,handleData){
	$.ajax({
		url: 'admin/adminbill/updatedetail/'+id+'/'+quantity,
		type: 'get',

	}).done(function(data){
		handleData(data); // Pass data to a function
	}).fail(function(data){
		console.log(data);
	});
	// console.log(handleData);
}
function deleteBillDetail(id,handleData){
	$.ajax({
		url: 'admin/adminbill/deletedetail/'+id,
		type: 'GET',	
	}).done(function(data){
		handleData(data);
	}).fail(function(data){
		alert(data['mess']);
	})
}
//END FUNCTION



//PAGE IMPORT DETAIL -- SOME EVENT
	//update import detail
$(document).on("click", ".btn-update-import-detail", function() {
	var id = $(this).attr('detail_id');
	var quantity = $(this).parent().parent().parent().find('input[name="detail_quantity"]').val();

	console.log(quantity);
	$.ajax({
		url: 'admin/adminimport/updatedetail/'+id+'/'+quantity,
		type: 'get',

	}).done(function(data){
		 alert(data['mess']);
		 window.location.reload();
	}).fail(function(data){
		 alert(data['mess']);
	});

});
	//delete import detail
$(document).on("click", ".btn-delete-import-detail", function() {
	if(confirm('Are you sure you want to delete?')){
		var id = $(this).attr('detail_id');

		//
		$.ajax({
			url: 'admin/adminimport/deletedetail/'+id,
			type: 'GET',	
		}).done(function(data){
			alert(data['mess']);
		 	window.location.reload();
		}).fail(function(data){
			alert(data['mess']);
		});
	}

});