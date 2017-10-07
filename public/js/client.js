//function thêm vào giỏ hàng
function dathang(id){
            // alert(id);
    $.ajax({
        'url':'add-to-cart/'+id,
        'type':'GET',
    }).done(function(data){
        alert(data['mess']);
        console.log(JSON.stringify(data));
        $('#total_quantity_cart').html(data['cart_count']);
    }).fail(function(data){
        alert(data);
    });
}

//event update giỏ hagn2
$('.btn-update-cart').click(function(){
    var rowid=$(this).attr('rowid');
    //ô input chứa dữ liệu đã nhập
    var qty = $(this).parent().parent().parent().find('input[name="quantity_product"]').val();
    if(qty<=0) {
        if(confirm('Bạn có muốn xóa?')){
            deleteProduct($(this));
        }
        return;
    }
    var product_subtotal = $(this).parent().parent().parent().find('.product_subtotal');
    // console.log(rowid);
    $.ajax({
        'url':'update-cart/'+rowid+'/'+qty,
        'type':'GET',
    }).done(function(data){
        if(data['status']){
            alert(data['mess']);
            console.log(JSON.stringify(data));
            $('#total_quantity_cart').html(data['cart_count']);
            $('#total_price_cart').html(data['cart_total']);
            product_subtotal.html(data['subtotal']);
        }else{
           alert(data['mess']);
           location.reload(); 
        }       
    }).fail(function(data){
        alert(data['mess']);
        location.reload();
    });
});
//event deleta giỏ hàng
$('.btn-delete-cart').click(function(){
    if(confirm('Bạn có muốn xóa!')){
        deleteProduct($(this));
    }
});
//hàm xóa sản phẩm ra khỏi giỏ hàng
function deleteProduct(thisObj){
    var rowid = thisObj.attr('rowid');
    var tr =  thisObj.closest('tr');
    console.log(tr);
    $.ajax({
        url: 'delete-product/' +rowid,
        type: 'GET',
    }).done(function(data){
        if(data['status']==true){
            tr.fadeOut(1000,function(){
                tr.remove();
            });
            alert(data['mess']);
            //update tổng giá và số lượng sản phẩm
            $('#total_quantity_cart').html(data['cart_count']);
            $('#total_price_cart').html(data['cart_total']);
        }else{
            location.reload();
        }
    }).fail(function(data){
        alert(data['mess']);
    });
}

//validate dành cho form thanh toán đơn hàng
$('#form-payment').validate({
    rules:{
        name: 'required',
        email: {
            required:true,
            email: true,
        },
        address: 'required',
        phone: {
            required:true,
            minlength:6
        },
    },
    messages:{
        // name: 'Nhập tên đi bạn'
    },submitHandler: function(form) {
        $.ajax({
            url: 'check-cart',
            type:'get',
        }).done(function(data){
            console.log(data);
            if(data=='true')
                form.submit();
            else{
                alert(data);
            }
        });
    }
});


//function thêm vào pop up so sánh
function addCompare(id){
    location.href="add-popcompare/"+id;
}
function removeCompare(pos){
    location.href="remove-popcompare/"+pos;
}



//Trang tìm kiếm nâng cao điện thoại
//    THUA



//trang login
$('#form-login').validate({
    rules:{
        email: {
            required: true,
            email: true
        },
        password: "required",
    },
    messages:{
         email: {
            required: "Không được để trống email",
            email: "Email không đúng định dạng"
        },
        password: "Không được để trống password",
    }
});


$('#keyword').keyup(function(){
    console.log($(this).val());
    var keyword = $(this).val();
    $.ajax({
        url:'dienthoai',
        type: 'post',
        data: {
            keyword: keyword,
        },
        success: function(data){
            window.location.reload();
        }
    });
});