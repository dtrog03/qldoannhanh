<?php 
session_start(); 
include 'includes/db_connection.php'; 

// Kiểm tra xem người dùng đã đăng nhập với quyền admin chưa
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    echo "<script>alert('Bạn cần đăng nhập với quyền admin để thực hiện hành động này.'); window.location.href='login.php';</script>";
    exit();
}

// Kiểm tra xem có ID người dùng được cung cấp trong URL không
if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    // Bắt đầu giao dịch
    $conn->begin_transaction();

    try {
        // Xóa dữ liệu liên quan trong bảng cart
        $sql_delete_cart = "DELETE FROM cart WHERE user_id = ?";
        $stmt_cart = $conn->prepare($sql_delete_cart);
        $stmt_cart->bind_param("i", $user_id);
        $stmt_cart->execute();
        $stmt_cart->close();

        // Xóa người dùng khỏi cơ sở dữ liệu
        $sql_delete_user = "DELETE FROM users WHERE id = ?";
        $stmt_user = $conn->prepare($sql_delete_user);
        $stmt_user->bind_param("i", $user_id);
        $stmt_user->execute();
        
        if ($stmt_user->affected_rows > 0) {
            // Nếu xóa thành công
            $conn->commit();
            echo "<script>alert('Xóa người dùng thành công!'); window.location.href='admin_users.php';</script>";
        } else {
            // Nếu không tìm thấy người dùng
            $conn->rollback();
            echo "<script>alert('Lỗi khi xóa người dùng hoặc người dùng không tồn tại.'); window.location.href='admin_users.php';</script>";
        }

        $stmt_user->close();
    } catch (Exception $e) {
        // Xử lý lỗi
        $conn->rollback();
        echo "<script>alert('Đã xảy ra lỗi: " . $e->getMessage() . "'); window.location.href='admin_users.php';</script>";
    }
} else {
    echo "<script>alert('Không có ID người dùng nào được cung cấp.'); window.location.href='admin_users.php';</script>";
}

$conn->close();
?>
