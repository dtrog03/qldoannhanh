<?php 
session_start(); 
include 'includes/db_connection.php'; 
include 'includes/header.php'; 

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Bạn cần đăng nhập để xem đơn hàng.'); window.location.href='login.php';</script>";
    exit();
}

$user_id = $_SESSION['user_id'];

// Lấy danh sách đơn hàng của người dùng
$sql_orders = "SELECT * FROM orders WHERE user_id = ?";
$stmt_orders = $conn->prepare($sql_orders);
$stmt_orders->bind_param("i", $user_id);
$stmt_orders->execute();
$result_orders = $stmt_orders->get_result();
?>

<div class="container mt-4">
    <h2 class="text-center">Danh Sách Đơn Hàng</h2>

    <div class="order-list-container">
        <?php if ($result_orders->num_rows === 0): ?>
            <p class="text-center">Không có đơn hàng nào.</p>
        <?php else: ?>
            <table class="table table-bordered table-responsive">
                <thead class="bg-danger text-white">
                    <tr>
                        <th>Họ tên</th>
                        <th>Địa chỉ</th>
                        <th>Số điện thoại</th>
                        <th>Tổng cộng</th>
                        <th>Ngày đặt</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($order = $result_orders->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($order['fullname']); ?></td>
                            <td><?php echo htmlspecialchars($order['address']); ?></td>
                            <td><?php echo htmlspecialchars($order['phone']); ?></td>
                            <td><?php echo number_format($order['total']) . ' VNĐ'; ?></td>
                            <td><?php echo date('d/m/Y H:i:s', strtotime($order['order_date'])); ?></td>
                            <td>
                                <form action="cancel_order.php" method="POST" style="display:inline;">
                                    <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
                                    <button type="submit" class="btn btn-danger btn-sm">Hủy đơn</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>

<script>
    // Cuộn đến phần nội dung sau khi tải trang
 window.onload = function() {
            window.scrollTo(0, document.querySelector('.container').offsetTop);
        }
</script>

<?php include 'includes/footer.php'; ?>
