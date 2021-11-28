//Tạo checkbox
$(document).ready(function(){
    $("#mytable #checkall").click(function () {
    if ($("#mytable #checkall").is(':checked')) {
        $("#mytable input[type=checkbox]").each(function () {
            $(this).prop("checked", true);
        });

    } else {
        $("#mytable input[type=checkbox]").each(function () {
            $(this).prop("checked", false);
        });
    }
});
$("[data-toggle=tooltip]").tooltip();
});
//Hiển thị thông tin sản phẩm
$('.table tbody').on('click','#btnView',function(){
    var currow = $(this).closest('tr');
    var col0 = currow.find('.product_name').text();
    var col1 = currow.find('.type_id').text();
    var col2 = currow.find('.old_price').text();
    var col3 = currow.find('.new_price').text();
    var col4 = currow.find('.quantity').text();
    var col5 = currow.find('.status').text();
    var result = 'Tên sản phẩm: '+ col0 + '\nLoại sản phẩm: '+ col1 + '\nGiá cũ: ' + col2+ '\nGiá mới: ' +col3 + '\nSố lượng: ' + col4+ '\nTrạng thái: ' + col5;
    alert(result);
})
//Lấy danh sách sản phẩm
$.ajax({
    url: "Product/viewProducts.php",
    type: "POST",
    cache: false,
    success: function(data){
        $('#table').html(data); 
    }
});
//Thêm sản phẩm
jQuery(document).ready(function(){
    $('#btn-add').click(function(e){
        e.preventDefault();
        var product_name = $('#product_name').val();
        var type_id = $('#type_id').val();
        var old_price = $('#old_price').val();
        var new_price = $('#new_price').val();
        var quantity = $('#quantity').val();
        var status = $('#status').val();
        var show = $('#show').val();
        $.ajax({
            type:"POST",
            url:"Product/addProduct.php",
            data:
            {
                product_name: product_name,
                type_id: type_id,
                old_price: old_price,
                new_price: new_price,
                quantity: quantity,
                status: status,
                show:show,
            },
            success:function(data){
                $('#table').load('Product/viewProducts.php');
                $('#notificationAdd').prepend(
                    `
                    <div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert">
                        <strong>Thêm</strong> sản phẩm thành công.
                        <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close"></button>
                    </div>
                    `
                )
                $("#success-alert").fadeTo(2000, 500).slideUp(500, function() {
                    $("#success-alert").slideUp(500);
                });
                $("#addForm")[0].reset();
            }
        })
    });
});
//xóa sản phẩm
jQuery(document).ready(function(){
    $('.table tbody').on('click','.clickDelete',function(e){
        e.preventDefault();
        var id = this.id;
        $.ajax({    
            type: "POST",
            url: "Product/deleteProduct.php", 
            data:{
                id : id
            },                           
            success: function(data){   
                $('#table').load('Product/viewProducts.php');
            }
        });
    });
});
//Sửa sản phẩm
jQuery(document).ready(function(){
    $('.table tbody').on('click','.clickEdit',function(e){
        e.preventDefault();
        var id = this.id;
        $.ajax({    
            type: "POST",
            url: "Product/showProduct.php", 
            data:{
                id : id
            },                           
            success: function(data){
                $('#productForm').html(data); 
            }
        });
    });
});
//Cập nhật thông tin sản phẩm
jQuery(document).ready(function(){
    $('.modal-body').on('click','.clickUpdate',function(e){
        e.preventDefault();
        var id = this.id;
        var product_name = $('#product_nameShow').val();
        var type_id = $('#type_idShow').val();
        var old_price = $('#old_priceShow').val();
        var new_price = $('#new_priceShow').val();
        var quantity = $('#quantityShow').val();
        var status = $('#statusShow').val();
        var show = $('#showShow').val();
        $.ajax({    
            type: "POST",
            url: "Product/updateProduct.php", 
            data:{
                id: id,
                product_name: product_name,
                type_id: type_id,
                old_price: old_price,
                new_price: new_price,
                quantity: quantity,
                status: status,
                show: show,
            },                           
            success: function(data){
                $('#table').load('Product/viewProducts.php');
                $('#notificationEdit').prepend(
                    `
                    <div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert">
                        <strong>Sửa</strong> thông tin sản phẩm thành công.
                        <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close"></button>
                    </div>
                    `
                )
                $("#success-alert").fadeTo(2000, 500).slideUp(500, function() {
                    $("#success-alert").slideUp(500);
                });
    
            }
        });
    });
});
//Click chuyen trang
jQuery(document).ready(function(){
    $('body').on('click', '.pagination li a', function (e) {
        e.preventDefault();// Không load lại trang khi click phân trang.
        let url = $(this).attr('href');
        var id = this.id;
        $.ajax({
            url: "Product/viewProducts.php",
            method: 'GET',
            data:{
                id: id
            },
            success: function (data) {
                $('#table').html(data); 
                // Thay đổi URL trên website
                window.history.pushState({path:url},'',url);
            }
        });
    });
});
//Hiển thị sản phẩm theo lựa chọn
jQuery(document).ready(function(){
$('.showProducts').on('change', function(e) {
    e.preventDefault();
    var value = this.value;
    $.ajax({
        url:"Product/viewProducts.php",
        type:"POST",
        data:{ value: value },
        success:function(data){
            $('#table').html(data); 
        }
    });
  });
});
//Lọc sản phẩm theo ngày tháng năm
jQuery(document).ready(function(){
    $('#filterDate').click(function(e){
        e.preventDefault();
        var dateFrom = $('#dateFrom').val();
        var dateTo = $('#dateTo').val();
        $.ajax({
            type:"POST",
            url:"Product/viewProducts.php",
            data:
            {
                dateFrom: dateFrom,
                dateTo: dateTo,
            },
            success:function(data){
                $('#table').html(data);
                $("#dateForm")[0].reset();
            }
        })
    });
});
// Tìm kiếm theo tên
$(document).ready(function() {
    $('#btnKey').on('keyup', function(e) {
       e.preventDefault();
       var keyword = $(this).val().toLowerCase();
       console.log(keyword);
       $('tbody tr').filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(keyword)>-1);
       });
    });
 });

