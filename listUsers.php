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
        <title>Management</title>
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
                        <a href="listCoupon.php"><li class="sidebar-title">Mã giảm giá</li></a>
                        <a href="listUsers.php"><li class="sidebar-title active">Tài khoản người dùng</li></a>
                        <a href="listCategories.php"><li class="sidebar-title">Loại sản phẩm</li></a>
                    </ul>
                </div>
            </div>
            <div class="col-md-9">
            <div class="row">
                    <div class="col-10">
                        <h4>Danh sách tài khoản người dùng</h4>
                    </div>
                    <div class="col-2">
                        <button class="btn btn-success" data-toggle="modal" data-target="#addUser">
                            Thêm User
                        </button>
                    </div>
                </div>
                <div class="table-responsive">
                    <table id="mytable" class="table table-bordred table-striped">
                        <thead>
                            <th>Họ tên</th>
                            <th>Email</th>
                            <th>Tên đăng nhập</th>
                            <th>Ngày tạo</th>
                            <th>Loại tài khoản</th>
                            <th>Xem</th>
                            <th>Sửa</th>
                            <th>Xóa</th>
                        </thead>
                        <tbody id="table-users">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- The Modal -->
    <!-- Modal -->
    <div class="modal fade" id="addUser" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Thêm người dùng</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" id="addForm">
                <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Họ và tên</label>
                            <input type="text" class="form-control" id="fullname" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tên đăng nhập</label>
                            <input type="text" class="form-control" id="username" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Mật khẩu</label>
                            <input type="password" class="form-control" id="password" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Loại tài khoản</label>
                            <select id="level" class="form-select">
                                <option selected>Lựa chọn</option>
                                <option value="1">Thành viên</option>
                                <option value="2">Admin</option>
                            </select>
                        </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Thoát</button>
                    <button type="button" id="btnAddUser" class="btn btn-success">Thêm</button>
                </div>
            </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="editUser" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="btn btn-danger" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                    <h4 class="modal-title custom_align" id="Heading">Sửa thông tin mã giảm giá</h4>
                    </div>
                <div id="notificationEdit"></div>
                <div class="modal-body" id="userForm">
                    
                </div>
            </div>
            <!-- /.modal-content --> 
        </div>
      <!-- /.modal-dialog --> 
    </div>
    <script src="actionAjax.js"></script>
    </body>
    
</html>