<?php 
include 'includes/db_connection.php'; 
include 'includes/header.php'; 
?>
<head>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap">
    <style>
        h1, h2 {
            font-family: 'Roboto', sans-serif;
            font-size: 2rem;
            font-weight: 700;
        }
        .menu-icon {
            width: 50px;
            height: auto;
            margin-right: 10px;
        }
        .menu-category {
            display: flex;
            align-items: center;
        }
        .navbar {
            background-color: black;
            border-radius: 15px;
            padding: 10px;
        }
        .navbar-nav .nav-link {
            color: white;
        }
        .navbar-nav .nav-link:hover {
            color: #ccc;
        }
        .card {
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .card:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }
        .category-container {
            border: 2px solid #ddd;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 30px;
            background-color: #f9f9f9;
        }
        .old-price {
            text-decoration: line-through;
            color: red; /* Màu cho giá cũ */
        }
    </style>
</head>
<main>
    <div class="container mt-4">
        <nav class="navbar navbar-expand-lg navbar-light sticky-top mb-4">
            <div class="container-fluid">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link" href="#uu-dai">Ưu Đãi</a></li>
                    <li class="nav-item"><a class="nav-link" href="#mon-moi">Món Mới</a></li>
                    <li class="nav-item"><a class="nav-link" href="#combo-1-nguoi">Combo 1 Người</a></li>
                    <li class="nav-item"><a class="nav-link" href="#combo-nhom">Combo Nhóm</a></li>
                    <li class="nav-item"><a class="nav-link" href="#ga-ran">Gà Rán - Gà Quay</a></li>
                    <li class="nav-item"><a class="nav-link" href="#burger-com">Burger - Cơm - Mỳ Ý</a></li>
                    <li class="nav-item"><a class="nav-link" href="#thuc-an-nhe">Thức Ăn Nhẹ</a></li>
                    <li class="nav-item"><a class="nav-link" href="#thuc-uong">Thức Uống & Tráng Miệng</a></li>
                </ul>
            </div>
        </nav>

        <!-- Phần đầu nội dung -->
        <div id="content-start">
            <?php
            $categories = [
                'uu-dai' => 'ƯU ĐÃI',
                'mon-moi' => 'MÓN MỚI',
                'combo-1-nguoi' => 'COMBO 1 NGƯỜI',
                'combo-nhom' => 'COMBO NHÓM',
                'ga-ran' => 'GÀ RÁN - GÀ QUAY',
                'burger-com' => 'BURGER - CƠM - MÌ Ý',
                'thuc-an-nhe' => 'THỨC ĂN NHẸ',
                'thuc-uong' => 'THỨC UỐNG & TRÁNG MIỆNG'
            ];

            foreach ($categories as $id => $name) {
                echo "<section id='{$id}' class='category-container'>";
                echo "<div class='menu-category mb-3'>";
                echo "<img src='images/home.png' alt='Icon' class='menu-icon'>";
                echo "<h2 class='text-left'>" . strtoupper($name) . "</h2>";
                echo "</div>";

                // Truy vấn sản phẩm cho từng danh mục
                $sql = "SELECT * FROM products WHERE category_id = (SELECT id FROM categories WHERE name = '$name')";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    echo "<div class='row'>";
                    while ($row = $result->fetch_assoc()) {
                        echo "<div class='col-md-3 mb-4'>";
                        echo "<div class='card h-100'>";
                        echo "<img src='images/" . $row['image_url'] . "' class='card-img-top' alt='" . htmlspecialchars($row['name']) . "'>";
                        echo "<div class='card-body d-flex flex-column'>";
                        echo "<h5 class='card-title'>" . htmlspecialchars($row['name']) . "</h5>";

                        // Kiểm tra xem sản phẩm có thuộc loại "ƯU ĐÃI" không
                        if ($id === 'uu-dai') {
                            echo "<p class='card-text'><span class='old-price'>" . number_format($row['price'] * 1.2) . " VNĐ</span> <br>Giá: " . number_format($row['price']) . " VNĐ</p>"; // Hiển thị giá cũ cho sản phẩm ưu đãi
                        } else {
                            echo "<p class='card-text'>Giá: " . number_format($row['price']) . " VNĐ</p>"; // Chỉ hiển thị giá thật cho các sản phẩm khác
                        }

                        echo "<a href='product_detail.php?id=" . $row['id'] . "' class='btn btn-dark mt-auto'>Xem Chi Tiết</a>";
                        echo "</div>";
                        echo "</div>";
                        echo "</div>";
                    }
                    echo "</div>";
                } else {
                    echo "<p>Hiện tại không có sản phẩm nào trong danh mục này.</p>";
                }

                echo "</section>";
            }
            ?>
        </div>
    </div>

    <div class="mt-4">
        <img src="images/bannerend.jpg" class="img-fluid" alt="Banner" style="width: 100%; height: auto;">
    </div>
</main>

<?php include 'includes/footer.php'; ?> 
<script src="js/bootstrap.bundle.min.js"></script>

<script>
    window.onload = function() {
        // Cuộn trang đến phần đầu nội dung mà không cần người dùng phải cuộn
        var contentStart = document.getElementById('content-start');
        window.scrollTo({
            top: contentStart.offsetTop - document.querySelector('nav').offsetHeight, // Trừ chiều cao của header
            behavior: 'smooth' // Cuộn mượt mà
        });
    };
</script>
</body>
</html>
