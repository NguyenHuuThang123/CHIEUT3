<?php include 'app/views/shares/header.php'; ?>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">Danh sách người dùng</h1>
        <a href="/WebBanHang/account/addUser" class="btn btn-success">Thêm người dùng mới</a>
    </div>
    
    <?php if (empty($users)): ?>
        <div class="alert alert-info">Không có người dùng nào.</div>
    <?php else: ?>
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên đăng nhập</th>
                    <th>Vai trò</th>
                    <th>Email</th>
                    <th>Điện thoại</th>
                    <th>Avatar</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($user->id); ?></td>
                        <td><?php echo htmlspecialchars($user->username); ?></td>                     
                        <td><?php echo htmlspecialchars($user->role); ?></td>
                        <td><?php echo htmlspecialchars($user->email ?? 'Chưa cập nhật'); ?></td>
                        <td><?php echo htmlspecialchars($user->phone ?? 'Chưa cập nhật'); ?></td>
                        <td>
                            <?php if ($user->avatar): ?>
                                <img src="/webbanhang/<?php echo htmlspecialchars($user->avatar ?: 'images/no-image.png', ENT_QUOTES, 'UTF-8'); ?>" alt="Avatar" class="img-thumbnail" style="width: 50px; height: 50px;">
                            <?php else: ?>
                                <span class="text-muted">Chưa có avatar</span>
                            <?php endif; ?>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="/webbanhang/account/editUser/<?php echo htmlspecialchars($user->id); ?>" class="btn btn-warning btn-sm">Sửa</a>
                                <form action="/webbanhang/account/deleteUser/<?php echo htmlspecialchars($user->id); ?>" method="POST" class="d-inline">
                                    <button type="submit" class="btn btn-danger btn-sm">Xóa</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
    <a href="/webbanhang/" class="btn btn-primary mt-3">Quay lại</a>
</div>

<?php include 'app/views/shares/footer.php'; ?>