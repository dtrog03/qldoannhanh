<?php
session_start();
include 'includes/db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Kiểm tra xem checkbox đã được đánh dấu chưa
    if (!isset($_POST['agree'])) {
        $_SESSION['error_message'] = "Bạn cần đồng ý với các chính sách để tiếp tục.";
        header("Location: register.php");
        exit();
    }

    // Lấy thông tin từ form
    $username = $_POST['username'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Kiểm tra xem mật khẩu và xác nhận mật khẩu có khớp nhau không
    if ($password !== $confirm_password) {
        $_SESSION['error_message'] = "Mật khẩu không khớp!";
        header("Location: register.php");
        exit();
    }

    // Mã hóa mật khẩu
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Kiểm tra xem tên tài khoản đã tồn tại chưa
    $sql_check = "SELECT * FROM users WHERE username = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("s", $username);
    $stmt_check->execute();
    $result = $stmt_check->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['error_message'] = "Tên tài khoản đã tồn tại, vui lòng chọn tên khác.";
        header("Location: register.php");
        exit();
    }

    // Lưu thông tin người dùng vào cơ sở dữ liệu, mặc định phân quyền là user
    $sql = "INSERT INTO users (username, password, email, phone, address, created_at) VALUES (?, ?, ?, ?, ?, NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $username, $hashed_password, $email, $phone, $address);

    // Thực hiện câu lệnh và kiểm tra lỗi
    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Đăng ký thành công!";
        header("Location: login.php");
        exit();
    } else {
        // Ghi lỗi nếu có
        echo "Lỗi: " . $stmt->error; // Xem lỗi
        $_SESSION['error_message'] = "Có lỗi xảy ra, vui lòng thử lại!";
        header("Location: register.php");
        exit();
    }
}
?>
