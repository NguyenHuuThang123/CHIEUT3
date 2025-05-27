<?php
// Require necessary files
require_once 'app/config/database.php';
require_once 'app/models/CategoryModel.php';

class CategoryController
{
    private $categoryModel;
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->getConnection();
        $this->categoryModel = new CategoryModel($this->db);
    }

    // Hiển thị danh sách danh mục
    public function list()
    {
        $categories = $this->categoryModel->getCategories();
        include 'app/views/category/list.php';
    }

    // Hiển thị form thêm danh mục
    public function add()
    {
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

    public function save()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'] ?? '';
            $description = $_POST['description'] ?? '';

            // Kiểm tra dữ liệu (tương tự như trong add() trước đó)
            $errors = [];
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
                    header('Location: /webbanhang/Category/list');
                    exit;
                } else {
                    $errors[] = "Không thể thêm danh mục. Vui lòng thử lại.";
                }
            }

            // Nếu có lỗi, hiển thị lại form với thông báo lỗi
            include 'app/views/add_category.php';
        } else {
            header('Location: /webbanhang/Category/add');
            exit;
        }
    }
    // Hiển thị form chỉnh sửa danh mục
    public function edit($id)
    {
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

    // Xử lý cập nhật danh mục
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: /WebBanHang/Category/list");
            exit;
        }

        $id = $_POST['id'] ?? 0;
        $this->edit($id);
    }

    // Xóa danh mục
    public function delete()
    {
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