<?php

    require_once '../dbConfig.php';
    $id = $_POST['id'];
    $coupon_code = $_POST['coupon_code'];
    $date_start = $_POST['date_start'];
    $date_end = $_POST['date_end'];
    $type_coupon = $_POST['type_coupon'];
    $scale = $_POST['scale'];
	$coupon->updateProduct( $id,$coupon_code,$date_start,$date_end,$type_coupon, $scale);
?>
  