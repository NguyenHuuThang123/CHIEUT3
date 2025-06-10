<?php include 'app/views/shares/header.php'; ?>
<section class="vh-100 bg-light d-flex align-items-center justify-content-center">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-5 col-xl-4">
                <div class="card shadow-lg border-0" style="border-radius: 1.5rem; background: linear-gradient(135deg, #2c3e50, #3498db);">
                    <div class="card-body p-4 p-md-5">
                        <h2 class="fw-bold text-white text-uppercase mb-3 text-center">Chỉnh sửa hồ sơ cá nhân</h2>
                        <p class="text-light mb-4 text-center">Cập nhật thông tin của bạn</p>
                        <form action="/webbanhang/account/processEditProfile" method="POST" enctype="multipart/form-data">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control form-control-lg" id="fullname" name="fullname" placeholder="Họ và tên" value="<?php echo htmlspecialchars($user->fullname); ?>" required>
                                <label for="fullname" class="text-muted">Họ và tên</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="email" class="form-control form-control-lg" id="email" name="email" placeholder="Email" value="<?php echo htmlspecialchars($user->email); ?>" required>
                                <label for="email" class="text-muted">Email</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control form-control-lg" id="phone" name="phone" placeholder="Số điện thoại" value="<?php echo htmlspecialchars($user->phone); ?>" required>
                                <label for="phone" class="text-muted">Số điện thoại</label>
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
                            <button type="submit" class="btn btn-primary btn-lg w-100 py-2" style="border-radius: 0.5rem;">Cập nhật</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<style>
body {
    background: #f0f2f5;
}
.card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2) !important;
}
.btn-primary {
    background: #1e90ff;
    border: none;
    transition: background 0.3s ease;
}
.btn-primary:hover {
    background: #187cdb;
}
.form-control {
    border-radius: 0.5rem;
    background: rgba(255, 255, 255, 0.95);
}
.form-floating > label {
    color: #6c757d;
}
</style>
<?php include 'app/views/shares/footer.php'; ?>