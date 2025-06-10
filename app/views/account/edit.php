<?php include 'app/views/shares/header.php'; ?>

<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-primary text-white text-center py-3">
                    <h3 class="mb-0">Sửa thông tin người dùng</h3>
                </div>
                <div class="card-body p-4">
                    <?php if (isset($error)): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?php echo htmlspecialchars($error); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php endif; ?>
                    <form action="/webbanhang/account/processEditUser/<?php echo htmlspecialchars($user->id); ?>"
                        method="POST">
                        <div class="mb-3">
                            <label for="username" class="form-label fw-bold">Tên đăng nhập <span
                                    class="text-danger">*</span></label>
                            <div class="input-group" data-bs-toggle="tooltip" title="Tên đăng nhập phải từ 3-50 ký tự">
                                <span class="input-group-text bg-light"><i class="bi bi-person"></i></span>
                                <input type="text" class="form-control" id="username" name="username"
                                    placeholder="Nhập tên đăng nhập"
                                    value="<?php echo htmlspecialchars($user->username); ?>" required minlength="3"
                                    maxlength="50">
                            </div>
                            <?php if (!empty($errors['username'])): ?>
                            <small class="text-danger"><?php echo htmlspecialchars($errors['username']); ?></small>
                            <?php endif; ?>
                        </div>
                        <div class="mb-3">
                            <label for="fullname" class="form-label fw-bold">Họ và tên <span
                                    class="text-danger">*</span></label>
                            <div class="input-group" data-bs-toggle="tooltip" title="Nhập họ và tên đầy đủ">
                                <span class="input-group-text bg-light"><i class="bi bi-person-fill"></i></span>
                                <input type="text" class="form-control" id="fullname" name="fullname"
                                    placeholder="Nhập họ và tên"
                                    value="<?php echo htmlspecialchars($user->fullname); ?>" required>
                            </div>
                            <?php if (!empty($errors['fullname'])): ?>
                            <small class="text-danger"><?php echo htmlspecialchars($errors['fullname']); ?></small>
                            <?php endif; ?>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label fw-bold">Email <span
                                    class="text-danger">*</span></label>
                            <div class="input-group" data-bs-toggle="tooltip" title="Nhập địa chỉ email hợp lệ">
                                <span class="input-group-text bg-light"><i class="bi bi-envelope"></i></span>
                                <input type="email" class="form-control" id="email" name="email"
                                    placeholder="Nhập email" value="<?php echo htmlspecialchars($user->email); ?>"
                                    required>
                            </div>
                            <?php if (!empty($errors['email'])): ?>
                            <small class="text-danger"><?php echo htmlspecialchars($errors['email']); ?></small>
                            <?php endif; ?>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label fw-bold">Số điện thoại <span
                                    class="text-danger">*</span></label>
                            <div class="input-group" data-bs-toggle="tooltip" title="Nhập số điện thoại hợp lệ">
                                <span class="input-group-text bg-light"><i class="bi bi-telephone"></i></span>
                                <input type="text" class="form-control" id="phone" name="phone"
                                    placeholder="Nhập số điện thoại"
                                    value="<?php echo htmlspecialchars($user->phone); ?>" required>
                            </div>
                            <?php if (!empty($errors['phone'])): ?>
                            <small class="text-danger"><?php echo htmlspecialchars($errors['phone']); ?></small>
                            <?php endif; ?>
                        </div>
                        <div class="mb-4">
                                <label for="avatar" class="form-label text-white fw-bold">Avatar</label>
                                <?php if (!empty($user->avatar)): ?>
                                    <div class="mb-2">
                                        <img src="/webbanhang/<?php echo htmlspecialchars($user->avatar ?: 'images/no-image.png', ENT_QUOTES, 'UTF-8'); ?>" alt="Avatar" class="img-fluid rounded-circle" style="width: 100px; height: 100px;">
                                    </div>
                                <?php endif; ?>
                                <input type="file" class="form-control" id="avatar" name="avatar" accept="image/*">
                            </div>
                        <div class="mb-3">
                            <label for="role" class="form-label fw-bold">Vai trò <span
                                    class="text-danger">*</span></label>
                            <div class="input-group" data-bs-toggle="tooltip" title="Chọn vai trò cho người dùng">
                                <span class="input-group-text bg-light"><i class="bi bi-shield-check"></i></span>
                                <select class="form-select" id="role" name="role" required>
                                    <option value="user" <?php if ($user->role == 'user') echo 'selected'; ?>>User
                                    </option>
                                    <option value="admin" <?php if ($user->role == 'admin') echo 'selected'; ?>>Admin
                                    </option>
                                </select>
                            </div>
                            <?php if (!empty($errors['role'])): ?>
                            <small class="text-danger"><?php echo htmlspecialchars($errors['role']); ?></small>
                            <?php endif; ?>
                        </div>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary w-50">Cập nhật</button>
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

.form-control,
.form-select {
    border-radius: 0.375rem;
    transition: border-color 0.3s ease;
}

.form-control:focus,
.form-select:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 5px rgba(13, 110, 253, 0.2);
}

.input-group-text {
    border-right: 0;
    background-color: #f8f9fa;
}

.btn-primary,
.btn-secondary {
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
document.addEventListener('DOMContentLoaded', function() {
    // Khởi tạo tooltip
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});
</script>

<?php include 'app/views/shares/footer.php'; ?>