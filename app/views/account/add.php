<?php include 'app/views/shares/header.php'; ?>

<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-primary text-white text-center py-3">
                    <h3 class="mb-0">Thêm người dùng mới</h3>
                </div>
                <div class="card-body p-4">
                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?php echo htmlspecialchars($error); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>
                    <form action="/webbanhang/account/processAddUser" method="POST" id="addUserForm" onsubmit="return validateForm()">
                        <div class="mb-3">
                            <label for="username" class="form-label fw-bold">Tên đăng nhập <span class="text-danger">*</span></label>
                            <div class="input-group" data-bs-toggle="tooltip" title="Tên đăng nhập phải từ 3-50 ký tự">
                                <span class="input-group-text bg-light"><i class="bi bi-person"></i></span>
                                <input type="text" class="form-control" id="username" name="username" placeholder="Nhập tên đăng nhập" value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>" required minlength="3" maxlength="50">
                            </div>
                            <?php if (isset($errors['username'])): ?>
                                <small class="text-danger"><?php echo htmlspecialchars($errors['username']); ?></small>
                            <?php endif; ?>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label fw-bold">Mật khẩu <span class="text-danger">*</span></label>
                            <div class="input-group" data-bs-toggle="tooltip" title="Mật khẩu phải từ 6-20 ký tự">
                                <span class="input-group-text bg-light"><i class="bi bi-lock"></i></span>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Nhập mật khẩu" required minlength="6" maxlength="20">
                            </div>
                            <?php if (isset($errors['password'])): ?>
                                <small class="text-danger"><?php echo htmlspecialchars($errors['password']); ?></small>
                            <?php endif; ?>
                        </div>
                        <div class="mb-3">
                            <label for="confirm_password" class="form-label fw-bold">Xác nhận mật khẩu <span class="text-danger">*</span></label>
                            <div class="input-group" data-bs-toggle="tooltip" title="Xác nhận mật khẩu phải khớp với mật khẩu">
                                <span class="input-group-text bg-light"><i class="bi bi-lock-fill"></i></span>
                                <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Xác nhận mật khẩu" required>
                            </div>
                            <?php if (isset($errors['confirm_password'])): ?>
                                <small class="text-danger"><?php echo htmlspecialchars($errors['confirm_password']); ?></small>
                            <?php endif; ?>
                        </div>
                        <div class="mb-3">
                            <label for="role" class="form-label fw-bold">Vai trò <span class="text-danger">*</span></label>
                            <div class="input-group" data-bs-toggle="tooltip" title="Chọn vai trò cho người dùng">
                                <span class="input-group-text bg-light"><i class="bi bi-shield-check"></i></span>
                                <select class="form-select" id="role" name="role" required>
                                    <option value="user" <?php echo (isset($_POST['role']) && $_POST['role'] == 'user') ? 'selected' : ''; ?>>User</option>
                                    <option value="admin" <?php echo (isset($_POST['role']) && $_POST['role'] == 'admin') ? 'selected' : ''; ?>>Admin</option>
                                </select>
                            </div>
                            <?php if (isset($errors['role'])): ?>
                                <small class="text-danger"><?php echo htmlspecialchars($errors['role']); ?></small>
                            <?php endif; ?>
                        </div>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary w-50">Thêm người dùng</button>
                            <a href="/webbanhang/account/listUsers" class="btn btn-secondary w-50">Hủy</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.card {
    border-radius: 10px;
}
.card-header {
    border-top-left-radius: 10px;
    border-top-right-radius: 10px;
}
.form-control, .form-select {
    border-radius: 0.375rem;
    transition: border-color 0.3s ease;
}
.form-control:focus, .form-select:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 5px rgba(13, 110, 253, 0.2);
}
.input-group-text {
    border-right: 0;
    background-color: #f8f9fa;
}
.btn-primary, .btn-secondary {
    transition: background-color 0.3s ease;
}
.btn-primary:hover {
    background-color: #0b5ed7;
}
.btn-secondary:hover {
    background-color: #5c636a;
}
.text-danger {
    font-size: 0.875rem;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Khởi tạo tooltip
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});

function validateForm() {
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirm_password').value;

    if (password !== confirmPassword) {
        alert('Mật khẩu và xác nhận mật khẩu không khớp!');
        return false;
    }
    return true;
}
</script>

<?php include 'app/views/shares/footer.php'; ?>