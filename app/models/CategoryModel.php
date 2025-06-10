<?php
class CategoryModel
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    // Lấy tất cả danh mục
    public function getCategories()
    {
        $stmt = $this->db->prepare("SELECT * FROM category");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    // Lấy danh mục theo ID
    public function getCategoryById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM category WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    // Tạo danh mục mới
    public function createCategory($name, $description)
    {
        $stmt = $this->db->prepare("INSERT INTO category (name, description) VALUES (?, ?)");
        return $stmt->execute([$name, $description]);
    }

    // Cập nhật danh mục
    public function updateCategory($id, $name, $description)
    {
        $stmt = $this->db->prepare("UPDATE category SET name = ?, description = ? WHERE id = ?");
        return $stmt->execute([$name, $description, $id]);
    }

    // Xóa danh mục
    public function deleteCategory($id)
    {
        $stmt = $this->db->prepare("DELETE FROM category WHERE id = ?");
        return $stmt->execute([$id]);
    }
}