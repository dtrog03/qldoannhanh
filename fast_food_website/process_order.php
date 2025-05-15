<?php 
session_start(); 
include 'includes/db_connection.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $total = $_POST['total'];
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    
    // Lưu thông tin đơn hàng vào cơ sở dữ liệu
    $sql_order = "INSERT INTO orders (user_id, total, name, phone, order_date) VALUES (?, ?, ?, ?, NOW())";
    $stmt_order = $conn->prepare($sql_order);
    $stmt_order->bind_param("idss", $user_id, $total, $name, $phone);
    if ($stmt_order->execute()) {
        // Xóa giỏ hàng sau khi đặt hàng thành công
        $sql_delete_cart = "DELETE FROM cart WHERE user_id = ?";
        $stmt_delete_cart = $conn->prepare($sql_delete_cart);
        $stmt_delete_cart->bind_param("i", $user_id);
        $stmt_delete_cart->execute();

        echo "<script>alert('Đặt hàng thành công!'); window.location.href='index.php';</script>";
    } else {
        echo "<script>alert('Có lỗi xảy ra. Vui lòng thử lại.'); window.location.href='cart.php';</script>";
    }
} else {
    echo "<script>alert('Yêu cầu không hợp lệ.'); window.location.href='index.php';</script>";
}
?>
