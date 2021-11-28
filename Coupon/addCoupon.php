<?php
    require_once '../dbConfig.php';
    $coupon_code = $_POST['coupon_code'];
    $date_start = $_POST['date_start'];
    $date_end = $_POST['date_end'];
    $type_coupon = $_POST['type_coupon'];
    $scale = $_POST['scale'];
    $coupon->addCoupon($coupon_code,$date_start,$date_end,$type_coupon, $scale);
?>
  