<?php 
session_start();
include 'includes/db_connection.php'; 

// Kiểm tra xem có thông tin POST không
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Kiểm tra sự tồn tại của email trong cơ sở dữ liệu
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? LIMIT 1");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Nếu email tồn tại, cập nhật mật khẩu
    if ($result->num_rows > 0) {
        if ($new_password === $confirm_password) {
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $update_stmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
            $update_stmt->bind_param("ss", $hashed_password, $email);
            if ($update_stmt->execute()) {
                header("Location: login.php"); // Chuyển hướng đến trang đăng nhập
                exit();
            } else {
                $error_message = "Có lỗi trong việc cập nhật mật khẩu.";
            }
        } else {
            $error_message = "Mật khẩu mới và mật khẩu xác nhận không khớp.";
        }
    } else {
        $error_message = "Email không tồn tại trong hệ thống.";
    }
}

// Đảm bảo không có nội dung nào được xuất ra trước đây
ob_start();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Quên Mật Khẩu</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
        .login-container {
            margin-top: 50px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            border: 1px solid #dee2e6; /* Đường viền của khung */
            background-color: white;
        }
        .btn-login {
            background-color: red !important; /* Nền đỏ */
            color: white !important; /* Chữ trắng */
        }
        .img-fluid {
            border-radius: 10px; /* Bo tròn góc ảnh */
            height: 100%;
            width: 100%;
            object-fit: cover;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="row login-container">
                    <div class="col-md-5 d-none d-md-block">
                        <img src="images/login.jpg" alt="Forgot Password Image" class="img-fluid">
                    </div>
                    
                    <div class="col-md-7 p-4">
                        <h3 class="text-center">Quên Mật Khẩu</h3>
                        <?php if (!empty($error_message)) echo "<div class='alert alert-danger'>$error_message</div>"; ?>
                        <form method="POST" action="">
                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input type="email" id="email" name="email" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="new_password">Mật khẩu mới:</label>
                                <input type="password" id="new_password" name="new_password" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="confirm_password">Nhập lại mật khẩu mới:</label>
                                <input type="password" id="confirm_password" name="confirm_password" class="form-control" required>
                            </div>

                            <button type="submit" class="btn btn-login btn-block">Cập nhật</button>

                            <div class="text-center mt-3">
                                <p><a href="login.php">Quay lại trang đăng nhập</a></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <?php 
    ob_end_flush(); // Kết thúc việc ghi đệm đầu ra
    ?>
</body>
</html>
