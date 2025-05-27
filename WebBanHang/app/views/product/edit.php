<?php include 'app/views/shares/header.php'; ?>
<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h2 class="mb-0">Sửa sản phẩm</h2>
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
            <form method="POST" action="/webbanhang/Product/update" id="productForm" onsubmit="return validateForm();" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?php echo $product->id; ?>">
                <div class="mb-3">
                    <label for="name" class="form-label fw-bold">Tên sản phẩm <span class="text-danger">*</span></label>
                    <input type="text" id="name" name="name" class="form-control" placeholder="Nhập tên sản phẩm" value="<?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?>" required>
                    <div class="invalid-feedback">Vui lòng nhập tên sản phẩm.</div>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label fw-bold">Mô tả <span class="text-danger">*</span></label>
                    <textarea id="description" name="description" class="form-control" rows="5" placeholder="Nhập mô tả sản phẩm" required><?php echo htmlspecialchars($product->description, ENT_QUOTES, 'UTF-8'); ?></textarea>
                    <div class="invalid-feedback">Vui lòng nhập mô tả sản phẩm.</div>
                </div>
                <div class="mb-3">
                    <label for="price" class="form-label fw-bold">Giá (VND) <span class="text-danger">*</span></label>
                    <input type="number" id="price" name="price" class="form-control" step="0.01" min="0" placeholder="Nhập giá sản phẩm" value="<?php echo htmlspecialchars($product->price, ENT_QUOTES, 'UTF-8'); ?>" required>
                    <div class="invalid-feedback">Vui lòng nhập giá hợp lệ (số dương).</div>
                </div>
                <div class="mb-3">
                    <label for="category_id" class="form-label fw-bold">Danh mục <span class="text-danger">*</span></label>
                    <select id="category_id" name="category_id" class="form-select" required>
                        <option value="" disabled>Chọn danh mục</option>
                        <?php foreach ($categories as $category): ?>
                        <option value="<?php echo $category->id; ?>" <?php echo $category->id == $product->category_id ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($category->name, ENT_QUOTES, 'UTF-8'); ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                    <div class="invalid-feedback">Vui lòng chọn danh mục.</div>
                </div>
                <div class="mb-3">
                    
                    <div class="form-group">
                        <label for="image" class="form-label fw-bold">Hình ảnh:</label>
                        <input type="file" id="image" name="image" class="form-control">
                        <small class="form-text text-muted">Chỉ chấp nhận file PNG, JPG, hoặc JPEG. Dung lượng tối đa 5MB. Bỏ qua nếu không muốn thay đổi hình ảnh.</small>

                        <input type="hidden" name="existing_image" value="<?php echo $product->image;
                        ?>">
                        <?php if ($product->image): ?>

                            <img src="/webbanhang/<?php echo $product->image; ?>" alt="Product Image" style="max-width: 100px;">

                        <?php endif; ?>
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                    <a href="/WebBanHang/Product/list" class="btn btn-outline-secondary">Quay lại danh sách</a>
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
    .img-thumbnail {
        border-radius: 8px;
    }
</style>
<script>
function validateForm() {
    const form = document.getElementById('productForm');
    const name = document.getElementById('name');
    const description = document.getElementById('description');
    const price = document.getElementById('price');
    const category = document.getElementById('category_id');
    const image = document.getElementById('image');
    let isValid = true;

    // Reset invalid feedback
    form.querySelectorAll('.form-control, .form-select').forEach(input => {
        input.classList.remove('is-invalid');
    });

    // Validate name
    if (!name.value.trim()) {
        name.classList.add('is-invalid');
        isValid = false;
    }

    // Validate description
    if (!description.value.trim()) {
        description.classList.add('is-invalid');
        isValid = false;
    }

    // Validate price
    if (price.value <= 0) {
        price.classList.add('is-invalid');
        isValid = false;
    }

    // Validate category
    if (!category.value) {
        category.classList.add('is-invalid');
        isValid = false;
    }

    // Validate image (only if a file is selected)
    if (image.files.length) {
        const file = image.files[0];
        const allowedTypes = ['image/png', 'image/jpeg', 'image/jpg'];
        const maxSize = 5 * 1024 * 1024; // 5MB
        if (!allowedTypes.includes(file.type)) {
            image.classList.add('is-invalid');
            isValid = false;
        }
        if (file.size > maxSize) {
            image.classList.add('is-invalid');
            isValid = false;
        }
    }

    return isValid;
}
</script>
<?php include 'app/views/shares/footer.php'; ?>