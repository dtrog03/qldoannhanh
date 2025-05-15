<?php
session_start();
include 'includes/db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Kiểm tra và lấy dữ liệu từ yêu cầu POST
    if (isset($_POST['product_id']) && isset($_SESSION['user_id'])) {
        $product_id = $_POST['product_id'];
        $user_id = $_SESSION['user_id'];

        // Câu lệnh SQL để xóa sản phẩm khỏi giỏ hàng
        $sql = "DELETE FROM cart WHERE user_id = ? AND product_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $user_id, $product_id);

        // Thực thi câu lệnh và trả về phản hồi JSON
        if ($stmt->execute()) {
            $response = [
                'success' => true,
                'message' => 'Sản phẩm đã được xóa khỏi giỏ hàng!'
            ];
        } else {
            $response = [
                'success' => false,
                'message' => 'Có lỗi xảy ra. Vui lòng thử lại.'
            ];
        }
        echo json_encode($response);
    } else {
        // Xử lý trường hợp thiếu dữ liệu
        echo json_encode([
            'success' => false,
            'message' => 'Dữ liệu không hợp lệ.'
        ]);
    }
}
?>
