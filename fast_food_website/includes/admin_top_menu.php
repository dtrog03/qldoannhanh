<!-- includes/admin_top_menu.php -->
<div class="header-container d-flex align-items-center">
    <div class="logo">
        <img src="images/logo.png" alt="Logo">
    </div>
    <nav class="top-menu ml-3">
        <ul class="nav">
            <li class="nav-item"><a class="nav-link" href="list_products.php"><i class="bi bi-tag-fill"></i> Quản lý sản phẩm</a></li>
            <li class="nav-item"><a class="nav-link" href="list_categories.php"><i class="bi bi-tags-fill"></i> Quản lý loại sản phẩm</a></li>
            <li class="nav-item"><a class="nav-link" href="admin_orders.php"><i class="bi bi-card-list"></i> Quản lý đơn hàng</a></li>         
            <li class="nav-item"><a class="nav-link" href="admin_contacts.php"><i class="bi bi-envelope-exclamation"></i> Phản hồi từ khách hàng</a></li>
            <li class="nav-item"><a class="nav-link" href="admin_users.php"><i class="bi bi-people"></i> Quản lý người dùng</a></li>
            <li class="nav-item"><a class="nav-link" href="thong_ke.php"><i class="bi bi-bar-chart-line"></i> Thống kê doanh thu</a></li>
            <li class="nav-item"><a class="nav-link" href="logout.php"><i class="bi bi-box-arrow-right"></i> Đăng xuất</a></li>
        </ul>
    </nav>
</div>

<style>
    .header-container {
        background-color: #B8281C; /* Màu nền tối cho header */
        color: white; /* Màu chữ trắng */
        position: sticky;
        top: 0;
        z-index: 1000;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.5); /* Đổ bóng nhẹ cho header */
    }
    .logo img {
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
        margin-right: 0px; /* Khoảng cách giữa các mục menu */
    }
    .top-menu .nav-link {
        color: white; /* Màu chữ trắng cho menu */
        font-weight: 600; /* Làm đậm chữ */
        font-size: 1.1rem; /* Kích thước chữ lớn hơn */
        transition: color 0.3s ease; /* Hiệu ứng chuyển màu */
    }
    .top-menu .nav-link:hover {
        color: #EA9B2B; /* Màu chữ khi hover */
        text-decoration: underline; /* Gạch chân khi hover */
    }
</style>
