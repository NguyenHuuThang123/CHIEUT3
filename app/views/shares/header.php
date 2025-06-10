<?php
// Tính tổng số lượng sản phẩm trong giỏ hàng
$totalQuantity = 0;
if (!empty($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        $totalQuantity += $item['quantity'];
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web Bán Hàng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            background: #f0f2f5;
        }
        .navbar {
            background: linear-gradient(135deg, #2c3e50, #3498db);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            transition: all 0.3s ease;
        }
        .navbar-brand img {
            height: 40px;
            transition: transform 0.3s ease;
        }
        .navbar-brand img:hover {
            transform: scale(1.1);
        }
        .navbar-brand span {
            color: white;
            font-weight: 700;
            font-size: 1.5rem;
        }
        .nav-link {
            color: white !important;
            font-weight: 500;
            padding: 0.5rem 1rem;
            transition: all 0.3s ease;
        }
        .nav-link:hover {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 0.5rem;
        }
        .search-form {
            position: relative;
            max-width: 250px;
        }
        .search-form .form-control {
            padding-left: 2.5rem;
            border-radius: 1rem;
            background: rgba(255, 255, 255, 0.95);
            border: none;
        }
        .search-form .bi-search {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
        }
        .cart-icon {
            position: relative;
            color: white;
            transition: transform 0.3s ease;
        }
        .cart-icon:hover {
            transform: scale(1.2);
        }
        .cart-icon .badge {
            position: absolute;
            top: -8px;
            right: -8px;
            font-size: 0.7rem;
            background: #dc3545;
            border-radius: 50%;
        }
        .dropdown-menu {
            border-radius: 0.5rem;
            border: none;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            background: #2c3e50;
        }
        .dropdown-item {
            color: white;
            transition: background 0.3s ease;
        }
        .dropdown-item:hover {
            background: #3498db;
        }
        .navbar-toggler {
            border: none;
        }
        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba(255, 255, 255, 0.9)' stroke-width='2' stroke-linecap='round' stroke-miterlimit='10' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="/WebBanHang">
                <img src="/WebBanHang/images/logo.png" alt="Logo" class="me-2">
                <span>Web Bán Hàng</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="/WebBanHang/Product/">Danh sách sản phẩm</a>
                    </li>
                    <?php if (SessionHelper::isAdmin()): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="/webbanhang/account/listUsers">Danh sách người dùng</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/WebBanHang/Product/add">Thêm sản phẩm</a>
                        </li>
                    <?php endif; ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/WebBanHang/Category/list">Danh mục</a>
                    </li>
                </ul>
                <div class="d-flex align-items-center gap-3">
                    <form class="search-form" action="/WebBanHang/Product/search" method="GET">
                        <i class="bi bi-search"></i>
                        <input type="text" class="form-control" name="query" placeholder="Tìm kiếm sản phẩm...">
                    </form>
                    <a href="/WebBanHang/Product/Cart" class="cart-icon">
                        <i class="bi bi-cart3 fs-4"></i>
                        <span class="badge"><?php echo $totalQuantity ?? 0; ?></span>
                    </a>
                    <div class="dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <?php echo SessionHelper::isLoggedIn() ? htmlspecialchars($_SESSION['username']) : 'Tài khoản'; ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <?php if (SessionHelper::isLoggedIn()): ?>
                                <li><a class="dropdown-item" href="/webbanhang/account/editProfile">Cập nhật thông tin</a></li>
                                <li><a class="dropdown-item" href="/webbanhang/account/logout">Đăng xuất</a></li>
                            <?php else: ?>
                                <li><a class="dropdown-item" href="/webbanhang/account/login">Đăng nhập</a></li>
                                <li><a class="dropdown-item" href="/webbanhang/account/register">Đăng ký</a></li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <div class="container mt-5">
        <!-- Nội dung chính sẽ được thêm vào đây -->
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>