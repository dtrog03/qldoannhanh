<?php 
include 'includes/db_connection.php'; 

if (!isset($_GET['id'])) {
    header("Location: list_products.php");
    exit();
}

$product_id = (int)$_GET['id'];

$stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
$stmt->bind_param("i", $product_id);
$stmt->execute();
$product = $stmt->get_result()->fetch_assoc();
$stmt->close();

$message = "";

if (isset($_POST['submit'])) {
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $price = (float)$_POST['price'];
    $category_id = (int)$_POST['category_id'];

    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $imageName = $_FILES['image']['name'];
        $imageTmpName = $_FILES['image']['tmp_name'];
        $imageFolder = 'images/' . basename($imageName);
        $allowedTypes = ['image/jpeg', 'image/png'];
        
        if (!in_array($_FILES['image']['type'], $allowedTypes)) {
            $message = "Vui lòng chọn ảnh JPEG hoặc PNG.";
        } elseif ($_FILES['image']['size'] > 2 * 1024 * 1024) {
            $message = "Kích thước ảnh phải nhỏ hơn 2MB.";
        } else {
            if (move_uploaded_file($imageTmpName, $imageFolder)) {
                $stmt = $conn->prepare("UPDATE products SET name = ?, description = ?, price = ?, image_url = ?, category_id = ? WHERE id = ?");
                $stmt->bind_param("ssdssi", $name, $description, $price, $imageName, $category_id, $product_id);
                if ($stmt->execute()) {
                    $message = "Sản phẩm đã được cập nhật thành công!";
                } else {
                    $message = "Lỗi: " . $stmt->error;
                }
                $stmt->close();
            } else {
                $message = "Lỗi khi tải ảnh lên.";
            }
        }
    } else {
        $stmt = $conn->prepare("UPDATE products SET name = ?, description = ?, price = ?, category_id = ? WHERE id = ?");
        $stmt->bind_param("ssdsi", $name, $description, $price, $category_id, $product_id);
        if ($stmt->execute()) {
            $message = "Sản phẩm đã được cập nhật thành công!";
        } else {
            $message = "Lỗi: " . $stmt->error;
        }
        $stmt->close();
    }
}

$categories = $conn->query("SELECT * FROM categories");
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Sửa Sản Phẩm</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            background-color: white;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }
        .alert {
            margin-bottom: 20px;
        }
        h1 {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <main class="container my-4">
        <h1 class="text-center">Sửa Sản Phẩm</h1>
        <?php if ($message): ?>
            <div class="alert alert-info"><?php echo $message; ?></div>
        <?php endif; ?>
        <form action="edit_product.php?id=<?php echo $product_id; ?>" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="name" class="form-label">Tên sản phẩm:</label>
                <input type="text" id="name" name="name" class="form-control" value="<?php echo $product['name']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Mô tả sản phẩm:</label>
                <textarea id="description" name="description" class="form-control" required><?php echo $product['description']; ?></textarea>
            </div>

            <div class="mb-3">
                <label for="price" class="form-label">Giá sản phẩm (VNĐ):</label>
                <input type="number" id="price" name="price" class="form-control" value="<?php echo $product['price']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="category_id" class="form-label">Loại sản phẩm:</label>
                <select id="category_id" name="category_id" class="form-select" required>
                    <option value="">Chọn loại sản phẩm</option>
                    <?php while ($row = $categories->fetch_assoc()): ?>
                        <option value="<?php echo $row['id']; ?>" <?php echo $row['id'] == $product['category_id'] ? 'selected' : ''; ?>><?php echo $row['name']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">Hình ảnh sản phẩm:</label>
                <input type="file" id="image" name="image" accept="image/*" class="form-control">
                <p class="text-muted">Để giữ hình ảnh hiện tại, hãy không chọn file mới.</p>
            </div>

            <button type="submit" name="submit" class="btn btn-primary">Cập Nhật Sản Phẩm</button>
        </form>
    </main>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>


