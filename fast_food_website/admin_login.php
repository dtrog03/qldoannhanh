<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Đăng Nhập Admin</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <style>
        .login-container {
            margin-top: 50px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            border: 1px solid #dee2e6;
            background-color: white;
        }
        .btn-login {
            background-color: red !important;
            color: white !important;
        }
        .img-fluid {
            border-radius: 10px; /* Bo góc ảnh */
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="row login-container">
                    <!-- Phần ảnh bên trái -->
                    <div class="col-md-5 d-none d-md-block">
                        <img src="images/login.jpg" alt="Login Image" class="img-fluid" style="height: 100%; width: 100%; object-fit: cover;">
                    </div>
                    
                    <!-- Phần form bên phải -->
                    <div class="col-md-6 p-4">
                        <h3 class="text-center">Đăng Nhập Admin</h3>
                        <?php 
                        session_start();
                        $error_message = isset($_SESSION['error_message']) ? $_SESSION['error_message'] : '';
                        unset($_SESSION['error_message']); // Xóa thông báo lỗi sau khi đã hiển thị
                        if (!empty($error_message)) echo "<div class='alert alert-danger'>$error_message</div>"; 
                        ?>
                        <form method="POST" action="process_admin_login.php">
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
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