// Lấy danh sách mã giảm giá
$.ajax({
    url: "Coupon/viewCoupons.php",
    type: "POST",
    cache: false,
    success: function(data){
        $('#table-coupon').html(data); 
    }
});
//Chuyển trang danh sách mã giảm giá
jQuery(document).ready(function(){
    $('body').on('click', '.pagination li a', function (e) {
        e.preventDefault();// Không load lại trang khi click phân trang.
        let url = $(this).attr('href');
        var id = this.id;
        $.ajax({
            url: "Coupon/viewCoupons.php",
            method: 'GET',
            data:{
                id: id
            },
            success: function (data) {
                $('#table-coupon').html(data); 
                // Thay đổi URL trên website
                window.history.pushState({path:url},'',url);
            }
        });
    });
});
//Hiển thị thông tin mã giảm giá
$('.table tbody').on('click','#btnViewCoupon',function(){
    var currow = $(this).closest('tr');
    var col0 = currow.find('.coupon_code').text();
    var col1 = currow.find('.type_coupon').text();
    var col2 = currow.find('.date_start').text();
    var col3 = currow.find('.date_end').text();
    var col4 = currow.find('.scale').text();
    var result = 'Mã giảm giá: '+ col0 + '\nLoại giảm giá: '+ col1 + '\nNgày bắt đầu: ' + col2+ '\nNgày kết thúc: ' +col3 + '\nMức giảm: ' + col4;
    alert(result);
})
//Thêm mã giảm giá
jQuery(document).ready(function(){
    $('#btn-addCoupon').click(function(e){
        e.preventDefault();
        var coupon_code = $('#coupon_code').val();
        var date_start = $('#date_start').val();
        var date_end = $('#date_end').val();
        var type_coupon = $('#type_coupon').val();
        var scale = $('#scale').val();
        $.ajax({
            type:"POST",
            url:"Coupon/addCoupon.php",
            data:
            {
                coupon_code: coupon_code,
                date_start: date_start,
                date_end: date_end,
                type_coupon: type_coupon,
                scale: scale,
            },
            success:function(data){
                $('#table-coupon').load('Coupon/viewCoupons.php');
                $('#notificationAdd').prepend(
                    `
                    <div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert">
                        <strong>Thêm</strong> mã giảm giá thành công.
                        <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close"></button>
                    </div>
                    `
                )
                $("#success-alert").fadeTo(2000, 500).slideUp(500, function() {
                    $("#success-alert").slideUp(500);
                });
                $("#addForm")[0].reset();
            }
        })
    });
});
//xóa mã giảm giá
jQuery(document).ready(function(){
    $('.table tbody').on('click','.clickDeleteCoupon',function(e){
        e.preventDefault();
        var id = this.id;
        $.ajax({    
            type: "POST",
            url: "Coupon/deleteCoupon.php", 
            data:{
                id : id
            },                           
            success: function(data){   
                $('#table-coupon').load('Coupon/viewCoupons.php');
            }
        });
    });
});
//Sửa mã giảm giá
jQuery(document).ready(function(){
    $('.table tbody').on('click','.clickEditCoupon',function(e){
        e.preventDefault();
        var id = this.id;
        $.ajax({    
            type: "POST",
            url: "Coupon/showCoupon.php", 
            data:{
                id : id
            },                           
            success: function(data){
                $('#couponForm').html(data); 
            }
        });
    });
});
//Cập nhật thông tin mã giảm giá
jQuery(document).ready(function(){
    $('.modal-body').on('click','.clickUpdateCoupon',function(e){
        e.preventDefault();
        var id = this.id;
        var coupon_code = $('#coupon_codeShow').val();
        var date_start = $('#date_startShow').val();
        var date_end = $('#date_endShow').val();
        var type_coupon = $('#type_couponShow').val();
        var scale = $('#scaleShow').val();
        $.ajax({    
            type: "POST",
            url: "Coupon/updateCoupon.php", 
            data:{
                id: id,
                coupon_code: coupon_code,
                date_start: date_start,
                date_end: date_end,
                type_coupon: type_coupon,
                scale: scale,
            },                           
            success: function(data){
                $('#table-coupon').load('Coupon/viewCoupons.php');
                $('#notificationEdit').prepend(
                    `
                    <div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert">
                        <strong>Sửa</strong> thông tin mã giảm giá thành công.
                        <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close"></button>
                    </div>
                    `
                )
                $("#success-alert").fadeTo(2000, 500).slideUp(500, function() {
                    $("#success-alert").slideUp(500);
                });
    
            }
        });
    });
});

