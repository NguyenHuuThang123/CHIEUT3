<?php
require_once('app/config/database.php');
require_once('app/models/ProductModel.php');
require_once('app/models/CategoryModel.php');
require_once('app/helpers/SessionHelper.php');

class ProductController 
{
    private $productModel;
    private $db;

    public function __construct() 
    {
        $this->db = (new Database())->getConnection();
        $this->productModel = new ProductModel($this->db);
    }

    // Kiểm tra quyền Admin
    private function isAdmin() {
        return SessionHelper::isAdmin();
    }

    // Hiển thị danh sách sản phẩm (mở cho tất cả)
    public function index() 
    {
        $sort = $_GET['sort_price'] ?? '';
    if ($sort === 'asc') {
        $products = $this->productModel->getAllProductsOrderByPrice('ASC');
    } elseif ($sort === 'desc') {
        $products = $this->productModel->getAllProductsOrderByPrice('DESC');
    } else {
        $products = $this->productModel->getAllProducts();
    }
        include 'app/views/product/list.php';
    }
    
    // Xem chi tiết sản phẩm (mở cho tất cả)
    public function show($id) 
    {
        $product = $this->productModel->getProductById($id);
        if ($product) {
            include 'app/views/product/show.php';
        } else {
            echo "Không thấy sản phẩm.";
        }
    }

    // Thêm sản phẩm (chỉ Admin)
    public function add() 
    {
        if (!$this->isAdmin()) {
            echo "Bạn không có quyền truy cập chức năng này!";
            exit;
        }
        $categories = (new CategoryModel($this->db))->getCategories();
        include_once 'app/views/product/add.php';
    }

