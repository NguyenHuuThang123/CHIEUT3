<?php
// Require necessary files
require_once 'app/config/database.php';
require_once 'app/models/CategoryModel.php';
require_once 'app/helpers/SessionHelper.php';

class CategoryController
{
    private $categoryModel;
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->getConnection();
        $this->categoryModel = new CategoryModel($this->db);
    }

    // Kiểm tra quyền Admin
    private function isAdmin() {
        return SessionHelper::isAdmin();
    }
    
    // Hiển thị danh sách danh mục (mở cho tất cả)
    public function list()
    {
        $categories = $this->categoryModel->getCategories();
        include 'app/views/category/list.php';
    }

    // Hiển thị form và xử lý thêm danh mục (chỉ Admin)
    public function add()
    {
        if (!$this->isAdmin()) {
            echo "Bạn không có quyền truy cập chức năng này!";
            exit;
        }

        $errors = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $description = trim($_POST['description'] ?? '');

            // Kiểm tra dữ liệu
            if (empty($name)) {
                $errors[] = "Tên danh mục không được để trống.";
            }
            if (strlen($name) > 100) {
                $errors[] = "Tên danh mục không được dài quá 100 ký tự.";
            }

            // Nếu không có lỗi, lưu danh mục
            if (empty($errors)) {
                $result = $this->categoryModel->createCategory($name, $description);
                if ($result) {
                    header("Location: /WebBanHang/Category/list");
                    exit;
                } else {
                    $errors[] = "Không thể thêm danh mục. Vui lòng thử lại.";
                }
            }
        }
        include 'app/views/category/add.php';
    }

    // Hiển thị form chỉnh sửa danh mục (chỉ Admin)
    public function edit($id)
    {
        if (!$this->isAdmin()) {
            echo "Bạn không có quyền truy cập chức năng này!";
            exit;
        }

        $category = $this->categoryModel->getCategoryById($id);
        if (!$category) {
            header("Location: /WebBanHang/Category/list");
            exit;
        }

        $errors = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $description = trim($_POST['description'] ?? '');

            // Kiểm tra dữ liệu
            if (empty($name)) {
                $errors[] = "Tên danh mục không được để trống.";
            }
            if (strlen($name) > 100) {
                $errors[] = "Tên danh mục không được dài quá 100 ký tự.";
            }

            // Nếu không có lỗi, cập nhật danh mục
            if (empty($errors)) {
                $result = $this->categoryModel->updateCategory($id, $name, $description);
                if ($result) {
                    header("Location: /WebBanHang/Category/list");
                    exit;
                } else {
                    $errors[] = "Không thể cập nhật danh mục. Vui lòng thử lại.";
                }
            }
        }
        include 'app/views/category/edit.php';
    }

    // Xử lý cập nhật danh mục (chỉ Admin)
    public function update()
    {
        if (!$this->isAdmin()) {
            echo "Bạn không có quyền truy cập chức năng này!";
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: /WebBanHang/Category/list");
            exit;
        }

        $id = $_POST['id'] ?? 0;
        $this->edit($id);
    }

    // Xóa danh mục (chỉ Admin)
    public function delete()
    {
        if (!$this->isAdmin()) {
            echo "Bạn không có quyền truy cập chức năng này!";
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: /WebBanHang/Category/list");
            exit;
        }

        $id = $_POST['id'] ?? 0;
        $category = $this->categoryModel->getCategoryById($id);
        if ($category) {
            $result = $this->categoryModel->deleteCategory($id);
            if ($result) {
                header("Location: /WebBanHang/Category/list");
                exit;
            }
        }
        // Nếu không tìm thấy danh mục hoặc xóa thất bại, chuyển hướng về danh sách
        header("Location: /WebBanHang/Category/list");
        exit;
    }
}
?>