<?php
    require_once '../dbConfig.php';
    // Mặc định sẽ là trang 1.
    $current_page = isset($_GET['id']) ? $_GET['id'] : 1;
    $postTotal = $product->countProduct();// Lấy tổng số sản phẩm.
    $postOnePage = 5; // Số bài viết hiển thị trong 1 trang.
    $pageTotal = ceil($postTotal / $postOnePage);
    $limit = ($current_page - 1) * $postOnePage;
    $showValue = isset($_POST['value']) ? $_POST['value'] : 0;
    $dateFrom = isset($_POST['dateFrom'])? $_POST['dateFrom'] : null;
    $dateTo = isset($_POST['dateTo'])? $_POST['dateTo'] : null;
	$product->ajaxViewProducts($limit,$postOnePage,$current_page,$pageTotal,$showValue,$dateFrom,$dateTo);
?>
  