// Lấy danh sách người dùng
$.ajax({
    url: "User/getUsers.php",
    type: "POST",
    cache: false,
    success: function(data){
        $('#table-users').html(data); 
    }
});
//Chuyển trang danh sách tài khoản người dùng
jQuery(document).ready(function(){
    $('body').on('click', '.pagination li a', function (e) {
        e.preventDefault();// Không load lại trang khi click phân trang.
        let url = $(this).attr('href');
        var id = this.id;
        $.ajax({
            url: "User/getUsers.php",
            method: 'GET',
            data:{
                id: id
            },
            success: function (data) {
                $('#table-users').html(data); 
                // Thay đổi URL trên website
                window.history.pushState({path:url},'',url);
            }
        });
    });
});
//Hiển thị thông tin người dùng
$('.table tbody').on('click','#btnViewUser',function(){
    var currow = $(this).closest('tr');
    var col0 = currow.find('.fullname').text();
    var col1 = currow.find('.email').text();
    var col2 = currow.find('.username').text();
    var col3 = currow.find('.create_date').text();
    var col4 = currow.find('.level').text();
    var result = 'Họ và tên: '+ col0 + '\nEmail: '+ col1 + '\nTên đăng nhập: ' + col2+ '\nNgày tạo: ' +col3 + '\nLoại tài khoản: ' + col4;
    alert(result);
})
//Thêm người dùng
jQuery(document).ready(function(){
    $('#btnAddUser').click(function(e){
        e.preventDefault();
        var fullname = $('#fullname').val();
        var email = $('#email').val();
        var username = $('#username').val();
        var password = $('#password').val();
        var level = $('#level').val();
        $.ajax({
            url:"User/addUser.php",
            type:"POST",
            data:
            {
                fullname: fullname,
                email:email,
                username:username,
                password: password,
                level: level
            },
            success:function(data){
                $('#table-users').load('User/getUsers.php');
                $('#notificationAdd').prepend(
                    `
                    <div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert">
                        <strong>Thêm</strong> loại sản phẩm thành công.
                        <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close"></button>
                    </div>
                    `
                )
                $("#success-alert").fadeTo(2000, 500).slideUp(500, function() {
                    $("#success-alert").slideUp(500);
                });
                $("#addForm")[0].reset();
            }
        })
    });
});
//Sửa người dùng
jQuery(document).ready(function(){
    $('.table tbody').on('click','.clickEditUser',function(e){
        e.preventDefault();
        var id = this.id;
        $.ajax({    
            type: "POST",
            url: "User/showUser.php", 
            data:{
                id : id
            },                           
            success: function(data){
                $('#userForm').html(data); 
            }
        });
    });
});
//Cập nhật thông tin tài khoản người dùng
jQuery(document).ready(function(){
    $('.modal-body').on('click','.clickUpdateUser',function(e){
        e.preventDefault();
        var id = this.id;
        var fullname = $('#fullnameShow').val();
        var email = $('#emailShow').val();
        var level = $('#levelShow').val();
        $.ajax({    
            type: "POST",
            url: "User/updateUser.php", 
            data:{
                id: id,
                fullname: fullname,
                email: email,
                level: level
            },                           
            success: function(data){
                $('#table-users').load('User/getUsers.php');
                $('#notificationEdit').prepend(
                    `
                    <div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert">
                        <strong>Sửa</strong> thông tin tài khoản thành công.
                        <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close"></button>
                    </div>
                    `
                )
                $("#success-alert").fadeTo(2000, 500).slideUp(500, function() {
                    $("#success-alert").slideUp(500);
                });
    
            }
        });
    });
});
//xóa tài khoản người dùng
jQuery(document).ready(function(){
    $('.table tbody').on('click','.clickDeleteUser',function(e){
        e.preventDefault();
        var id = this.id;
        $.ajax({    
            type: "POST",
            url: "User/deleteUser.php", 
            data:{
                id : id
            },                           
            success: function(data){   
                $('#table-users').load('User/getUsers.php');
            }
        });
    });
});

