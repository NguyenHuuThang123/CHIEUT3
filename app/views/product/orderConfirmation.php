<?php include 'app/views/shares/header.php'; ?>

<div class="container mt-5">
    <h1 class="text-center mb-4">Xác nhận đơn hàng</h1>
    
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <div class="mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="#28a745" class="bi bi-check-circle" viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                            <path d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z"/>
                        </svg>
                    </div>
                    <h3 class="card-title text-success">Đặt hàng thành công!</h3>
                    <p class="card-text">Cảm ơn bạn đã đặt hàng. Đơn hàng của bạn đã được xử lý thành công.</p>
                    
                    <hr>
                    
                    <div class="text-start">
                        <h5>Thông tin đơn hàng</h5>
                        <ul class="list-unstyled">
                            <li><strong>Số đơn hàng:</strong> #<?php echo isset($_SESSION['last_order_id']) ? htmlspecialchars($_SESSION['last_order_id']) : 'N/A'; ?></li>
                            <li><strong>Ngày đặt hàng:</strong> <?php echo date('d/m/Y H:i:s'); // Ngày hiện tại ?></li>
                            <li><strong>Phương thức thanh toán:</strong> <?php echo isset($_SESSION['last_payment_method']) ? htmlspecialchars($_SESSION['last_payment_method']) : 'Chưa xác định'; ?></li>
                            <li><strong>Tổng tiền:</strong> <?php echo isset($_SESSION['last_order_total']) ? number_format($_SESSION['last_order_total'], 0, ',', '.') . ' VNĐ' : 'N/A'; ?></li>
                        </ul>
                    </div>
                    
                    <div class="mt-4">
                        <a href="/Webbanhang/Product/list" class="btn btn-primary me-2">Tiếp tục mua sắm</a>
                        <a href="/Webbanhang/Product/orderDetails/<?php echo isset($_SESSION['last_order_id']) ? htmlspecialchars($_SESSION['last_order_id']) : '#'; ?>" class="btn btn-outline-secondary">Xem chi tiết đơn hàng</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'app/views/shares/footer.php'; ?>