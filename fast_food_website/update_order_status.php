<?php
session_start();
include 'includes/db_connection.php';

// Kiểm tra xem người dùng đã đăng nhập với quyền admin chưa
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    http_response_code(403); // Trả về lỗi 403 nếu không có quyền
    exit();
}

// Nhận dữ liệu từ yêu cầu AJAX
$order_id = $_POST['order_id'];
$status = $_POST['status'];

// Cập nhật trạng thái đơn hàng
$sql_update = "UPDATE orders SET status = ? WHERE id = ?";
$stmt_update = $conn->prepare($sql_update);
$stmt_update->bind_param("si", $status, $order_id);
$stmt_update->execute();

if ($stmt_update->affected_rows > 0) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false]);
}
$stmt_update->close();
$conn->close();
