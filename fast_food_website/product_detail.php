<?php 
session_start(); 
include 'includes/db_connection.php'; 
include 'includes/header.php'; 

// Kiểm tra trạng thái đăng nhập
$is_logged_in = isset($_SESSION['user_id']);

// Kiểm tra xem ID sản phẩm có được truyền vào URL hay không
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $product_id = $_GET['id'];

    // Truy vấn sản phẩm theo ID
    $sql = "SELECT * FROM products WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Kiểm tra xem sản phẩm có tồn tại không
    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
        ?>
        
        <div class="container mt-4 mb-4"> <!-- Thêm khoảng cách dưới -->
            <div class="row">
                <div class="col-md-6">
                    <img src="images/<?php echo $product['image_url']; ?>" class="img-fluid rounded" alt="<?php echo htmlspecialchars($product['name']); ?>" style="border-radius: 15px;"> <!-- Bo góc nhẹ -->
                </div>
                <div class="col-md-6">
                    <h2><?php echo htmlspecialchars($product['name']); ?></h2>
                    <p><?php echo nl2br(htmlspecialchars($product['description'])); ?></p>
                    <p>Giá: <?php echo number_format($product['price']); ?> VNĐ</p>
                    
                    <div class="mb-3">
                        <label for="quantity" class="form-label">Số lượng:</label>
                        <input type="number" id="quantity" name="quantity" class="form-control" value="1" min="1" required>
                    </div>
                    
                    <button class="btn btn-dark" onclick="addToCart(<?php echo $product['id']; ?>, <?php echo $is_logged_in ? 'true' : 'false'; ?>)">Thêm vào giỏ hàng</button>
                    <div id="message" class="mt-3"></div> <!-- Khu vực thông báo -->
                </div>
            </div>
        </div>

        <script>
        function addToCart(productId, isLoggedIn) {
            const messageDiv = document.getElementById('message');
            
            // Kiểm tra trạng thái đăng nhập
            if (!isLoggedIn) {
                messageDiv.innerHTML = '<div class="alert alert-warning">Bạn cần đăng nhập để thêm sản phẩm vào giỏ hàng.</div>';
                
                // Tự động ẩn thông báo sau 3 giây
                setTimeout(() => {
                    messageDiv.innerHTML = '';
                }, 3000);
                
                return;
            }

            const quantity = document.getElementById('quantity').value;

            fetch('add_to_cart.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 'product_id=' + productId + '&quantity=' + quantity
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    messageDiv.innerHTML = '<div class="alert alert-success">' + data.message + '</div>';
                } else {
                    messageDiv.innerHTML = '<div class="alert alert-danger">' + data.message + '</div>';
                }

                setTimeout(() => {
                    messageDiv.innerHTML = '';
                }, 3000);
            })
            .catch(error => {
                console.error('Error:', error);
                messageDiv.innerHTML = '<div class="alert alert-danger">Có lỗi xảy ra. Vui lòng thử lại.</div>';
                
                setTimeout(() => {
                    messageDiv.innerHTML = '';
                }, 3000);
            });
        }

        // Cuộn đến phần nội dung sau khi tải trang
        window.onload = function() {
            window.scrollTo(0, document.querySelector('.container').offsetTop);
        }
        </script>

        <?php
    } else {
        echo "<p>Sản phẩm không tồn tại.</p>";
    }
} else {
    echo "<p>Không có ID sản phẩm được cung cấp.</p>";
}

include 'includes/footer.php'; 
?>
