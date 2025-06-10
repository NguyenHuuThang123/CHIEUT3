<?php
require_once('app/config/database.php');
require_once('app/models/ProductModel.php');
require_once('app/models/CategoryModel.php');

class DefaultController
{
    private $db;
    private $productModel;

    // Constructor để khởi tạo kết nối cơ sở dữ liệu và model
    public function __construct()
    {
        try {
            // Khởi tạo kết nối cơ sở dữ liệu
            $this->db = new PDO("mysql:host=localhost;dbname=my_store", "root", "");
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->db->exec("SET NAMES utf8");

            // Khởi tạo ProductModel
            $this->productModel = new ProductModel($this->db);
        } catch (PDOException $e) {
            die("Kết nối cơ sở dữ liệu thất bại: " . $e->getMessage());
        }
    }

    // Hành động index để hiển thị trang chủ
    public function index()
    {
        // Khởi động session để kiểm tra đăng nhập hoặc giỏ hàng
        //session_start();

        // Lấy danh sách sản phẩm từ ProductModel
        $products = $this->productModel->getProducts();

        // Tải file view index.php và truyền dữ liệu
        require_once 'app/views/Home/index.php';
    }
}