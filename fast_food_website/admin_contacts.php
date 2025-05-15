<?php 
session_start(); 
include 'includes/db_connection.php'; 

// Kiểm tra xem người dùng đã đăng nhập với quyền admin chưa
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    echo "<script>alert('Bạn cần đăng nhập với quyền admin để quản lý phản hồi.'); window.location.href='login.php';</script>";
    exit();
}

// Lấy danh sách phản hồi từ cơ sở dữ liệu
$sql_feedback = "SELECT * FROM contacts ORDER BY create_at DESC"; // Sử dụng cột created_at
$result_feedback = $conn->query($sql_feedback);

// Kiểm tra nếu có lỗi trong truy vấn
if (!$result_feedback) {
    die("Lỗi truy vấn: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Quản Lý Phản Hồi</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .table-responsive {
            width: 100%;
        }
    </style>
</head>
<body>

<div class="container mt-4">
    <h2 class="text-center">Quản Lý Phản Hồi</h2>

    <div class="feedback-list-container">
        <?php if ($result_feedback->num_rows === 0): ?>
            <p class="text-center">Không có phản hồi nào.</p>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="bg-danger text-white">
                        <tr>
                            <th>ID</th>
                            <th>Tên người gửi</th>
                            <th>Email</th>
                            <th>Số điện thoại</th>
                            <th>Thông điệp</th>
                            <th>Ngày gửi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($feedback = $result_feedback->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $feedback['id']; ?></td>
                                <td><?php echo htmlspecialchars($feedback['name']); ?></td>
                                <td><?php echo htmlspecialchars($feedback['email']); ?></td>
                                <td><?php echo htmlspecialchars($feedback['phone']); ?></td>
                                <td><?php echo htmlspecialchars($feedback['message']); ?></td>
                                <td><?php echo date('d/m/Y H:i:s', strtotime($feedback['create_at'])); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
</body>
</html>
