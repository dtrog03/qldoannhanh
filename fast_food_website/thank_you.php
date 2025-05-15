<?php 
session_start(); 
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cảm ơn</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
        .thank-you-container {
            margin: 50px auto; /* Tạo khoảng cách trên và dưới */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            border: 1px solid #dee2e6; /* Đường viền của khung */
            background-color: white;
        }
        .thank-you-image {
            width: 100%; /* Chiều rộng 100% */
            height: auto; /* Chiều cao tự động để giữ tỷ lệ */
            border-radius: 10px; /* Bo tròn góc */
        }
        .btn-back {
            background-color: red !important; /* Nền đỏ */
            color: white !important; /* Chữ trắng */
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="thank-you-container text-center">
                    <h3>Cảm ơn bạn đã đặt hàng!</h3>
                    <img src="images/thankyou.jpg" alt="Thank You" class="thank-you-image mb-4"> <!-- Hình ảnh cảm ơn -->
                    <p>Đơn hàng của bạn đã được xác nhận và sẽ được xử lý sớm nhất có thể.</p>
                    <p>Nếu bạn có bất kỳ câu hỏi nào, vui lòng liên hệ với chúng tôi.</p>
                    <a href="home.php" class="btn btn-back">Quay lại trang chủ</a> <!-- Chuyển hướng về home.php -->
                </div>
            </div>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>
    
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
