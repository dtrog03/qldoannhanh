<?php
session_start(); // Khởi động phiên làm việc

// Xóa tất cả các biến session
$_SESSION = [];

// Hủy session
session_destroy();

// Chuyển hướng đến trang đăng nhập
header("Location: login.php");
exit(); // Ngăn không cho thực thi mã tiếp theo
?>
