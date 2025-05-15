<?php 
include 'includes/db_connection.php'; 
include 'includes/header.php'; 
?>
<head>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap">
    <style>
        h1 {
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

        .card {
            transition: transform 0.3s, box-shadow 0.3s;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .card:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .bordered-section {
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 8px;
        }

        .carousel-control-prev,
        .carousel-control-next {
            width: 5%;
        }

        .card-body {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .btn-view-details {
            margin-top: auto;
            width: 100%;
        }
    </style>
</head>
<body>
<main>
    <div class="container mt-4">
        <!-- DANH MỤC MÓN ĂN -->
        <div class="menu-category mb-3">
            <img src="images/sanpham.png" alt="Icon" class="menu-icon">
            <h1 class="text-left">DANH MỤC MÓN ĂN</h1>
        </div>
        <div class="border p-4">
            <div class="row">
                <?php
                $categories = [
                    ['id' => 4, 'name' => 'Ưu Đãi', 'description' => 'Những ưu đãi hấp dẫn cho bạn.', 'image_url' => 'images/uudai.jpg'],
                    ['id' => 5, 'name' => 'Món Mới', 'description' => 'Khám phá các món mới nhất.', 'image_url' => 'images/monmoi.jpg'],
                    ['id' => 6, 'name' => 'Combo 1 Người', 'description' => 'Thưởng thức các combo dành cho 1 người.', 'image_url' => 'images/combo1nguoi.jpg'],
                    ['id' => 7, 'name' => 'Combo Nhóm', 'description' => 'Combo tuyệt vời cho nhóm bạn.', 'image_url' => 'images/combonhom.jpg'],
                    ['id' => 8, 'name' => 'Gà Rán - Gà Quay', 'description' => 'Món gà rán và gà quay thơm ngon.', 'image_url' => 'images/ga.jpg'],
                    ['id' => 9, 'name' => 'Burger - Cơm - Mỳ Ý', 'description' => 'Thực đơn đa dạng với burger, cơm và mỳ ý.', 'image_url' => 'images/berger.jpg'],
                    ['id' => 10, 'name' => 'Thức Ăn Nhẹ', 'description' => 'Thức ăn nhẹ dành cho bạn.', 'image_url' => 'images/annhe.jpg'],
                    ['id' => 11, 'name' => 'Thức Uống & Tráng Miệng', 'description' => 'Thưởng thức thức uống và món tráng miệng.', 'image_url' => 'images/trangmieng.jpg']
                ];

                foreach ($categories as $category) {
                    echo "<div class='col-md-3 mb-4'>";
                    echo "<div class='card h-100'>";
                    echo "<img src='" . $category['image_url'] . "' class='card-img-top' alt='" . htmlspecialchars($category['name']) . "'>";
                    echo "<div class='card-body d-flex flex-column'>";
                    echo "<h5 class='card-title'>" . htmlspecialchars($category['name']) . "</h5>";
                    echo "<p class='card-text'>" . htmlspecialchars($category['description']) . "</p>";
                    // Add anchor to link with the scroll target
                    echo "<a href='products_by_category.php?category=" . urlencode($category['id']) . "&scrollTo=" . urlencode($category['name']) . "' class='btn btn-dark btn-view-details'>Xem Sản Phẩm</a>";
                    echo "</div>";
                    echo "</div>";
                    echo "</div>";
                }
                ?>
            </div>
        </div>

        <!-- CÁC MÓN CÓ THỂ BẠN SẼ THÍCH -->
        <div class="mt-4 bordered-section">
            <div class="menu-category mb-3">
                <img src="images/sanpham2.png" alt="Icon" class="menu-icon"> <!-- Thêm ảnh biểu tượng -->
                <h1 class="text-left">CÓ THỂ BẠN SẼ THÍCH MÓN NÀY</h1>
            </div>
            <div id="recommendedItemsCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <?php
                    $sql = "SELECT * FROM products";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        $activeClass = 'active';
                        $counter = 0;
                        echo "<div class='carousel-item $activeClass'>";
                        echo "<div class='row'>";
                        while ($row = $result->fetch_assoc()) {
                            if ($counter > 0 && $counter % 4 == 0) {
                                echo "</div></div>";
                                echo "<div class='carousel-item'>";
                                echo "<div class='row'>";
                            }
                            echo "<div class='col-md-3'>";
                            echo "<div class='card h-100'>";
                            echo "<img src='images/" . htmlspecialchars($row['image_url']) . "' class='card-img-top' alt='" . htmlspecialchars($row['name']) . "'>";
                            echo "<div class='card-body d-flex flex-column'>";
                            echo "<h5 class='card-title'>" . htmlspecialchars($row['name']) . "</h5>";
                            echo "<p class='card-text'>Giá: " . number_format($row['price']) . " VNĐ</p>";
                            echo "<a href='product_detail.php?id=" . $row['id'] . "' class='btn btn-dark btn-view-details'>Xem Chi Tiết</a>";
                            echo "</div></div></div>";
                            $counter++;
                        }
                        echo "</div></div>";
                    } else {
                        echo "<p>Không có sản phẩm nào để hiển thị.</p>";
                    }
                    ?>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#recommendedItemsCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#recommendedItemsCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    </div>
    <div class="mt-4">
        <img src="images/bannerend.jpg" class="img-fluid" alt="Banner" style="width: 100%; height: auto;">
    </div>
</main>
<?php include 'includes/footer.php'; ?> 
<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
