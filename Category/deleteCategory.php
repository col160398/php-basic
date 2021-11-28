<?php
    require_once '../dbConfig.php';
    $id = $_POST['id'];
    $category->deleteCategory($id);
?>
  