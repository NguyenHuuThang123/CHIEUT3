<?php include 'app/views/shares/header.php'; ?>
<div class="container my-5">
    <h1 class="text-center mb-4">Giỏ Hàng Của Bạn</h1>
    
    <?php if (!empty($cart)): ?>
    <div class="row">
        <?php foreach ($cart as $id => $item): ?>
        <div class="col-12 mb-3">
            <div class="card shadow-sm" data-product-id="<?php echo htmlspecialchars($id, ENT_QUOTES, 'UTF-8'); ?>">
                <div class="row g-0 align-items-center">
                    <div class="col-md-2 d-flex align-items-center justify-content-center p-3">
                        <img src="/Webbanhang/<?php echo htmlspecialchars($item['image'] ?: 'assets/placeholder.png', ENT_QUOTES, 'UTF-8'); ?>"
                             alt="<?php echo htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8'); ?>"
                             class="img-fluid rounded" style="max-width: 100px;">
                    </div>
                    <div class="col-md-7">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8'); ?></h5>
                            <p class="card-text mb-1">
                                Đơn giá: <?php echo number_format($item['price'], 0, ',', '.'); ?> VND
                            </p>
                            <p class="card-text mb-1 fw-medium text-primary">
                                Tổng: <span class="item-total" data-unit-price="<?php echo htmlspecialchars($item['price'], ENT_QUOTES, 'UTF-8'); ?>">
                                    <?php echo number_format($item['price'] * $item['quantity'], 0, ',', '.'); ?> VND
                                </span>
                            </p>
                            <div class="d-flex align-items-center">
                                <label for="quantity-<?php echo $id; ?>" class="form-label me-2 mb-0">Số lượng:</label>
                                <div class="input-group w-50" style="max-width: 150px;">
                                    <button type="button" class="btn btn-outline-secondary decrease-quantity">
                                        <i class="bi bi-dash"></i>
                                    </button>
                                    <input type="number" id="quantity-<?php echo $id; ?>" class="form-control text-center quantity-input"
                                           value="<?php echo htmlspecialchars($item['quantity'], ENT_QUOTES, 'UTF-8'); ?>"
                                           data-product-id="<?php echo $id; ?>" data-price="<?php echo htmlspecialchars($item['price'], ENT_QUOTES, 'UTF-8'); ?>"
                                           min="1" step="1" required>
                                    <button type="button" class="btn btn-outline-secondary increase-quantity">
                                        <i class="bi bi-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 d-flex align-items-center justify-content-center">
                        <a href="/Webbanhang/Product/clearcart/<?php echo $id; ?>" class="btn btn-outline-danger btn-sm">
                            <i class="bi bi-trash me-1"></i>Xóa
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
        <div class="col-12 text-end mt-3">
            <h4>Tổng cộng: <span id="cart-total" aria-live="polite"><?php echo number_format(array_sum(array_map(function($item) { return ($item['price'] ?? 0) * ($item['quantity'] ?? 1); }, $cart)), 0, ',', '.'); ?> VND</span></h4>
        </div>

    </div>
    <div class="col-md-3 d-flex align-items-center justify-content-center">
                        <a href="/Webbanhang/Product/clearcart/<?php echo $id; ?>" class="btn btn-outline-danger btn-sm">
                            <i class="bi bi-trash me-1"></i>Xóa giỏ hàng
                        </a>
                    </div>
    <div class="text-end mt-4">
        <a href="/Webbanhang" class="btn btn-outline-secondary me-2">Tiếp Tục Mua Sắm</a>
        <a href="/Webbanhang/Product/checkout" class="btn btn-primary">Thanh Toán</a>
    </div>
    <?php else: ?>
    <div class="alert alert-info text-center" role="alert">
        Giỏ hàng của bạn đang trống.
    </div>
    <div class="text-center">
        <a href="/Webbanhang" class="btn btn-outline-secondary">Tiếp Tục Mua Sắm</a>
    </div>
    <?php endif; ?>

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

<script>
// Debounce function to limit rapid AJAX calls
function debounce(func, wait) {
    let timeout;
    return function (...args) {
        clearTimeout(timeout);
        timeout = setTimeout(() => func.apply(this, args), wait);
    };
}

