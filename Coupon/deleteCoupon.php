<?php
    require_once '../dbConfig.php';
    $id= $_POST['id'];
    $coupon->deleteCoupon($id);
?>