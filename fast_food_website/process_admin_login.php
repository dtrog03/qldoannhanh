<?php
session_start();
include 'includes/db_connection.php'; // Kết nối cơ sở dữ liệu

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Lấy thông tin từ form
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Truy vấn để kiểm tra tài khoản admin
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    // Kiểm tra xem có tài khoản nào không
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Kiểm tra mật khẩu
        if (password_verify($password, $user['password'])) {
            // Kiểm tra role của user
            if ($user['role'] === 'admin') {
                // Lưu thông tin người dùng vào session
                $_SESSION['username'] = $username;
                $_SESSION['role'] = 'admin';
                header("Location: admin_dashboard.php"); // Chuyển hướng đến trang dashboard
                exit();
            } else {
                // Nếu không phải là admin
                $_SESSION['error_message'] = "Chỉ có tài khoản admin mới có thể đăng nhập.";
                header("Location: admin_login.php");
                exit();
            }
        } else {
            // Nếu mật khẩu không đúng
            $_SESSION['error_message'] = "Mật khẩu không đúng!";
            header("Location: admin_login.php");
            exit();
        }
    } else {
        // Nếu không tìm thấy tài khoản
        $_SESSION['error_message'] = "Tài khoản không tồn tại!";
        header("Location: admin_login.php");
        exit();
    }
}
?>
