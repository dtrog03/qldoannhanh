<?php 
session_start();
include 'includes/db_connection.php'; 

// Kiểm tra xem có thông tin POST không
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Truy vấn cơ sở dữ liệu để tìm người dùng
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? LIMIT 1");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    // Kiểm tra nếu có người dùng
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Kiểm tra mật khẩu
        if (password_verify($password, $user['password'])) {
            // Đăng nhập thành công, lưu thông tin người dùng vào session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header("Location: home.php"); // Chuyển hướng tới trang chính
            exit();
        } else {
            $error_message = "Mật khẩu không chính xác.";
        }
    } else {
        $error_message = "Tên tài khoản không tồn tại.";
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
    <title>Đăng Nhập</title>
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
    .img-fluid {
        border-radius: 10px; /* Bo tròn góc ảnh */
        height: 100%;
        width: 100%;
        object-fit: cover;
    }
    .btn-login {
        background-color: red !important; /* Nền đỏ */
        color: white !important; /* Chữ trắng */
    }
</style>


</head>
<body>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="row login-container">
                    <div class="col-md-5 d-none d-md-block">
                        <img src="images/login.jpg" alt="Login Image" class="img-fluid" style="height: 100%; width: 100%; object-fit: cover;">
                    </div>
                    
                    <div class="col-md-6 p-4">
                        <h3 class="text-center">Đăng Nhập</h3>
                        <?php if (!empty($error_message)) echo "<div class='alert alert-danger'>$error_message</div>"; ?>
                        <form method="POST" action="">
                            <div class="form-group">
                                <label for="username">Tên tài khoản:</label>
                                <input type="text" id="username" name="username" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="password">Mật khẩu:</label>
                                <input type="password" id="password" name="password" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <a href="forgot_password.php" class="text-decoration-none">Quên mật khẩu?</a>
                            </div>

                            <button type="submit" class="btn btn-login btn-block">Đăng Nhập</button>

                            <div class="text-center mt-3">
                                <p>Bạn chưa có tài khoản? <a href="register.php">Đăng ký</a></p>
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
