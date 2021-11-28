<?php
require_once 'dbConfig.php';

if(!$user->is_loggedin())
{
 $user->redirect('login.php');
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Trang quản lý Admin</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="style.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    </head>
    <body>
    <div class="container">
        <?php
            include 'layoutTop.php';
        ?>
        <div class="row">
            <div class="col-3" style="background-color: #e9ecef; border-radius: .25rem;" >
                <div class="sidebar-wrapper">
                <ul class="menu">
                    <h4>Danh mục quản lý</h4>
                    <a href="dashboard.php"><li class="sidebar-title">Sản phẩm </li></a>
                    <a href="listCoupon.php"><li class="sidebar-title active">Mã giảm giá</li></a>
                    <a href="listUsers.php"><li class="sidebar-title">Tài khoản người dùng</li></a>
                    <a href="listCategories.php"><li class="sidebar-title">Loại sản phẩm</li></a>
                </ul>
                </div>
            </div>
            <div class="col-md-9">
            <div class="row">
                    <div class="col-10">
                        <h4>Danh sách mã giảm giá</h4>
                    </div>
                    <div class="col-2">
                        <button class="btn btn-success" data-toggle="modal" data-target="#addCoupon">
                            Thêm mã giảm
                        </button>
                    </div>
                </div>
                <div class="table-responsive">
                    <table id="mytable" class="table table-bordred table-striped">
                        <thead>
                            <th>Mã giảm giá</th>
                            <th>Loại giảm giá</th>
                            <th>Ngày bắt đầu</th>
                            <th>Ngày kết thúc</th>
                            <th>Mức giảm</th>
                            <th>Xem</th>
                            <th>Sửa</th>
                            <th>Xóa</th>
                        </thead>
                        <tbody id="table-coupon">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="editCoupon" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="btn btn-danger" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                    <h4 class="modal-title custom_align" id="Heading">Sửa thông tin mã giảm giá</h4>
                    </div>
                <div id="notificationEdit"></div>
                <div class="modal-body" id="couponForm">
                    
                </div>
            </div>
            <!-- /.modal-content --> 
        </div>
      <!-- /.modal-dialog --> 
    </div>
    <div class="modal fade" id="addCoupon" tabindex="-1" role="dialog" aria-labelledby="add" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" id="addForm">
                <div class="modal-content">
                    <div class="modal-header">
                    <button class="btn btn-danger" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                        <h4 class="modal-title custom_align" id="Heading">Thêm sản phẩm</h4>
                    </div>
                    <div id="notificationAdd"></div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Mã giảm giá</label>
                            <input type="text" id="coupon_code" placeholder="Nhập mã code" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Ngày bắt đầu</label>
                            <input type="date" id="date_start" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Ngày kết thúc</label>
                            <input type="date" id="date_end" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Loại giảm giá</label>
                            <select type="number" id="type_coupon" class="form-select">
                                <option selected>Lựa chọn</option>
                                <option value="0">Giảm theo %</option>
                                <option value="1">Giảm tiền</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Mức giảm</label>
                            <input type="number" id="scale" placeholder="Số lượng sản phẩm" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer ">
                        <button type="button" name="btn-addCoupon" id="btn-addCoupon" class="btn btn-warning btn-lg" style="width: 100%;"><span class="glyphicon glyphicon-ok-sign"></span>Thêm</button>
                    </div>
                </div>
            <!-- /.modal-content --> 
            </form>
        </div>
      <!-- /.modal-dialog --> 
    </div>
    <script src="actionAjax.js"></script>
    </body>
    
</html>