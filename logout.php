<?php
    require_once 'dbConfig.php';
    $user->logout();
    header("location:login.php");
?>