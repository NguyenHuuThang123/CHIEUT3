<?php include 'app/views/shares/header.php'; ?>
<section class="py-5 bg-light">
    <div class="container">
        <h4 class="fw-bold mb-4 text-center">Kết quả tìm kiếm cho: <span
                class="text-primary"><?php echo htmlspecialchars($query); ?></span></h4>
        <?php if (empty($products)): ?>
        <div class="alert alert-info text-center" role="alert">
            Không tìm thấy sản phẩm nào.
        </div>
        <?php else: ?>
        <div class="row g-4">
            <?php foreach ($products as $product): ?>
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <div class="card h-100 shadow-sm border-0"
                    style="border-radius: 1rem; transition: transform 0.3s ease, box-shadow 0.3s ease;">
                    <div class="card-img-top text-center p-3">
                        <img src="/webbanhang/<?php echo htmlspecialchars($product->image ?: 'images/no-image.png', ENT_QUOTES, 'UTF-8'); ?>"
                            alt="<?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?>"
                            class="img-fluid rounded" style="max-height: 200px; object-fit: contain;">
                    </div>
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title fw-bold text-dark"><?php echo htmlspecialchars($product->name); ?></h5>
                        <p class="card-text text-muted flex-grow-1">
                            <?php echo htmlspecialchars($product->description); ?></p>
                        <p class="card-text text-danger fw-bold"><?php echo number_format($product->price); ?> đ</p>
                        <a href="/WebBanHang/Product/detail/<?php echo $product->id; ?>"
                            class="btn btn-primary btn-sm mt-auto" style="border-radius: 0.5rem;">Xem chi tiết</a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</section>
<style>
body {
    background: #f0f2f5;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15) !important;
}

.card-img-top {
    transition: transform 0.3s ease;
}

.card:hover .card-img-top {
    transform: scale(1.05);
}

.btn-primary {
    background: #1e90ff;
    border: none;
    transition: background 0.3s ease;
}

.btn-primary:hover {
    background: #187cdb;
}

.alert-info {
    border-radius: 0.5rem;
    background: rgba(13, 110, 253, 0.1);
    border: none;
    color: #0d6efd;
}
</style>
<?php include 'app/views/shares/footer.php'; ?>