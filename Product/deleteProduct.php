<?php
    require_once '../dbConfig.php';
    $id= $_POST['id'];
    $product->deleteProduct($id);
?>