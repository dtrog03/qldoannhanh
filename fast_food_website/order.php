<?php 
session_start(); 
include 'includes/db_connection.php'; 
include 'includes/header.php'; 

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Bạn cần đăng nhập để đặt hàng.'); window.location.href='login.php';</script>";
    exit();
}

$user_id = $_SESSION['user_id'];

// Lấy thông tin giỏ hàng
$sql_cart = "SELECT c.quantity, p.id, p.name, p.price 
             FROM cart c 
             JOIN products p ON c.product_id = p.id 
             WHERE c.user_id = ?";
$stmt_cart = $conn->prepare($sql_cart);
$stmt_cart->bind_param("i", $user_id);
$stmt_cart->execute();
$result_cart = $stmt_cart->get_result();
?>

<div class="container mt-4">
    <h2 class="text-center">Thông tin đơn hàng</h2>

    <?php if ($result_cart->num_rows === 0): ?>
        <p class="text-center">Không có sản phẩm trong giỏ hàng.</p>
    <?php else: ?>
        <table class="table table-bordered table-responsive">
            <thead class="bg-danger text-white">
                <tr>
                    <th>Sản phẩm</th>
                    <th>Số lượng</th>
                    <th>Giá</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $total = 0;
                while ($order_item = $result_cart->fetch_assoc()): 
                    $item_total = $order_item['price'] * $order_item['quantity'];
                    $total += $item_total;
                ?>
                <tr>
                    <td><?php echo htmlspecialchars($order_item['name']); ?></td>
                    <td><?php echo $order_item['quantity']; ?></td>
                    <td><?php echo number_format($item_total) . ' VNĐ'; ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2" class="text-right"><strong>Tổng cộng:</strong></td>
                    <td><?php echo number_format($total) . ' VNĐ'; ?></td>
                </tr>
            </tfoot>
        </table>
        
        <!-- Nút Xác nhận đặt hàng -->
        <div class="text-center mt-4">
            <form action="confirm_order.php" method="POST">
                <input type="hidden" name="total" value="<?php echo $total; ?>">
                <button type="submit" class="btn btn-danger text-white" style="width: 200px;">Xác nhận đặt hàng</button>
            </form>
        </div>
    <?php endif; ?>
</div>

<script>
    // Cuộn đến phần nội dung sau khi tải trang
 window.onload = function() {
            window.scrollTo(0, document.querySelector('.container').offsetTop);
        }
</script>

<?php include 'includes/footer.php'; ?>
