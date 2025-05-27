<?php include 'app/views/shares/header.php'; ?>
<div class="container my-5">
    <h1 class="text-center mb-4">Thanh Toán</h1>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <form method="POST" action="/Webbanhang/Product/processCheckout">
                        <div class="mb-3">
                            <label for="name" class="form-label">Họ Tên:</label>
                            <input type="text" id="name" name="name" class="form-control" placeholder="Nhập họ và tên" required>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Số Điện Thoại:</label>
                            <input type="text" id="phone" name="phone" class="form-control" placeholder="Nhập số điện thoại" required>
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Địa Chỉ:</label>
                            <textarea id="address" name="address" class="form-control" rows="4" placeholder="Nhập địa chỉ giao hàng" required></textarea>
                        </div>
                        <div class="d-flex justify-content-between">
                            <a href="/Webbanhang/Product/cart" class="btn btn-outline-secondary">Quay Lại Giỏ Hàng</a>
                            <button type="submit" class="btn btn-primary">Thanh Toán</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include 'app/views/shares/footer.php'; ?>