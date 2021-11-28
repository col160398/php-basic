<?php 

require_once '../dbConfig.php';

$product_name = $_POST['product_name'];
$type_id = $_POST['type_id'];
$old_price = $_POST['old_price'];
$new_price = $_POST['new_price'];
$quantity = $_POST['quantity'];
$status = $_POST['status'];
$show = $_POST['show'];
$product->addProduct($product_name,$type_id,$old_price,$new_price, $quantity,$status,$show);
?>