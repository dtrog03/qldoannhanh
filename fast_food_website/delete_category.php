<?php 
include 'includes/db_connection.php'; 

// Kiểm tra xem có ID loại sản phẩm không
if (!isset($_GET['id'])) {
    header("Location: list_categories.php");
    exit();
}

$category_id = (int)$_GET['id'];

// Xóa loại sản phẩm khỏi cơ sở dữ liệu
$stmt = $conn->prepare("DELETE FROM categories WHERE id = ?");
$stmt->bind_param("i", $category_id);
$stmt->execute();
$stmt->close();

// Chuyển hướng đến trang danh sách loại sản phẩm
header("Location: list_categories.php?message=Xóa loại sản phẩm thành công!");
exit();
?>
