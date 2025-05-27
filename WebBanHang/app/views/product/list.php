<?php include 'app/views/shares/header.php'; ?>
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">Danh sách sản phẩm</h1>
        <a href="/WebBanHang/Product/add" class="btn btn-success">Thêm sản phẩm mới</a>
    </div>
    <div class="table-responsive">
        <table class="table table-hover table-bordered align-middle">
            <thead class="table-primary">
                <tr>
                    <th scope="col">Hình ảnh</th>
                    <th scope="col">Tên sản phẩm</th>
                    <th scope="col">Mô tả</th>
                    <th scope="col">Giá (VND)</th>
                    <th scope="col">Danh mục</th>
                    <th scope="col">Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($products)): ?>
                <tr>
                    <td colspan="6" class="text-center">Không có sản phẩm nào.</td>
                </tr>
                <?php else: ?>
                <?php foreach ($products as $product): ?>
                <tr>
                    <td>
                        <?php if ($product->image): ?>
                        <img src="/webbanhang/<?php echo $product->image; ?>" alt="Product Image"
                            style="max-width: 100px;">
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="/WebBanHang/Product/show/<?php echo $product->id; ?>"
                            class="text-decoration-none text-primary">
                            <?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?>
                        </a>
                    </td>
                    <td><?php echo htmlspecialchars($product->description, ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo number_format(htmlspecialchars($product->price, ENT_QUOTES, 'UTF-8'), 2); ?></td>
                    <td><?php echo htmlspecialchars($product->category_name, ENT_QUOTES, 'UTF-8'); ?></td>
                    <td>
                        <div class="d-flex gap-2">
                            <a href="/WebBanHang/Product/show/<?php echo $product->id; ?>"
                                class="btn btn-primary btn-sm">Xem</a>
                            <a href="/WebBanHang/Product/edit/<?php echo $product->id; ?>"
                                class="btn btn-warning btn-sm">Sửa</a>
                            <a href="/WebBanHang/Product/delete/<?php echo $product->id; ?>"
                                class="btn btn-danger btn-sm"
                                onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');">Xóa</a>
                            <a href="/webbanhang/Product/addToCart/<?php echo $product->id; ?>"
                                class="btn btn-primary">Thêm vào giỏ hàng</a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Bootstrap 5 CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<!-- Bootstrap 5 JS (for confirmation dialog) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
</script>
<style>
.table {
    border-radius: 10px;
    overflow: hidden;
}

.table th,
.table td {
    padding: 12px;
}

.table-primary {
    background-color: #0d6efd;
    color: white;
}

.table-hover tbody tr:hover {
    background-color: rgba(13, 110, 253, 0.1);
}

.text-primary {
    font-weight: 500;
}

.text-primary:hover {
    color: #005cbf;
}

.btn-sm {
    border-radius: 8px;
    padding: 6px 12px;
}

.img-thumbnail {
    border-radius: 8px;
}
</style>
<?php include 'app/views/shares/footer.php'; ?>