    // Lưu sản phẩm mới (chỉ Admin)
    public function save() 
    {
        if (!$this->isAdmin()) {
            echo "Bạn không có quyền truy cập chức năng này!";
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'] ?? '';
            $description = $_POST['description'] ?? '';
            $price = $_POST['price'] ?? '';
            $category_id = $_POST['category_id'] ?? null;

            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $image = $this->uploadImage($_FILES['image']);
            } else {
                $image = "";
            }

            $result = $this->productModel->addProduct($name, $description, $price, $category_id, $image);
            if (is_array($result)) {
                $errors = $result;
                $categories = (new CategoryModel($this->db))->getCategories();
                include 'app/views/product/add.php';
            } else {
                header('Location: /webbanhang/Product');
            }
        }
    }
    
    // Sửa sản phẩm (chỉ Admin)
    public function edit($id) {
        if (!$this->isAdmin()) {
            echo "Bạn không có quyền truy cập chức năng này!";
            exit;
        }
        $product = $this->productModel->getProductById($id);
        $categories = (new CategoryModel($this->db))->getCategories();
        if ($product) {
            include 'app/views/product/edit.php';
        } else {
            echo "Không thấy sản phẩm.";
        }
    }

    // Cập nhật sản phẩm (chỉ Admin)
    public function update() {
        if (!$this->isAdmin()) {
            echo "Bạn không có quyền truy cập chức năng này!";
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $name = $_POST['name'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $category_id = $_POST['category_id'];

            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $image = $this->uploadImage($_FILES['image']);
            } else {
                $image = $_POST['existing_image'];
            }

            $edit = $this->productModel->updateProduct($id, $name, $description, $price, $category_id, $image);
            if ($edit) {
                header('Location: /webbanhang/Product');
            } else {
                echo "Đã xảy ra lỗi khi lưu sản phẩm.";
            }
        }
    }

    // Xóa sản phẩm (chỉ Admin)
    public function delete($id) {
        if (!$this->isAdmin()) {
            echo "Bạn không có quyền truy cập chức năng này!";
            exit;
        }
        if ($this->productModel->deleteProduct($id)) {
            header('Location: /webbanhang/Product');
        } else {
            echo "Đã xảy ra lỗi khi xóa sản phẩm.";
        }
    }
    
    private function uploadImage($file) {
        $target_dir = "uploads/";

        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $target_file = $target_dir . basename($file["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        $check = getimagesize($file["tmp_name"]);
        if ($check === false) {
            throw new Exception("File không phải là hình ảnh.");
        }
        if ($file["size"] > 10 * 1024 * 1024) {
            throw new Exception("Hình ảnh có kích thước quá lớn.");
        }
        if (!in_array($imageFileType, ["jpg", "jpeg", "png", "gif"])) {
            throw new Exception("Chỉ cho phép các định dạng JPG, JPEG, PNG và GIF.");
        }
        if (!move_uploaded_file($file["tmp_name"], $target_file)) {
            throw new Exception("Có lỗi xảy ra khi tải lên hình ảnh.");
        }
        return $target_file;
    }

    // Thêm vào giỏ hàng (mở cho tất cả)
    public function addToCart($id) {
        $product = $this->productModel->getProductById($id);
        if (!$product) {
            echo "Không tìm thấy sản phẩm.";
            return;
        }
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]['quantity']++;
        } else {
            $_SESSION['cart'][$id] = [
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => 1,
                'image' => $product->image
            ];
        }
        header('Location: /webbanhang/');
    }

    // Hiển thị giỏ hàng (mở cho tất cả)
    public function cart()
    {
        $cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
        include 'app/views/product/cart.php';
    }

    // Trang checkout (mở cho tất cả)
    public function checkout()
    {
        include 'app/views/product/checkout.php';
    }

    // Xử lý checkout (mở cho tất cả)
    public function processCheckout()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'] ?? '';
            $phone = $_POST['phone'] ?? '';
            $address = $_POST['address'] ?? '';

            // Kiểm tra giỏ hàng
            if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
                echo "Giỏ hàng trống.";
                return;
            }

            // Bắt đầu giao dịch
            $this->db->beginTransaction();
            try {
                // Lưu thông tin đơn hàng vào bảng orders
                $query = "INSERT INTO orders (name, phone, address) VALUES (:name, :phone, :address)";
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':name', $name);
                $stmt->bindParam(':phone', $phone);
                $stmt->bindParam(':address', $address);
                $stmt->execute();
                $order_id = $this->db->lastInsertId();

                // Lưu chi tiết đơn hàng vào bảng order_details
                $cart = $_SESSION['cart'];
                foreach ($cart as $product_id => $item) {
                    $query = "INSERT INTO order_details (order_id, product_id, quantity, price) VALUES (:order_id, :product_id, :quantity, :price)";
                    $stmt = $this->db->prepare($query);
                    $stmt->bindParam(':order_id', $order_id);
                    $stmt->bindParam(':product_id', $product_id);
                    $stmt->bindParam(':quantity', $item['quantity']);
                    $stmt->bindParam(':price', $item['price']);
                    $stmt->execute();
                }

                // Lưu thông tin vào session để hiển thị ở orderConfirmation
                $_SESSION['last_order_id'] = $order_id;
                $_SESSION['last_order_total'] = array_sum(array_map(function($item) {
                    return $item['price'] * $item['quantity'];
                }, $cart));

                // Xóa giỏ hàng sau khi đặt hàng thành công
                unset($_SESSION['cart']);

                // Commit giao dịch
                $this->db->commit();

                // Chuyển hướng đến trang xác nhận đơn hàng
                header('Location: /webbanhang/Product/orderConfirmation');
            } catch (Exception $e) {
                // Rollback giao dịch nếu có lỗi
                $this->db->rollBack();
                echo "Đã xảy ra lỗi khi xử lý đơn hàng: " . $e->getMessage();
            }
        }
    }

    // Hiển thị trang xác nhận đơn hàng (mở cho tất cả)
    public function orderConfirmation()
    {
        include 'app/views/product/orderConfirmation.php';
    }

    // Xóa giỏ hàng (mở cho tất cả)
    public function clearCart() {
        session_start();

        // Xoá toàn bộ giỏ hàng
        if (isset($_SESSION['cart'])) {
            unset($_SESSION['cart']);
        }

        // Nếu là request AJAX
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            echo json_encode(['success' => true]);
            return;
        }

        // Nếu là request thông thường, chuyển hướng về trang giỏ hàng
        header('Location: /WebBanHang/Product/cart');
        exit;
    }

    // Hiển thị danh sách sản phẩm (mở cho tất cả, trùng với index)
    public function list() {
        $products = $this->productModel->getProducts();
        require_once 'app/views/product/list.php';
    }

    // Cập nhật giỏ hàng (mở cho tất cả)
    public function updateCart($id) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Yêu cầu không hợp lệ']);
            exit;
        }

        // Start session
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Validate CSRF token
        $csrf_token = $_SERVER['HTTP_X_CSRF_TOKEN'] ?? '';
        if ($csrf_token !== ($_SESSION['csrf_token'] ?? '')) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'CSRF token không hợp lệ']);
            exit;
        }

        // Read JSON body
        $data = json_decode(file_get_contents('php://input'), true);
        $productId = $data['productId'] ?? $id;
        $quantity = (int)($data['quantity'] ?? 1);

        // Initialize cart if not exists
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        // Check if product exists in cart
        if (!isset($_SESSION['cart'][$productId])) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Sản phẩm không tồn tại trong giỏ hàng']);
            exit;
        }

        // Get cart item
        $item = $_SESSION['cart'][$productId];

        if ($quantity <= 0) {
            // Remove item from cart
            unset($_SESSION['cart'][$productId]);
            // Recalculate cart total
            $cartTotal = array_sum(array_map(function($cartItem) {
                return $cartItem['price'] * $cartItem['quantity'];
            }, $_SESSION['cart']));
            header('Content-Type: application/json');
            echo json_encode([
                'success' => true,
                'message' => 'Đã xóa sản phẩm',
                'removed' => true,
                'cartTotal' => number_format($cartTotal, 0, ',', '.')
            ]);
            exit;
        }

        // Update quantity
        $_SESSION['cart'][$productId]['quantity'] = $quantity;

        // Calculate new item total and cart total
        $newTotal = $item['price'] * $quantity;
        $cartTotal = array_sum(array_map(function($cartItem) {
            return $cartItem['price'] * $cartItem['quantity'];
        }, $_SESSION['cart']));

        // Return JSON response
        header('Content-Type: application/json');
        echo json_encode([
            'success' => true,
            'message' => 'Cập nhật thành công',
            'newTotal' => number_format($newTotal, 0, ',', '.'),
            'quantity' => $quantity,
            'cartTotal' => number_format($cartTotal, 0, ',', '.')
        ]);
        exit;
    }

    public function search()
    {
    $query = $_GET['query'] ?? '';
    $products = [];
    if ($query !== '') {
        $products = $this->productModel->searchProducts($query);
    }
    include 'app/views/product/search.php';
    }

    // Phương thức để lấy danh sách sản phẩm theo danh mục (mở cho tất cả)
    public function getProductsByCategory($categoryId) {
        $products = $this->productModel->getProductsByCategory($categoryId);
        include 'app/views/product/category.php';
    }
}
?>