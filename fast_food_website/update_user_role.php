<?php 
session_start(); 
include 'includes/db_connection.php'; 

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    echo "<script>alert('Bạn cần đăng nhập với quyền admin để thực hiện hành động này.'); window.location.href='login.php';</script>";
    exit();
}

// Nhận dữ liệu từ form
$user_id = $_POST['user_id'];
$new_role = $_POST['role'];

// Cập nhật quyền truy cập trong cơ sở dữ liệu
$sql_update = "UPDATE users SET role = ? WHERE id = ?";
$stmt = $conn->prepare($sql_update);
$stmt->bind_param("si", $new_role, $user_id);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo "<script>alert('Cập nhật quyền truy cập thành công!'); window.location.href='admin_users.php';</script>";
} else {
    echo "<script>alert('Lỗi cập nhật quyền truy cập.'); window.location.href='admin_users.php';</script>";
}

$stmt->close();
$conn->close();
?>
