<?php 
include 'includes/db_connection.php'; 

// Khởi tạo biến thông báo
$message = "";

if (isset($_POST['submit'])) {
    // Lấy thông tin từ form và xác thực đầu vào
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $price = (float)$_POST['price'];
    $category_id = (int)$_POST['category_id'];

    // Xử lý và lưu ảnh
    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $imageName = $_FILES['image']['name'];
        $imageTmpName = $_FILES['image']['tmp_name'];
        $imageFolder = 'images/' . basename($imageName);

        // Kiểm tra loại tệp
        $allowedTypes = ['image/jpeg', 'image/png'];
        if (!in_array($_FILES['image']['type'], $allowedTypes)) {
            $message = "Vui lòng chọn ảnh JPEG hoặc PNG.";
        } elseif ($_FILES['image']['size'] > 2 * 1024 * 1024) { // Giới hạn kích thước 2MB
            $message = "Kích thước ảnh phải nhỏ hơn 2MB.";
        } else {
            // Di chuyển ảnh vào thư mục "images"
            if (move_uploaded_file($imageTmpName, $imageFolder)) {
                // Thêm sản phẩm vào cơ sở dữ liệu
                $stmt = $conn->prepare("INSERT INTO products (name, description, price, image_url, category_id) VALUES (?, ?, ?, ?, ?)");
                $stmt->bind_param("ssdsi", $name, $description, $price, $imageName, $category_id);

                if ($stmt->execute()) {
                    $message = "Sản phẩm đã được thêm thành công!";
                } else {
                    $message = "Lỗi: " . $stmt->error;
                }
                $stmt->close();
            } else {
                $message = "Lỗi khi tải ảnh lên.";
            }
        }
    } else {
        $message = "Vui lòng chọn hình ảnh.";
    }
}

// Lấy danh sách loại sản phẩm từ cơ sở dữ liệu
$categories = $conn->query("SELECT * FROM categories");
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Thêm Sản Phẩm</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa; /* Nền nhẹ nhàng */
        }
        .container {
            background-color: white; /* Nền trắng cho form */
            border-radius: 8px; /* Bo góc cho form */
            padding: 30px; /* Padding cho form */
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1); /* Đổ bóng cho form */
        }
        .alert {
            margin-bottom: 20px; /* Khoảng cách cho thông báo */
        }
        h1 {
            margin-bottom: 20px; /* Khoảng cách cho tiêu đề */
        }
    </style>
</head>
<body>

<main class="container my-4">
    <h1 class="text-center">Thêm Sản Phẩm Mới</h1>
    <?php if ($message): ?>
        <div class="alert alert-info"><?php echo $message; ?></div>
    <?php endif; ?>
    <form action="add_product.php" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="name" class="form-label">Tên sản phẩm:</label>
            <input type="text" id="name" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Mô tả sản phẩm:</label>
            <textarea id="description" name="description" class="form-control" required></textarea>
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">Giá sản phẩm (VNĐ):</label>
            <input type="number" id="price" name="price" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="category_id" class="form-label">Loại sản phẩm:</label>
            <select id="category_id" name="category_id" class="form-select" required>
                <option value="">Chọn loại sản phẩm</option>
                <?php while ($row = $categories->fetch_assoc()): ?>
                    <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Hình ảnh sản phẩm:</label>
            <input type="file" id="image" name="image" accept="image/*" class="form-control" required>
        </div>

        <button type="submit" name="submit" class="btn btn-primary">Thêm Sản Phẩm</button>
    </form>
</main>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
