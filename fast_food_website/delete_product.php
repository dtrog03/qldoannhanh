<?php 
include 'includes/db_connection.php'; 

// Kiểm tra xem có ID sản phẩm không
if (!isset($_GET['id'])) {
    header("Location: list_products.php");
    exit();
}

$product_id = (int)$_GET['id'];

// Xóa sản phẩm khỏi cơ sở dữ liệu
$stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
$stmt->bind_param("i", $product_id);
$stmt->execute();
$stmt->close();

// Chuyển hướng đến trang danh sách sản phẩm với thông báo thành công
header("Location: list_products.php?message=Xóa sản phẩm thành công!");
exit();
?>
