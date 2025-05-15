<?php 
session_start(); 
include 'includes/db_connection.php'; 

// Kiểm tra xem người dùng đã đăng nhập với quyền admin chưa
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    echo "<script>alert('Bạn cần đăng nhập với quyền admin để quản lý đơn hàng.'); window.location.href='login.php';</script>";
    exit();
}

// Lấy danh sách đơn hàng từ cơ sở dữ liệu
$sql_orders = "SELECT * FROM orders";
$result_orders = $conn->query($sql_orders);

// Kiểm tra nếu có lỗi trong truy vấn
if (!$result_orders) {
    die("Lỗi truy vấn: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Quản Lý Đơn Hàng</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-4">
    <h2 class="text-center">Quản Lý Đơn Hàng</h2>

    <div class="order-list-container">
        <?php if ($result_orders->num_rows === 0): ?>
            <p class="text-center">Không có đơn hàng nào.</p>
        <?php else: ?>
            <table class="table table-bordered table-responsive">
                <thead class="bg-danger text-white">
                    <tr>
                        <th>ID</th>
                        <th>Họ tên</th>
                        <th>Địa chỉ</th>
                        <th>Số điện thoại</th>
                        <th>Tổng cộng</th>
                        <th>Ngày đặt</th>
                        <th>Trạng thái</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($order = $result_orders->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $order['id']; ?></td>
                            <td><?php echo htmlspecialchars($order['fullname']); ?></td>
                            <td><?php echo htmlspecialchars($order['address']); ?></td>
                            <td><?php echo htmlspecialchars($order['phone']); ?></td>
                            <td><?php echo number_format($order['total']) . ' VNĐ'; ?></td>
                            <td><?php echo date('d/m/Y H:i:s', strtotime($order['order_date'])); ?></td>
                            <td><?php echo htmlspecialchars($order['status']); ?></td>
                            <td>
                                <a href="view_order_details.php?id=<?php echo $order['id']; ?>" class="btn btn-info btn-sm">Xem</a>
                                <form action="update_order_status.php" method="POST" style="display:inline;" class="update-status-form">
                                    <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
                                    <select name="status" class="form-control form-control-sm d-inline-block" required style="width: auto;">
                                        <option value="pending" <?php echo $order['status'] === 'pending' ? 'selected' : ''; ?>>Chưa hoàn thành</option>
                                        <option value="completed" <?php echo $order['status'] === 'completed' ? 'selected' : ''; ?>>Hoàn thành</option>
                                        <option value="canceled" <?php echo $order['status'] === 'canceled' ? 'selected' : ''; ?>>Đã hủy</option>
                                    </select>
                                    <button type="submit" class="btn btn-warning btn-sm">Cập nhật</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    // AJAX để cập nhật trạng thái đơn hàng mà không cần tải lại trang
    $(document).ready(function() {
        $('.update-status-form').on('submit', function(e) {
            e.preventDefault();
            var form = $(this);

            $.ajax({
                type: 'POST',
                url: 'update_order_status.php',
                data: form.serialize(),
                success: function(response) {
                    alert('Cập nhật trạng thái thành công!');
                },
                error: function() {
                    alert('Đã xảy ra lỗi khi cập nhật trạng thái.');
                }
            });
        });
    });
</script>

<?php include 'includes/footer.php'; ?>
</body>
</html>
