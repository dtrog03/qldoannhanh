<?php 
session_start(); 
include 'includes/db_connection.php'; 

// Kiểm tra xem người dùng đã đăng nhập với quyền admin chưa
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    echo "<script>alert('Bạn cần đăng nhập với quyền admin để xem thống kê.'); window.location.href='login.php';</script>";
    exit();
}

// Khởi tạo biến doanh thu
$doanh_thu = 0;
$dates = [];
$totalRevenue = [];

// Nếu có dữ liệu từ form tìm kiếm
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    // Lấy doanh thu từ các đơn hàng có status là 'completed'
    $stmt_doanh_thu = $conn->prepare("SELECT order_date, SUM(total) AS total_doanh_thu FROM orders WHERE order_date BETWEEN ? AND ? AND status = 'completed' GROUP BY order_date");
    $stmt_doanh_thu->bind_param("ss", $start_date, $end_date);
    $stmt_doanh_thu->execute();
    $result_doanh_thu = $stmt_doanh_thu->get_result();
    
    while ($row = $result_doanh_thu->fetch_assoc()) {
        $dates[] = date('d-m-Y', strtotime($row['order_date']));
        $totalRevenue[] = (float)$row['total_doanh_thu'];
    }

    $stmt_doanh_thu->close();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Thống Kê Doanh Thu</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            background-color: #f8f9fa; /* Màu nền sáng */
        }
        .header {
            background-color: #007bff; /* Màu xanh cho header */
            color: white; 
            padding: 10px;
            border-radius: 5px;
        }
        .result-container {
            background-color: white; 
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1); 
            padding: 20px;
            margin-top: 20px;
        }
        .btn-primary {
            background-color: #28a745; /* Màu xanh lá cho nút */
            border: none;
        }
        .btn-primary:hover {
            background-color: #218838; /* Màu tối hơn khi hover */
        }
    </style>
</head>
<body>

<div class="container mt-4">
    <h2 class="text-center header">Thống Kê Doanh Thu</h2>

    <form method="POST" class="mb-4">
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="start_date">Ngày bắt đầu</label>
                <input type="date" class="form-control" id="start_date" name="start_date" required>
            </div>
            <div class="form-group col-md-6">
                <label for="end_date">Ngày kết thúc</label>
                <input type="date" class="form-control" id="end_date" name="end_date" required>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Tìm kiếm</button>
    </form>

    <div class="result-container">
        <?php if ($_SERVER["REQUEST_METHOD"] == "POST"): ?>
            <h4 class="text-center">Tổng doanh thu từ <?php echo htmlspecialchars($start_date); ?> đến <?php echo htmlspecialchars($end_date); ?>: <?php echo number_format(array_sum($totalRevenue), 2, ',', '.') . ' VNĐ'; ?></h4>
            <canvas id="doanhThuChart" width="400" height="200"></canvas>

            <script>
                const ctx = document.getElementById('doanhThuChart').getContext('2d');
                const doanhThuChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: <?php echo json_encode($dates); ?>,
                        datasets: [{
                            label: 'Doanh Thu (VNĐ)',
                            data: <?php echo json_encode($totalRevenue); ?>,
                            backgroundColor: 'rgba(40, 167, 69, 0.5)', // Màu xanh lá nhạt
                            borderColor: 'rgba(40, 167, 69, 1)', // Màu xanh lá đậm
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            </script>
        <?php endif; ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
</body>
</html>
