<?php 
session_start(); 
include 'includes/db_connection.php'; 

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Bạn cần đăng nhập để xem chi tiết đơn hàng.'); window.location.href='login.php';</script>";
    exit();
}

$order_id = $_GET['id'];

// Lấy thông tin đơn hàng
$sql_order = "SELECT * FROM orders WHERE id = ?";
$stmt_order = $conn->prepare($sql_order);
$stmt_order->bind_param("i", $order_id);
$stmt_order->execute();
$result_order = $stmt_order->get_result();
$order = $result_order->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi Tiết Đơn Hàng</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <h2 class="text-center">Chi Tiết Đơn Hàng #<?php echo $order['id']; ?></h2>
        <div class="card mt-3">
            <div class="card-body">
                <p><strong>Họ tên:</strong> <?php echo htmlspecialchars($order['fullname']); ?></p>
                <p><strong>Địa chỉ:</strong> <?php echo htmlspecialchars($order['address']); ?></p>
                <p><strong>Số điện thoại:</strong> <?php echo htmlspecialchars($order['phone']); ?></p>
                <p><strong>Tổng cộng:</strong> <?php echo number_format($order['total']) . ' VNĐ'; ?></p>
                <p><strong>Ngày đặt:</strong> <?php echo date('d/m/Y H:i:s', strtotime($order['order_date'])); ?></p>
                <p><strong>Trạng thái:</strong> <?php echo htmlspecialchars($order['status']); ?></p>
            </div>
        </div>
        <div class="text-center mt-3">
            <a href="admin_orders.php" class="btn btn-primary">Quay lại danh sách đơn hàng</a>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    
    <?php include 'includes/footer.php'; ?>
</body>
</html>
