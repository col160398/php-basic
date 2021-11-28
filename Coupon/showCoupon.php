<?php

require_once '../dbConfig.php';

$id = $_POST['id'];

$coupon->showCoupon($id);

?>