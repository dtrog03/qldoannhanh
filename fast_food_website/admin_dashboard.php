<?php
session_start();
include 'includes/db_connection.php';

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: admin_login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa; /* Nền sáng cho toàn trang */
        }
        .content {
            padding: 20px;
            background-color: white;
            border-radius: 8px; /* Bo góc cho nội dung */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Đổ bóng cho nội dung */
        }
        .welcome-image {
            max-width: 100%; /* Đảm bảo ảnh không vượt quá chiều rộng của container */
            border-radius: 8px; /* Bo góc cho ảnh */
        }
    </style>
</head>
<body>

<header>
    <?php include 'includes/admin_top_menu.php'; ?>
</header>

<div class="container mt-4">
    <div class="content">
        <h1 class="text-center">Xin Chào Quản Trị Viên</h1>
        <p class="text-center">Tại đây bạn có thể quản lý tất cả các chức năng của hệ thống.</p>
        <div class="text-center">
            <img src="images/admin.jpg" alt="Chào mừng" class="welcome-image" />
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
