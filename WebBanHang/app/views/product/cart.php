<?php include 'app/views/shares/header.php'; ?>
<div class="container my-5">
    <h1 class="text-center mb-4">Giỏ Hàng Của Bạn</h1>
    
    <?php if (!empty($cart)): ?>
    <div class="row">
        <?php foreach ($cart as $id => $item): ?>
        <div class="col-12 mb-3">
            <div class="card shadow-sm">
                <div class="row g-0">
                    <div class="col-md-2 d-flex align-items-center justify-content-center">
                        <?php if ($item['image']): ?>
                        <img src="/Webbanhang/<?php echo htmlspecialchars($item['image'], ENT_QUOTES, 'UTF-8'); ?>" alt="Product Image" class="img-fluid" style="max-width: 100px;">
                        <?php else: ?>
                        <img src="/Webbanhang/assets/placeholder.png" alt="Placeholder Image" class="img-fluid" style="max-width: 100px;">
                        <?php endif; ?>
                    </div>
                    <div class="col-md-7">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8'); ?></h5>
                            <p class="card-text mb-1">Giá: <?php echo number_format(htmlspecialchars($item['price'], ENT_QUOTES, 'UTF-8'), 0, ',', '.') ?> VND</p>
                            <p class="card-text">Số lượng: <?php echo htmlspecialchars($item['quantity'], ENT_QUOTES, 'UTF-8'); ?></p>
                        </div>
                    </div>
                    <div class="col-md-3 d-flex align-items-center">
                        <a href="/Webbanhang/Product/remove/<?php echo $id; ?>" class="btn btn-outline-danger btn-sm">Xóa</a>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <div class="text-end mt-4">
        <a href="/Webbanhang/Product" class="btn btn-outline-secondary me-2">Tiếp Tục Mua Sắm</a>
        <a href="/Webbanhang/Product/checkout" class="btn btn-primary">Thanh Toán</a>
    </div>
    <?php else: ?>
    <div class="alert alert-info text-center" role="alert">
        Giỏ hàng của bạn đang trống.
    </div>
    <div class="text-center">
        <a href="/Webbanhang/Product" class="btn btn-outline-secondary">Tiếp Tục Mua Sắm</a>
    </div>
    <?php endif; ?>
</div>
<?php include 'app/views/shares/footer.php'; ?>