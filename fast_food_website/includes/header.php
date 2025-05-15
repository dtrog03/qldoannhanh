<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website KFC - NHÓM 5</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <script src="js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="css/style.css"> 
    <style>
        .header-container {
            background-color: #B8281C; /* Màu nền tối cho header */
            color: white; /* Màu chữ trắng */
            padding-bottom: 5px; /* Tạo khoảng cách dưới header */
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.5); /* Đổ bóng nhẹ cho header */
        }
        .logo img {
            height: 80px; /* Chiều cao logo, tăng lên một chút */
            margin-left: 30px; /* Khoảng cách từ lề trái */
        }
        .top-menu {
            display: flex;
            align-items: center; /* Căn giữa theo chiều dọc */
            padding: 15px 30px; /* Thêm khoảng cách bên trái và bên phải */
        }
        .top-menu .nav {
            margin-left: 20px; /* Khoảng cách giữa logo và menu */
            flex-grow: 1; /* Để menu chiếm không gian còn lại */
        }
        .top-menu .nav-item {
            margin-right: 10px; /* Khoảng cách giữa các mục menu */
        }
        .top-menu .nav-link {
            color: white; /* Màu chữ trắng cho menu */
            font-weight: 600; /* Làm đậm chữ */
            font-size: 1.2rem; /* Kích thước chữ lớn hơn */
            transition: color 0.3s ease; /* Hiệu ứng chuyển màu */
        }
        .top-menu .nav-link:hover {
            color: #EA9B2B; /* Màu chữ khi hover */
            text-decoration: underline; /* Gạch chân khi hover */
        }
        .top-menu .dropdown-menu {
            background-color: #343a40; /* Nền menu dropdown tối */
        }
        .top-menu .nav-item.dropdown:hover .dropdown-menu {
            display: block; /* Hiển thị menu dropdown khi hover */
        }
        .top-menu .dropdown-item {
            color: white; /* Màu chữ trắng cho item dropdown */
        }
        .top-menu .dropdown-item:hover {
            background-color: #495057; /* Nền khi hover trên item dropdown */
        }
        .banner {
            margin-top: 20px; /* Khoảng cách giữa header và banner */
        }
    </style>
</head>
<body>
    <header>
        <div class="header-container sticky-top">
            <div class="top-menu">
                <div class="logo">
                    <img src="images/logo.png" alt="Logo">
                </div>
                <nav>
                    <ul class="nav">
                        <li class="nav-item"><a class="nav-link" href="home.php"><i class="bi bi-house-door-fill"></i> TRANG CHỦ</a></li>
                        <li class="nav-item"><a class="nav-link" href="products_by_category.php"><i class="bi bi-shop"></i> CỬA HÀNG</a></li>
                        <li class="nav-item"><a class="nav-link" href="cart.php"><i class="bi bi-cart-check-fill"></i> GIỎ HÀNG</a></li>
                        <li class="nav-item"><a class="nav-link" href="orders.php"><i class="bi bi-card-checklist"></i> ĐƠN HÀNG</a></li>
                        <li class="nav-item"><a class="nav-link" href="contact.php"><i class="bi bi-envelope-plus-fill"></i> LIÊN HỆ</a></li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="accountDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="bi bi-person-circle"></i> TÀI KHOẢN</a>
                            <ul class="dropdown-menu" aria-labelledby="accountDropdown">
                                <li><a class="dropdown-item" href="login.php">Đăng ký / Đăng nhập</a></li>
                                <li><a class="dropdown-item" href="logout.php">Đăng xuất</a></li>
                                <li><a class="dropdown-item" href="admin_login.php">Admin</a></li>
                            </ul>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
        <div class="banner">
            <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000">
                <div class="carousel-inner">
                    <?php for ($i = 0; $i < 9; $i++): ?>
                        <div class="carousel-item <?php echo $i === 0 ? 'active' : ''; ?>">
                            <img src="images/banner<?php echo $i + 1; ?>.webp" class="d-block w-100" alt="Banner <?php echo $i + 1; ?>">
                        </div>
                    <?php endfor; ?>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    </header>
</body>
</html>
