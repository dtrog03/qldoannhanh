<?php 
session_start(); 
include 'includes/db_connection.php'; 

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Bạn cần đăng nhập để hủy đơn hàng.'); window.location.href='login.php';</script>";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_id'])) {
    $order_id = $_POST['order_id'];

    // Xóa đơn hàng khỏi bảng orders
    $stmt = $conn->prepare("DELETE FROM orders WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $order_id, $_SESSION['user_id']);
    if ($stmt->execute()) {
        echo "<script>alert('Đơn hàng đã được hủy thành công.'); window.location.href='orders.php';</script>";
    } else {
        echo "<script>alert('Có lỗi xảy ra. Vui lòng thử lại.'); window.location.href='orders.php';</script>";
    }
} else {
    header("Location: orders.php");
    exit();
}
?>
