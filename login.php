<?php
require_once 'dbConfig.php';

if(isset($_POST['submitLogin']))
{
    $username = $_POST['username'];
    $password = $_POST['password'];
    if($user->login($username,$password)) 
    {
        $user->redirect('dashboard.php');
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Đăng nhập</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"> 
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
</head>
    <body>
        <div class="account-login section">
            <div class="container"> 
                <div class="row">
                    <div class="col-lg-6 offset-lg-3 col-md-10 offset-md-1 col-12">
                        <form class="card login-form" method="post">
                            <div class="card-body">
                            <div class="title">
                                <h3>Form Đăng Nhập </h3>
                                <div class="form-group input-group">
                                    <label for="reg-fn">Tên đăng nhập</label>
                                    <input class="form-control" type="text" name="username" value="" require>
                                </div>
                                <div class="form-group input-group">
                                    <label for="reg-fn">Mật khẩu</label>
                                    <input class="form-control" type="password" name="password" value="" require>
                                </div>
                                <div class="button">
                                <button type="submit" name="submitLogin" class="btn btn-primary">Login</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
