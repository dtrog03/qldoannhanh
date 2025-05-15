<?php 
session_start();
include 'includes/db_connection.php'; 
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Đăng Ký</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .form-group {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }
        .form-group label {
            margin-left: 10px;
            min-width: 250px;
        }
        .rounded-image {
            max-width: 100%;
            height: auto;
            border-radius: 10px; /* Bo tròn góc ảnh */
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="row">
                        <div class="col-md-6 d-none d-md-block">
                            <img src="images/login.jpg" alt="Register Image" class="rounded-image" style="height: 100%; width: 100%; object-fit: cover;">
                        </div>
                        <div class="col-md-6 p-5">
                            <h3 class="card-title text-center mb-4">Đăng Ký</h3>

                            <!-- Hiển thị thông báo lỗi (nếu có) -->
                            <?php if (isset($_SESSION['error_message'])): ?>
                                <div class="alert alert-danger">
                                    <?php 
                                    echo $_SESSION['error_message']; 
                                    unset($_SESSION['error_message']);
                                    ?>
                                </div>
                            <?php endif; ?>

                            <!-- Hiển thị thông báo thành công (nếu có) -->
                            <?php if (isset($_SESSION['success_message'])): ?>
                                <div class="alert alert-success">
                                    <?php 
                                    echo $_SESSION['success_message']; 
                                    unset($_SESSION['success_message']);
                                    ?>
                                </div>
                            <?php endif; ?>

                            <form action="process_register.php" method="POST">
                                <div class="form-group">
                                    <label for="username">Tên Tài Khoản:</label>
                                    <input type="text" id="username" name="username" class="form-control" required>
                                </div>

                                <div class="form-group">
                                    <label for="email">Email:</label>
                                    <input type="email" id="email" name="email" class="form-control" required>
                                </div>

                                <div class="form-group">
                                    <label for="phone">Số Điện Thoại:</label>
                                    <input type="text" id="phone" name="phone" class="form-control" required>
                                </div>

                                <div class="form-group">
                                    <label for="address">Địa Chỉ:</label>
                                    <input type="text" id="address" name="address" class="form-control" required>
                                </div>

                                <div class="form-group">
                                    <label for="password">Mật Khẩu:</label>
                                    <input type="password" id="password" name="password" class="form-control" required>
                                </div>

                                <div class="form-group">
                                    <label for="confirm_password">Nhập lại Mật Khẩu:</label>
                                    <input type="password" id="confirm_password" name="confirm_password" class="form-control" required>
                                </div>

                                <!-- Checkbox đồng ý với chính sách -->
                                <div class="form-group">
                                    <input type="checkbox" id="agree" name="agree" required>
                                    <label for="agree">Tôi đã đọc và đồng ý với các <a href="chinh_sach.html">Chính Sách Hoạt Động</a> và <a href="chinh_sach_bao_mat.html">Chính Sách Bảo Mật Thông Tin</a> của NHÓM 5</label>
                                </div>

                                <button type="submit" class="btn btn-primary btn-block">Đăng Ký</button>

                                <div class="text-center mt-3">
                                    <a href="login.php">Bạn đã có tài khoản? Đăng nhập</a>
                                </div>
                            </form>
                        </div>
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
