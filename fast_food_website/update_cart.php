<?php
session_start();
include 'includes/db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_SESSION['user_id'])) {
        $response = [
            'success' => false,
            'message' => 'Bạn cần đăng nhập để cập nhật sản phẩm trong giỏ hàng.'
        ];
        echo json_encode($response);
        exit();
    }

    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];
    $user_id = $_SESSION['user_id'];

    if (!is_numeric($product_id) || !is_numeric($quantity) || $quantity <= 0) {
        $response = [
            'success' => false,
            'message' => 'ID sản phẩm hoặc số lượng không hợp lệ.'
        ];
        echo json_encode($response);
        exit();
    }

    $sql = "UPDATE cart SET quantity = ? WHERE user_id = ? AND product_id = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iii", $quantity, $user_id, $product_id);
    
    if ($stmt->execute()) {
        $response = [
            'success' => true,
            'message' => 'Số lượng sản phẩm đã được cập nhật!'
        ];
    } else {
        $response = [
            'success' => false,
            'message' => 'Có lỗi xảy ra. Vui lòng thử lại.'
        ];
    }
    echo json_encode($response);
}
?>
