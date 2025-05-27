<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web Bán Hàng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        .navbar-brand img {
            height: 40px;
        }
        .navbar {
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .nav-link {
            font-weight: 500;
            transition: color 0.3s ease;
        }
        .nav-link:hover {
            color: #0d6efd !important;
        }
        .search-form {
            max-width: 300px;
            position: relative;
        }
        .search-form .form-control {
            padding-left: 2.5rem;
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
        }
        .cart-icon .badge {
            position: absolute;
            top: -5px;
            right: -10px;
            font-size: 0.75rem;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top">
        <div class="container">
            <a class="navbar-brand" href="/WebBanHang">
                <img src="/WebBanHang/images/logo.png" alt="Logo" class="me-2"> 
                <span class="fw-bold">Web Bán Hàng</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/WebBanHang/Product/">Danh sách sản phẩm</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/WebBanHang/Product/add">Thêm sản phẩm</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/WebBanHang/Category/list">Danh mục</a>
                    </li>
                </ul>
                <div class="d-flex align-items-center gap-3">
                    <form class="search-form" action="/WebBanHang/Product/search" method="GET">
                        <i class="bi bi-search"></i>
                        <input type="text" class="form-control rounded-pill" name="query" placeholder="Tìm kiếm sản phẩm...">
                    </form>
                    <a href="/WebBanHang/Product/Cart" class="cart-icon text-dark">
                        <i class="bi bi-cart3 fs-4"></i>
                        <span class="badge bg-danger rounded-circle">0</span>
                    </a>
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