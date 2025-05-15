<?php 
include 'includes/db_connection.php'; 

// Kiểm tra xem có ID loại sản phẩm không
if (!isset($_GET['id'])) {
    header("Location: list_categories.php");
    exit();
}

$category_id = (int)$_GET['id'];

// Lấy thông tin loại sản phẩm
$stmt = $conn->prepare("SELECT * FROM categories WHERE id = ?");
$stmt->bind_param("i", $category_id);
$stmt->execute();
$category = $stmt->get_result()->fetch_assoc();
$stmt->close();

$message = "";

if (isset($_POST['submit'])) {
    // Lấy thông tin từ form
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);

    // Cập nhật loại sản phẩm vào cơ sở dữ liệu
    $stmt = $conn->prepare("UPDATE categories SET name = ?, description = ? WHERE id = ?");
    $stmt->bind_param("ssi", $name, $description, $category_id);

    if ($stmt->execute()) {
        $message = "Cập nhật loại sản phẩm thành công!";
    } else {
        $message = "Lỗi: " . $stmt->error;
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa Loại Sản Phẩm</title>
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
        h1 {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<main class="container my-4">
    <h1 class="text-center">Sửa Loại Sản Phẩm</h1>
    <?php if ($message): ?>
        <div class="alert alert-info"><?php echo $message; ?></div>
    <?php endif; ?>

    <form action="edit_category.php?id=<?php echo $category_id; ?>" method="post">
        <div class="mb-3">
            <label for="name" class="form-label">Tên loại sản phẩm:</label>
            <input type="text" id="name" name="name" class="form-control" value="<?php echo htmlspecialchars($category['name']); ?>" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Mô tả loại sản phẩm:</label>
            <textarea id="description" name="description" class="form-control" rows="3" required><?php echo htmlspecialchars($category['description']); ?></textarea>
        </div>

        <button type="submit" name="submit" class="btn btn-primary">Cập Nhật Loại Sản Phẩm</button>
    </form>
</main>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></scri
</body>
</html>
