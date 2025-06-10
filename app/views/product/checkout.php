<?php include 'app/views/shares/header.php'; ?>
<div class="container my-5">
    <h1 class="text-center mb-4">Thanh Toán</h1>
    
    <?php
    // Calculate cart total
    $cart = $_SESSION['cart'] ?? [];
    $totalPrice = 0;
    foreach ($cart as $item) {
        $price = floatval($item['price'] ?? 0);
        $quantity = intval($item['quantity'] ?? 1);
        $totalPrice += $price * $quantity;
    }
    ?>

    <?php if (!empty($cart)): ?>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <!-- Display Cart Total -->
                    <div class="mb-4 text-center">
                        <h4>Tổng Thanh Toán: <span id="cart-total" aria-live="polite"><?php echo number_format($totalPrice, 0, ',', '.'); ?> VND</span></h4>
                    </div>
                    
                    <form method="POST" action="/webbanhang/Product/processCheckout">
                        <div class="mb-3">
                            <label for="name" class="form-label">Họ Tên:</label>
                            <input type="text" id="name" name="name" class="form-control" placeholder="Nhập họ và tên" required>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Số Điện Thoại:</label>
                            <input type="tel" id="phone" name="phone" class="form-control" placeholder="Nhập số điện thoại" pattern="[0-9]{10}" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email:</label>
                            <input type="email" id="email" name="email" class="form-control" placeholder="Nhập địa chỉ email" required>
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Địa Chỉ:</label>
                            <textarea id="address" name="address" class="form-control" rows="4" placeholder="Nhập địa chỉ giao hàng" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="paymentMethod" class="form-label">Phương Thức Thanh Toán:</label>
                            <select id="paymentMethod" name="paymentMethod" class="form-select" required>
                                <option value="" disabled selected>Chọn phương thức thanh toán</option>
                                <option value="cod">Thanh toán khi nhận hàng (COD)</option>
                                <option value="bank_card">Thẻ ngân hàng</option>
                                <option value="mobile_app">Ứng dụng di động (Momo, ZaloPay, v.v.)</option>
                                <option value="bank_transfer">Chuyển khoản ngân hàng</option>
                            </select>
                        </div>
                        <div class="d-flex justify-content-between">
                            <a href="/webbanhang/Product/cart" class="btn btn-outline-secondary">Quay Lại Giỏ Hàng</a>
                            <button type="submit" class="btn btn-primary">Thanh Toán</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php else: ?>
    <div class="alert alert-info text-center" role="alert">
        Giỏ hàng của bạn đang trống. Vui lòng thêm sản phẩm trước khi thanh toán.
    </div>
    <div class="text-center">
        <a href="/webbanhang/Product/list" class="btn btn-outline-secondary">Tiếp Tục Mua Sắm</a>
    </div>
    <?php endif; ?>
</div>
<?php include 'app/views/shares/footer.php'; ?>