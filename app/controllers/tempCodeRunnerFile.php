<?php
session_start();
        if (!isset($_SESSION['username'])) {
            header('Location: /webbanhang/account/login');
            exit;
        }
        $user = $this->accountModel->getAccountByUsername($_SESSION['username']);
        if (!$user) {
            echo "Không tìm thấy tài khoản!";
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $fullName = $_POST['fullname'] ?? '';
            $email = $_POST['email'] ?? '';
            $phone = $_POST['phone'] ?? '';
            $avatar = $user->avatar;

            // Xử lý upload avatar nếu có file mới
            if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] == UPLOAD_ERR_OK) {
                $targetDir = "uploads/avatars/";
                if (!is_dir($targetDir)) {
                    mkdir($targetDir, 0777, true);
                }
                $fileName = uniqid() . '_' . basename($_FILES['avatar']['name']);
                $targetFile = $targetDir . $fileName;
                $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
                $allowedTypes = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

                if (in_array($fileType, $allowedTypes)) {
                    if (move_uploaded_file($_FILES['avatar']['tmp_name'], $targetFile)) {
                        $avatar = '/' . $targetFile;
                    } else {
                        $errors['avatar'] = "Tải ảnh lên thất bại!";
                    }
                } else {
                    $errors['avatar'] = "Chỉ cho phép các định dạng ảnh: jpg, jpeg, png, gif, webp";
                }
            }

            // Validate các trường khác nếu cần...

            if (!empty($errors)) {
                include 'app/views/account/edit.php';
                return;
            }

            // Cập nhật thông tin user (không cho sửa username, role)
            $query = "UPDATE account SET fullname = :fullname, email = :email, phone = :phone, avatar = :avatar WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':fullname', $fullName);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':phone', $phone);
            $stmt->bindParam(':avatar', $avatar);
            $stmt->bindParam(':id', $user->id);
            $stmt->execute();

            header('Location: /webbanhang/account/editUser?success=1');
            exit;
        }
    }