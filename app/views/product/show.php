<?php include 'app/views/shares/header.php'; ?>
<div class="container mt-5 mb-5">
    <div class="card shadow-lg border-0" style="border-radius: 15px; overflow: hidden;">
        <div class="card-header bg-primary text-white text-center py-4">
            <h2 class="mb-0 fw-bold">Chi tiết sản phẩm</h2>
        </div>
        <div class="card-body p-4">
            <?php if ($product): ?>
            <div class="row g-4">
                <!-- Product Image -->
                <div class="col-md-6">
                    <?php if ($product->image): ?>
                    <img src="/webbanhang/<?php echo
                        htmlspecialchars($product->image, ENT_QUOTES, 'UTF-8'); ?>"
                    class="img-fluid rounded" alt="<?php echo
                        htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?>">
                    <?php else: ?>
                    <img src="/webbanhang/images/no-image.png"
                    class="img-fluid rounded" alt="Không có ảnh">
                    <?php endif; ?>
                </div>
                <!-- Product Details -->
                <div class="col-12 col-lg-6 d-flex flex-column justify-content-center">
                    <h3 class="fw-bold text-dark mb-3"><?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?></h3>
                    <p class="text-muted mb-4"><?php echo nl2br(htmlspecialchars($product->description, ENT_QUOTES, 'UTF-8')); ?></p>
                    <p class="text-danger fw-bold fs-4 mb-3">
                        <i class="bi bi-currency-dollar me-1"></i><?php echo number_format($product->price, 0, ',', '.'); ?> VND
                    </p>
                    <p class="mb-4">
                        <strong>Danh mục:</strong> 
                        <span class="badge bg-info text-dark">
                            <?php echo !empty($product->category_name) ? htmlspecialchars($product->category_name, ENT_QUOTES, 'UTF-8') : 'Chưa có danh mục'; ?>
                        </span>
                    </p>
                    <div class="d-flex gap-3">
                        <a href="/WebBanHang/Product/addToCart/<?php echo $product->id; ?>" 
                           class="btn btn-success px-4 py-2 fw-semibold">
                            <i class="bi bi-cart-plus me-2"></i>Thêm vào giỏ hàng
                        </a>
                        <a href="/WebBanHang/Product/list" 
                           class="btn btn-outline-secondary px-4 py-2 fw-semibold">
                            <i class="bi bi-arrow-left me-2"></i>Quay lại danh sách
                        </a>
                    </div>
                </div>
            </div>
            <?php else: ?>
            <div class="alert alert-danger text-center py-4">
                <h4 class="mb-0">Không tìm thấy sản phẩm!</h4>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Bootstrap 5 CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<style>
    .card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15) !important;
    }
    .card-header {
        border-radius: 15px 15px 0 0;
    }
    .image-container img {
        border-radius: 10px;
        transition: transform 0.3s ease;
    }
    .image-container img:hover {
        transform: scale(1.05);
    }
    .btn-success, .btn-outline-secondary {
        border-radius: 8px;
        transition: background-color 0.3s ease, transform 0.2s ease;
    }
    .btn-success:hover {
        background-color: #28a745;
        transform: translateY(-2px);
    }
    .btn-outline-secondary:hover {
        background-color: #f8f9fa;
        transform: translateY(-2px);
    }
    .badge {
        font-size: 0.9rem;
        padding: 0.5em 1em;
    }
    @media (max-width: 767px) {
        .image-container img {
            max-height: 300px;
        }
    }
</style>
<?php include 'app/views/shares/footer.php'; ?>