//Lấy danh sách loại sản phẩm
$.ajax({
    url: "Category/getCategories.php",
    type: "POST",
    cache: false,
    success: function(data){
        $('#table-categories').html(data); 
    }
});
//Chuyển trang danh sách loại sản phẩm
jQuery(document).ready(function(){
    $('body').on('click', '.pagination li a', function (e) {
        e.preventDefault();// Không load lại trang khi click phân trang.
        let url = $(this).attr('href');
        var id = this.id;
        $.ajax({
            url: "Category/getCategories.php",
            method: 'GET',
            data:{
                id: id
            },
            success: function (data) {
                $('#table-categories').html(data); 
                // Thay đổi URL trên website
                window.history.pushState({path:url},'',url);
            }
        });
    });
});
//Hiển thị thông tin loại sản phẩm
$('.table tbody').on('click','#btnViewCategory',function(){
    var currow = $(this).closest('tr');
    var col0 = currow.find('.name').text();
    var col1 = currow.find('.create_date').text();
    var result = 'Tên loại sản phẩm: '+ col0 + '\nNgày tạo: '+ col1;
    alert(result);
})
//Thêm loại sản phẩm
jQuery(document).ready(function(){
    $('#btn-addCategory').click(function(e){
        e.preventDefault();
        var name = $('#name').val();
        $.ajax({
            type:"POST",
            url:"Category/addCategory.php",
            data:
            {
                name: name
            },
            success:function(data){
                $('#table-categories').load('Category/getCategories.php');
                $('#notificationAdd').prepend(
                    `
                    <div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert">
                        <strong>Thêm</strong> loại sản phẩm thành công.
                        <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close"></button>
                    </div>
                    `
                )
                $("#success-alert").fadeTo(2000, 500).slideUp(500, function() {
                    $("#success-alert").slideUp(500);
                });
                $("#addForm")[0].reset();
            }
        })
    });
});
//xóa loại sản phẩm
jQuery(document).ready(function(){
    $('.table tbody').on('click','.clickDeleteCategory',function(e){
        e.preventDefault();
        var id = this.id;
        $.ajax({    
            type: "POST",
            url: "Category/deleteCategory.php", 
            data:{
                id : id
            },                           
            success: function(data){   
                $('#table-categories').load('Category/getCategories.php');
            }
        });
    });
});
//Sửa loại sản phẩm
jQuery(document).ready(function(){
    $('.table tbody').on('click','.clickEditCategory',function(e){
        e.preventDefault();
        var id = this.id;
        $.ajax({    
            type: "POST",
            url: "Category/showCategory.php", 
            data:{
                id : id
            },                           
            success: function(data){
                $('#categoriesForm').html(data); 
            }
        });
    });
});
//Cập nhật thông tin loại sản phẩm
jQuery(document).ready(function(){
    $('.modal-body').on('click','.clickUpdateCategory',function(e){
        e.preventDefault();
        var id = this.id;
        var name = $('#nameShow').val();
        $.ajax({    
            type: "POST",
            url: "Category/updateCategory.php", 
            data:{
                id: id,
                name: name,
            },                           
            success: function(data){
                $('#table-categories').load('Category/getCategories.php');
                $('#notificationEdit').prepend(
                    `
                    <div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert">
                        <strong>Sửa</strong> thông tin loại sản phẩm thành công.
                        <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close"></button>
                    </div>
                    `
                )
                $("#success-alert").fadeTo(2000, 500).slideUp(500, function() {
                    $("#success-alert").slideUp(500);
                });
    
            }
        });
    });
});