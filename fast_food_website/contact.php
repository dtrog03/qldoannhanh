<?php 
session_start(); 
include 'includes/db_connection.php'; 
include 'includes/header.php'; 

// Khởi tạo biến để lưu thông báo lỗi
$error_message = "";

// Nếu là yêu cầu POST, xử lý dữ liệu liên hệ
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Lấy dữ liệu từ form
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
    $message = isset($_POST['message']) ? $_POST['message'] : '';
    $user_id = $_SESSION['user_id'] ?? null;

    // Kiểm tra các trường bắt buộc
    if (empty($name) || empty($email) || empty($phone) || empty($message)) {
        $error_message = "Vui lòng điền đầy đủ thông tin.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = "Địa chỉ email không hợp lệ.";
    } elseif (!preg_match('/^[0-9]{10,15}$/', $phone)) {
        $error_message = "Số điện thoại không hợp lệ.";
    } else {
        // Chèn dữ liệu vào bảng contacts
        $stmt = $conn->prepare("INSERT INTO contacts (name, email, phone, message, user_id) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssi", $name, $email, $phone, $message, $user_id);

        // Thực hiện truy vấn và kiểm tra kết quả
        if ($stmt->execute()) {
            echo "<script>alert('Cảm ơn bạn đã gửi thông tin!'); window.location.href='home.php';</script>";
            exit();
        } else {
            $error_message = "Có lỗi xảy ra. Vui lòng thử lại.";
        }
    }
}
?>

<main>
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="row">
                    <!-- Phần ảnh -->
                    <div class="col-md-6 d-flex align-items-center justify-content-center">
                        <img src="images/contact.jpg" alt="Liên hệ với chúng tôi" class="contact-image" style="max-width: 100%; height: auto; border-radius: 10px;">
                    </div>

                    <!-- Phần form liên hệ -->
                    <div class="col-md-6">
                        <h3 class="text-center">Liên Hệ</h3>
                        <?php if (!empty($error_message)) echo "<div class='alert alert-danger'>$error_message</div>"; ?>
                        
                        <form method="POST" action="">
                            <div class="form-group">
                                <label for="name">Họ tên:</label>
                                <input type="text" id="name" name="name" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input type="email" id="email" name="email" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="phone">Số điện thoại:</label>
                                <input type="text" id="phone" name="phone" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="message">Tin nhắn:</label>
                                <textarea id="message" name="message" class="form-control" rows="5" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-danger btn-block w-100">Gửi Ý Kiến</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include 'includes/footer.php'; ?>
<script src="js/bootstrap.bundle.min.js"></script>
<script>
    // Cuộn đến phần nội dung sau khi tải trang
 window.onload = function() {
            window.scrollTo(0, document.querySelector('.container').offsetTop);
        }
</script>
</body>
</html>
