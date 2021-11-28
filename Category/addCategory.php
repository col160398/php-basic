<?php
    require_once '../dbConfig.php';
    $name = $_POST['name'];
    $category->addCategory($name);
?>
  