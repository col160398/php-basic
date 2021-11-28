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
                    <a href="dashboard.php"><li class="sidebar-title active">Sản phẩm </li></a>
                    <a href="listCoupon.php"><li class="sidebar-title">Mã giảm giá</li></a>
                    <a href="listUsers.php"><li class="sidebar-title">Tài khoản người dùng</li></a>
                    <a href="listCategories.php"><li class="sidebar-title">Loại sản phẩm</li></a>
                </ul>
                </div>
            </div>
            <div class="col-md-9">
                <div class="row">
                    <div class="col-10">
                        <h4>Danh sách sản phẩm</h4>
                    </div>
                    <div class="col-2">
                        <button class="btn btn-success" data-toggle="modal" data-target="#add">
                            Thêm sản phẩm
                        </button>
                    </div>
                </div>
                <br>
                <div class="table-responsive">
                    <div class="row">
                        <div class="col-3">
                            <select class="form-select showProducts" id="showChange">
                                <option value="0" selected>Hiển thị mặc định</option>
                                <option value="1">Theo tên A - Z</option>
                                <option value="2">Theo giá Thấp - Cao</option>
                                <option value="3">Theo tình trạng</option>
                                <option value="4">Theo trạng thái</option>
                            </select>   
                        </div>
                        <div class="col-6">
                            <form id="dateForm" action="" method="GET">
                                <div class="input-group">
                                    <input type="date" id="dateFrom" class="form-control" required>
                                    <input type="date" aria-label="dateTo" id="dateTo" class="form-control" required>
                                    <input class="input-group-text btn-primary" id="filterDate" type="submit" value="Lọc">
                                </div>
                            </form>
                        </div>
                        <!-- <div class="col-2"></div> -->
                        <div class="col-3">
                                <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon1">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"></path>
                                    </svg>
                                </span>
                                <input type="text" class="form-control" placeholder="Nhập từ khóa tìm kiếm" id="btnKey">
                                </div>
                        </div>
                    </div>
                    
                    <table id="mytable" class="table table-bordred table-striped">
                        <thead>
                            <th><input type="checkbox" id="checkall" /></th>
                            <th>Tên sản phẩm</th>
                            <th>Loại sản phẩm</th>
                            <th>Giá cũ</th>
                            <th>Giá mới</th>
                            <th>Số lượng</th>
                            <th>Tình trạng</th>
                            <th>Xem</th>
                            <th>Sửa</th>
                            <th>Xóa</th>
                        </thead>
                        <tbody id="table">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="btn btn-danger" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                    <h4 class="modal-title custom_align" id="Heading">Sửa thông tin sản phẩm</h4>
                    </div>
                <div id="notificationEdit"></div>
                <div class="modal-body" id="productForm">
                    
                </div>
            </div>
            <!-- /.modal-content --> 
        </div>
      <!-- /.modal-dialog --> 
    </div>
    <div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="add" aria-hidden="true">
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
                            <label class="form-label">Tên sản phẩm</label>
                            <input type="text" id="product_name" placeholder="Tên sản phẩm" class="form-control">
                        </div>
                        <div class="mb-3">
                            <?php
                                $type = $product->typeProduct();
                             ?>
                            <label class="form-label">Loại sản phẩm</label>
                            
                            <select id="type_id" class="form-select">
                            <option selected>Lựa chọn</option>
                            <?php foreach ($type as $item){ ?>
                                <option value="<?php echo $item['ID'] ?>"><?php echo$item['name'] ?></option>
                            <?php } ?>
                            </select>
                            
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Giá cũ</label>
                            <input type="number" id="old_price" placeholder="Giá mới sản phẩm" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Giá mới</label>
                            <input type="number" id="new_price" placeholder="Giá cũ sản phẩm" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Số lượng</label>
                            <input type="number" id="quantity" placeholder="Số lượng sản phẩm" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tình trạng</label>
                            <select type="number" id="status" class="form-select" aria-label="Default select example">
                                <option selected>Lựa chọn</option>
                                <option value="0">Mặc định</option>
                                <option value="1">New</option>
                                <option value="2">Hot</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Trạng thái</label>
                            <select type="number"  id="show" class="form-select" aria-label="Default select example">
                                <option selected>Lựa chọn</option>
                                <option value="0">Hiện</option>
                                <option value="1">Ẩn</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer ">
                        <button type="button" name="btn-add" id="btn-add" class="btn btn-warning btn-lg" style="width: 100%;"><span class="glyphicon glyphicon-ok-sign"></span>Thêm</button>
                    </div>
                </div>
            <!-- /.modal-content --> 
            </form>
        </div>
      <!-- /.modal-dialog --> 
    </div>
    <div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                <button type="button" class="close btn btn-warning" data-dismiss="modal" aria-hidden="true">x</button>
                <h4 class="modal-title custom_align" id="Heading">Xóa sản phẩm</h4>
            </div>
                <div class="modal-body">
            
            <div class="alert alert-danger"><span class="glyphicon glyphicon-warning-sign"></span> Bạn có chắc muốn xóa sản phẩm này chứ?</div>
            
            </div>
                <div class="modal-footer ">
                <button type="button" class="btn btn-success" id="deleteProduct" >Đồng ý</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Suy nghĩ lại</button>
            </div>
        </div>
        <!-- /.modal-content --> 
        </div>
      <!-- /.modal-dialog --> 
    </div>
    
    <script src="actionAjax.js"></script>
    </body>
    
</html>