<?php 
$host = "localhost";
$username = "root";
$password = "";
$database = "qldan";

// Câu lệnh kết nối đến MySQL
$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}
// echo "Kết nối thành công!";
?>
