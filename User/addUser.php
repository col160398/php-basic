<?php
    require_once '../dbConfig.php';

    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $level = $_POST['level'];

    $user->register($fullname,$email,$username,$password,$level);
?>
  