<?php include 'app/views/shares/header.php'; ?>

<div class="container my-5">
    <!-- Banner -->
    <div class="position-relative mb-5">
        <img src="/webbanhang/images/banner2.jpg" alt="Giới thiệu" class="img-fluid rounded-3 shadow-lg"
            style="width: 100%; height: 400px; object-fit: cover;">
        <div class="position-absolute top-50 start-50 translate-middle text-center text-white">

        </div>
    </div>

    <!-- Sắp xếp theo giá -->
    <form method="get" class="mb-4 text-end">
        <label for="sort_price" class="me-2 fw-bold">Sắp xếp theo giá:</label>
        <select name="sort_price" id="sort_price" onchange="this.form.submit()"
            class="form-select d-inline-block w-auto">
            <option value="">Mặc định</option>
            <option value="asc" <?php if (($_GET['sort_price'] ?? '') === 'asc') echo 'selected'; ?>>Thấp đến cao
            </option>
            <option value="desc" <?php if (($_GET['sort_price'] ?? '') === 'desc') echo 'selected'; ?>>Cao đến thấp
            </option>
        </select>
    </form>
    <!-- Featured Products -->
    <h2 class="mb-4 text-center fw-bold">Sản Phẩm Nổi Bật</h2>
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
                    <img src="/webbanhang/<?php echo htmlspecialchars($product->image ?: 'images/no-image.png', ENT_QUOTES, 'UTF-8'); ?>"
                        alt="<?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?>"
                        class="img-fluid rounded" style="max-height: 200px; object-fit: contain;">
                </div>
                <div class="card-body">
                    <h5 class="card-title">
                        <a href="/webbanhang/Product/show/<?php echo htmlspecialchars($product->id, ENT_QUOTES, 'UTF-8'); ?>"
                            class="text-decoration-none text-primary">
                            <?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?>
                        </a>
                    </h5>
                    <p class="card-text text-muted" style="min-height: 60px;">
                        <?php echo htmlspecialchars(substr($product->description, 0, 100) . (strlen($product->description) > 100 ? '...' : ''), ENT_QUOTES, 'UTF-8'); ?>
                    </p>
                    <p class="card-text fw-bold text-danger">
                        <?php echo number_format($product->price, 0, ',', '.') . ' VND'; ?>
                    </p>
                    <p class="card-text text-secondary">
                        Danh mục: <?php echo htmlspecialchars($product->category_name, ENT_QUOTES, 'UTF-8'); ?>
                    </p>
                </div>
                <div class="card-footer bg-white border-0 pb-3">
                    <div class="d-flex justify-content-between">
                        <a href="/webbanhang/Product/addToCart/<?php echo $product->id; ?>" class="btn btn-primary">Thêm
                            vào giỏ hàng</a>
                        <div class="d-flex gap-2">
                            <a href="/webbanhang/Product/show/<?php echo htmlspecialchars($product->id, ENT_QUOTES, 'UTF-8'); ?>"
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

    <!-- Toast Container -->
    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="cartToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <i class="bi bi-cart-check me-2"></i>
                <strong class="me-auto">Thông Báo</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body"></div>
        </div>
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

<script>
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.add-to-cart').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault(); // Prevent navigation or reload
            const productId = this.getAttribute('data-product-id');
            const originalText = this.innerHTML;
            this.innerHTML = '<i class="bi bi-arrow-clockwise me-1"></i>Đang thêm...';
            this.disabled = true;

            fetch('/webbanhang/Product/addToCart/' + productId, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]')
                            ?.content || ''
                    }
                })
                .then(response => response.json())
                .then(data => {
                    const toast = new bootstrap.Toast(document.getElementById('cartToast'));
                    const toastBody = document.querySelector('#cartToast .toast-body');

                    if (data.success) {
                        toastBody.textContent = 'Sản phẩm đã được thêm vào giỏ hàng!';
                        document.getElementById('cart-count')?.textContent = data
                            .cartCount || '0';
                    } else {
                        toastBody.textContent = data.message ||
                            'Có lỗi xảy ra. Vui lòng thử lại.';
                    }

                    toast.show();
                    this.innerHTML = originalText;
                    this.disabled = false;
                })
                .catch(error => {
                    console.error('Error:', error);
                    const toast = new bootstrap.Toast(document.getElementById('cartToast'));
                    document.querySelector('#cartToast .toast-body').textContent =
                        'Đã xảy ra lỗi khi thêm sản phẩm.';
                    toast.show();
                    this.innerHTML = originalText;
                    this.disabled = false;
                });
        });
    });
});
</script>

<?php include 'app/views/shares/footer.php'; ?>