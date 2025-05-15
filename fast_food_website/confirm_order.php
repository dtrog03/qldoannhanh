<?php 
session_start(); 
include 'includes/db_connection.php'; 

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Bạn cần đăng nhập để đặt hàng.'); window.location.href='login.php';</script>";
    exit();
}

// Kiểm tra nếu có dữ liệu từ giỏ hàng (total) được gửi đến
if (!isset($_POST['total'])) {
    header("Location: order.php"); // Nếu không có tổng, chuyển hướng về trang đặt hàng
    exit();
}

// Khởi tạo biến để lưu thông báo lỗi
$error_message = "";

// Nếu là yêu cầu POST, xử lý dữ liệu đơn hàng
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Kiểm tra và lấy dữ liệu từ form
    $fullname = isset($_POST['fullname']) ? $_POST['fullname'] : '';
    $address = isset($_POST['address']) ? $_POST['address'] : '';
    $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
    $total = $_POST['total'];
    $user_id = $_SESSION['user_id'];

    // Kiểm tra các trường bắt buộc
    if (empty($fullname) || empty($address) || empty($phone)) {
        $error_message = "Vui lòng điền đầy đủ thông tin.";
    } else {
        // Chèn dữ liệu vào bảng orders
        $stmt = $conn->prepare("INSERT INTO orders (user_id, fullname, address, phone, total, order_date, status) VALUES (?, ?, ?, ?, ?, NOW(), 'Pending')");
        $stmt->bind_param("issss", $user_id, $fullname, $address, $phone, $total);

        // Thực hiện truy vấn và kiểm tra kết quả
        if ($stmt->execute()) {
            // Xóa sản phẩm đã đặt trong bảng cart
            $stmt_delete_cart = $conn->prepare("DELETE FROM cart WHERE user_id = ?");
            $stmt_delete_cart->bind_param("i", $user_id);
            $stmt_delete_cart->execute();

            // Chuyển hướng đến trang thank_you.php sau khi xác nhận đơn hàng
            echo "<script>alert('Đơn hàng của bạn đã được xác nhận!'); window.location.href='thank_you.php';</script>";
            exit();
        } else {
            $error_message = "Có lỗi xảy ra. Vui lòng thử lại.";
        }
    }
}

// Đảm bảo không có nội dung nào được xuất ra trước đây
ob_start();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xác Nhận Đơn Hàng</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">

    <style>
        .order-confirm-container {
            margin: 50px auto; /* Tạo khoảng cách trên và dưới */
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
        .btn-confirm {
            background-color: red !important; /* Nền đỏ */
            color: white !important; /* Chữ trắng */
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="row order-confirm-container">
                    <div class="col-md-5 d-none d-md-block">
                        <img src="images/order.jpg" alt="Confirm Order" class="img-fluid">
                    </div>
                    
                    <div class="col-md-7 p-4">
                        <h3 class="text-center">Xác Nhận Đơn Hàng</h3>
                        <?php if (!empty($error_message)) echo "<div class='alert alert-danger'>$error_message</div>"; ?>
                        <form method="POST" action="">
                            <div class="form-group">
                                <label for="fullname">Họ tên:</label>
                                <input type="text" id="fullname" name="fullname" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="address">Địa chỉ:</label>
                                <input type="text" id="address" name="address" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="phone">Số điện thoại:</label>
                                <input type="text" id="phone" name="phone" class="form-control" required>
                            </div>

                            <input type="hidden" name="total" value="<?php echo htmlspecialchars($_POST['total']); ?>">

                            <button type="submit" class="btn btn-confirm btn-block">Xác Nhận Đơn Hàng</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>
    
    <script src="https://code.jquery.com/jquery-3.5.2.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <?php 
    ob_end_flush(); // Kết thúc việc ghi đệm đầu ra
    ?>
</body>
</html>
