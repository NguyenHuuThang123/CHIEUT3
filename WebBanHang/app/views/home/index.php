<?php include 'app/views/shares/header.php'; ?>

<div class="container mt-4">
    <!-- Banner giới thiệu -->
    <div class="position-relative mb-5">
        <img src="/webbanhang/images/banner2.jpg" alt="Giới thiệu" class="img-fluid rounded-3 shadow-lg"
            style="width: 100%; height: 400px; object-fit: cover;">
        <div class="position-absolute top-50 start-50 translate-middle text-center text-white">
        </div>
    </div>

    <!-- Danh sách sản phẩm nổi bật -->
    <h2 class="mb-4 text-center fw-bold">Sản phẩm nổi bật</h2>
    <div class="row g-4">
        <?php if (empty($products)): ?>
        <div class="col-12">
            <div class="alert alert-info text-center">
                <p class="mb-0">Không có sản phẩm nào.</p>
                <a href="/webbanhang/Product/add" class="btn btn-primary mt-2">Thêm sản phẩm mới</a>
            </div>
        </div>
        <?php else: ?>
        <?php foreach ($products as $product): ?>
        <div class="col-md-4 col-sm-6">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-img-top text-center p-3">
                    <?php if ($product->image): ?>
                    <img src="/webbanhang/<?php echo htmlspecialchars($product->image, ENT_QUOTES, 'UTF-8'); ?>"
                        alt="<?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?>"
                        class="img-fluid rounded" style="max-height: 200px; object-fit: contain;">
                    <?php else: ?>
                    <img src="/webbanhang/images/no-image.png" alt="No Image" class="img-fluid rounded"
                        style="max-height: 200px; object-fit: contain;">
                    <?php endif; ?>
                </div>
                <div class="card-body">
                    <h5 class="card-title">
                        <a href="/webbanhang/Product/show/<?php echo $product->id; ?>"
                            class="text-decoration-none text-primary">
                            <?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?>
                        </a>
                    </h5>
                    <p class="card-text text-muted" style="min-height: 60px;">
                        <?php echo htmlspecialchars(substr($product->description, 0, 100) . (strlen($product->description) > 100 ? '...' : ''), ENT_QUOTES, 'UTF-8'); ?>
                    </p>
                    <p class="card-text fw-bold text-danger">
                        <?php echo number_format(htmlspecialchars($product->price, ENT_QUOTES, 'UTF-8'), 0, ',', '.') . ' VND'; ?>
                    </p>
                    <p class="card-text text-secondary">
                        Danh mục: <?php echo htmlspecialchars($product->category_name, ENT_QUOTES, 'UTF-8'); ?>
                    </p>
                </div>
                <div class="card-footer bg-white border-0 pb-3">
                    <div class="d-flex justify-content-between">
                        <a href="#" class="btn btn-success btn-sm add-to-cart"
                            data-product-id="<?php echo htmlspecialchars($product->id, ENT_QUOTES, 'UTF-8'); ?>">
                            <i class="bi bi-cart-plus me-1"></i>Thêm vào giỏ
                        </a>
                        <div class="d-flex gap-2">
                            <a href="/webbanhang/Product/show/<?php echo $product->id; ?>"
                                class="btn btn-primary btn-sm">
                                <i class="bi bi-eye-fill me-1"></i>Xem
                            </a>


                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<style>
.card {
    border-radius: 10px;
    transition: transform 0.3s, box-shadow 0.3s;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
}

.card-img-top img {
    transition: transform 0.3s;
}

.card-img-top img:hover {
    transform: scale(1.05);
}

.btn-sm {
    padding: 6px 12px;
    border-radius: 8px;
    transition: background-color 0.3s;
}

.text-primary:hover {
    color: #0056b3 !important;
}
</style>

<?php include 'app/views/shares/footer.php'; ?>