<?php include 'app/views/shares/header.php'; ?>
<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h2 class="mb-0">Thêm danh mục mới</h2>
        </div>
        <div class="card-body">
            <?php if (!empty($errors)): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    <?php foreach ($errors as $error): ?>
                    <li><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></li>
                    <?php endforeach; ?>
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php endif; ?>
            <form method="POST" action="/WebBanHang/Category/save" id="categoryForm" onsubmit="return validateForm();">
                <div class="mb-3">
                    <label for="name" class="form-label fw-bold">Tên danh mục <span class="text-danger">*</span></label>
                    <input type="text" id="name" name="name" class="form-control" placeholder="Nhập tên danh mục" required>
                    <div class="invalid-feedback">Vui lòng nhập tên danh mục.</div>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label fw-bold">Mô tả</label>
                    <textarea id="description" name="description" class="form-control" rows="5" placeholder="Nhập mô tả danh mục"></textarea>
                    <div class="invalid-feedback">Mô tả không hợp lệ.</div>
                </div>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Thêm danh mục</button>
                    <a href="/WebBanHang/Category/list" class="btn btn-outline-secondary">Quay lại danh sách</a>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Bootstrap 5 CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<style>
    .card {
        border-radius: 10px;
    }
    .card-header {
        border-radius: 10px 10px 0 0;
    }
    .form-label {
        color: #333;
    }
    .form-control, .form-select {
        border-radius: 8px;
        transition: border-color 0.3s ease;
    }
    .form-control:focus, .form-select:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 5px rgba(13, 110, 253, 0.3);
    }
    .btn-primary {
        border-radius: 8px;
        padding: 10px 20px;
    }
    .btn-outline-secondary {
        border-radius: 8px;
    }
</style>
<script>
function validateForm() {
    const form = document.getElementById('categoryForm');
    const name = document.getElementById('name');
    const description = document.getElementById('description');
    let isValid = true;

    // Reset invalid feedback
    form.querySelectorAll('.form-control').forEach(input => {
        input.classList.remove('is-invalid');
    });

    // Validate name
    if (!name.value.trim()) {
        name.classList.add('is-invalid');
        isValid = false;
    }

    // Validate description (optional, but if entered, ensure it's not just whitespace)
    if (description.value && !description.value.trim()) {
        description.classList.add('is-invalid');
        isValid = false;
    }

    return isValid;
}
</script>
<?php include 'app/views/shares/footer.php'; ?>