document.addEventListener('DOMContentLoaded', () => {
    const updateCartTotal = () => {
        const total = Array.from(document.querySelectorAll('.quantity-input')).reduce((sum, input) => {
            const unitPrice = parseFloat(input.getAttribute('data-price')) || 0;
            const quantity = parseInt(input.value) || 1;
            if (isNaN(unitPrice) || isNaN(quantity)) {
                console.warn(`Invalid price or quantity: price=${unitPrice}, quantity=${quantity}`);
                return sum;
            }
            return sum + unitPrice * quantity;
        }, 0);
        const cartTotalElement = document.getElementById('cart-total');
        cartTotalElement.textContent = new Intl.NumberFormat('vi-VN').format(total) + ' VND';
        // Toggle checkout button visibility
        const checkoutButton = document.getElementById('checkout-button');
        checkoutButton.style.display = total === 0 ? 'none' : 'inline-block';
    };

    const updateItemTotal = (input) => {
        const unitPrice = parseFloat(input.getAttribute('data-price')) || 0;
        const quantity = parseInt(input.value) || 1;
        const totalElement = input.closest('.card-body').querySelector('.item-total');
        totalElement.textContent = new Intl.NumberFormat('vi-VN').format(unitPrice * quantity) + ' VND';
        updateCartTotal();
    };

    // Debounced function for updating cart quantity
    const debouncedUpdateCartQuantity = debounce((input, quantity) => {
        const productId = input.getAttribute('data-product-id');
        const toast = new bootstrap.Toast(document.getElementById('cartToast'));
        const toastBody = document.querySelector('#cartToast .toast-body');

        fetch('/Webbanhang/Product/updateCart/' + productId, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]')?.content || ''
            },
            body: JSON.stringify({ productId: productId, quantity: quantity })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                toastBody.textContent = 'Cập nhật số lượng thành công!';
                document.getElementById('cart-total').textContent = 
                    new Intl.NumberFormat('vi-VN').format(data.totalPrice ?? 0) + ' VND';
            } else {
                toastBody.textContent = data.message || 'Có lỗi khi cập nhật số lượng.';
                input.value = data.quantity || 1;
                updateItemTotal(input);
            }
            toast.show();
        })
        .catch(error => {
            console.error('Error:', error);
            toastBody.textContent = 'Đã xảy ra lỗi khi cập nhật số lượng.';
            input.value = 1;
            updateItemTotal(input);
            toast.show();
        });
    }, 500);

    // Handle product removal
    document.querySelectorAll('.remove-item').forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.getAttribute('data-product-id');
            const toast = new bootstrap.Toast(document.getElementById('cartToast'));
            const toastBody = document.querySelector('#cartToast .toast-body');

            fetch('/Webbanhang/Product/clearcart/' + productId, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]')?.content || ''
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    toastBody.textContent = 'Xóa sản phẩm thành công!';
                    const itemElement = document.querySelector(`.cart-item[data-product-id="${productId}"]`);
                    if (itemElement) {
                        itemElement.remove();
                        updateCartTotal();
                        // Show empty cart message if no items remain
                        if (!document.querySelectorAll('.cart-item').length) {
                            const cartItems = document.getElementById('cart-items');
                            cartItems.outerHTML = `
                                <div class="alert alert-info text-center" role="alert">
                                    Giỏ hàng của bạn đang trống.
                                </div>
                                <div class="text-center">
                                    <a href="/Webbanhang/Product/list" class="btn btn-outline-secondary">Tiếp Tục Mua Sắm</a>
                                </div>
                            `;
                        }
                    }
                } else {
                    toastBody.textContent = data.message || 'Có lỗi khi xóa sản phẩm.';
                }
                toast.show();
            })
            .catch(error => {
                console.error('Error:', error);
                toastBody.textContent = 'Đã xảy ra lỗi khi xóa sản phẩm.';
                toast.show();
            });
        });
    });

    document.querySelectorAll('.quantity-input').forEach(input => {
        input.addEventListener('input', function() {
            let quantity = parseInt(this.value);
            if (isNaN(quantity) || quantity < 1) {
                quantity = 1;
                this.value = 1;
            }
            updateItemTotal(this);
            debouncedUpdateCartQuantity(this, quantity);
        });
    });

    document.querySelectorAll('.decrease-quantity').forEach(button => {
        button.addEventListener('click', function() {
            const input = this.closest('.input-group').querySelector('.quantity-input');
            let quantity = parseInt(input.value) || 1;
            if (quantity > 1) {
                quantity--;
                input.value = quantity;
                updateItemTotal(input);
                debouncedUpdateCartQuantity(input, quantity);
            }
        });
    });

    document.querySelectorAll('.increase-quantity').forEach(button => {
        button.addEventListener('click', function() {
            const input = this.closest('.input-group').querySelector('.quantity-input');
            let quantity = parseInt(input.value) || 1;
            quantity++;
            input.value = quantity;
            updateItemTotal(input);
            debouncedUpdateCartQuantity(input, quantity);
        });
    });
});
</script>


<?php include 'app/views/shares/footer.php'; ?>