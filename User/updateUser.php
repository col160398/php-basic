<?php
    require_once '../dbConfig.php';

    $id = $_POST['id'];
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    // $username = $_POST['username'];
    $level = $_POST['level'];

	$user->updateUser($id,$fullname,$email,$level);
?>
  