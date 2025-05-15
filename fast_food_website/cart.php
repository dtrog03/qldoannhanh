<?php 
session_start(); 
include 'includes/db_connection.php'; 
include 'includes/header.php'; 

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Bạn cần đăng nhập để xem giỏ hàng.'); window.location.href='login.php';</script>";
    exit();
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT c.quantity, p.id, p.name, p.price, p.image_url 
        FROM cart c 
        JOIN products p ON c.product_id = p.id 
        WHERE c.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<div class="container mt-4" id="cart-content">
    <h2 class="text-center">Giỏ hàng của bạn</h2>
    
    <?php if ($result->num_rows === 0): ?>
        <p class="text-center">Giỏ hàng của bạn đang trống.</p>
    <?php else: ?>
        <table class="table table-bordered table-responsive">
            <thead class="bg-danger text-white">
                <tr>
                    <th>Hình ảnh</th>
                    <th>Sản phẩm</th>
                    <th>Số lượng</th>
                    <th>Giá</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $total = 0; // Khởi tạo tổng
                while ($cart_item = $result->fetch_assoc()): 
                    $item_total = $cart_item['price'] * $cart_item['quantity'];
                    $total += $item_total; // Cộng dồn vào tổng
                ?>
                <tr>
                    <td>
                        <img src="images/<?php echo htmlspecialchars($cart_item['image_url']); ?>" 
                             alt="<?php echo htmlspecialchars($cart_item['name']); ?>" 
                             style="width: 50px; height: 50px;">
                    </td>
                    <td><?php echo htmlspecialchars($cart_item['name']); ?></td>
                    <td>
                        <input type="number" class="form-control" 
                               value="<?php echo $cart_item['quantity']; ?>" 
                               min="1" 
                               onchange="updateQuantity(<?php echo $cart_item['id']; ?>, this.value)">
                    </td>
                    <td><?php echo number_format($item_total) . ' VNĐ'; ?></td>
                    <td>
                        <button class="btn btn-danger" onclick="removeFromCart(<?php echo $cart_item['id']; ?>)">Xóa</button>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" class="text-right"><strong>Tổng cộng:</strong></td>
                    <td colspan="2"><?php echo number_format($total) . ' VNĐ'; ?></td>
                </tr>
            </tfoot>
        </table>
        
        <!-- Nút Đặt hàng -->
        <div class="text-center mt-4">
            <form action="order.php" method="POST">
                <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                <button type="submit" class="btn btn-danger text-white" style="width: 200px;" name="place_order">Đặt hàng</button>
            </form>
        </div>
    <?php endif; ?>
</div>

<script>
// Hàm cập nhật số lượng sản phẩm
function updateQuantity(productId, quantity) {
    if (quantity <= 0) {
        alert("Số lượng phải lớn hơn 0.");
        return;
    }
    
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "update_cart.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            var response = JSON.parse(xhr.responseText);
            alert(response.message);
            if (response.success) {
                location.reload(); // Tải lại trang để cập nhật giỏ hàng
            }
        }
    };
    xhr.send("product_id=" + productId + "&quantity=" + quantity);
}

// Hàm xóa sản phẩm khỏi giỏ hàng
function removeFromCart(productId) {
    if (confirm("Bạn có chắc chắn muốn xóa sản phẩm này khỏi giỏ hàng?")) {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "remove_from_cart.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                var response = JSON.parse(xhr.responseText);
                alert(response.message);
                if (response.success) {
                    location.reload(); // Tải lại trang để cập nhật giỏ hàng
                }
            }
        };
        xhr.send("product_id=" + productId);
    }
}

 // Cuộn đến phần nội dung sau khi tải trang
 window.onload = function() {
            window.scrollTo(0, document.querySelector('.container').offsetTop);
        }
</script>

<?php include 'includes/footer.php'; ?>
