<?php
    require_once '../dbConfig.php';
    // Mặc định sẽ là trang 1.
    $current_page = isset($_GET['id']) ? $_GET['id'] : 1;
    $postTotal = $category->countCategory();// Lấy tổng số sản phẩm.
    $postOnePage = 5; // Số bài viết hiển thị trong 1 trang.
    $pageTotal = ceil($postTotal / $postOnePage);
    $limit = ($current_page - 1) * $postOnePage;
   
	$category->getCategories($current_page,$pageTotal,$limit,$postOnePage);
?>
  