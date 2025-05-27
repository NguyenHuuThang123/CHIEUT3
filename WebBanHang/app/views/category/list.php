<?php include 'app/views/shares/header.php'; ?>
<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h2 class="mb-0">Danh sách danh mục</h2>
            <a href="/webbanhang/Category/add" class="btn btn-light btn-sm">Thêm danh mục mới</a>
        </div>
        <div class="card-body">
            <?php if (!empty($categories)): ?>
            <div class="table-responsive">
                <table class="table table-hover table-bordered align-middle">
                    <thead class="table-primary">
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Tên danh mục</th>
                            <th scope="col">Mô tả</th>
                            <th scope="col" style="width: 200px;">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($categories as $category): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($category->id, ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($category->name, ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($category->description ?? 'Không có mô tả', ENT_QUOTES, 'UTF-8'); ?></td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="/webbanhang/Category/edit/<?php echo $category->id; ?>" 
                                       class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-pencil-fill me-1"></i>Chỉnh sửa
                                    </a>
                                    <form action="/webbanhang/Category/delete" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa danh mục này?');">
                                        <input type="hidden" name="id" value="<?php echo $category->id; ?>">
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            <i class="bi bi-trash-fill me-1"></i>Xóa
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php else: ?>
            <div class="alert alert-info text-center">
                <p class="mb-0">Hiện tại không có danh mục nào.</p>
                <a href="/webbanhang/Category/add" class="btn btn-primary mt-2">Thêm danh mục mới</a>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Bootstrap 5 CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<style>
    .card {
        border-radius: 10px;
    }
    .card-header {
        border-radius: 10px 10px 0 0;
    }
    .table th, .table td {
        vertical-align: middle;
    }
    .table th {
        background-color: #0d6efd;
        color: white;
    }
    .btn-sm {
        padding: 5px 10px;
        border-radius: 8px;
    }
</style>
<?php include 'app/views/shares/footer.php'; ?>