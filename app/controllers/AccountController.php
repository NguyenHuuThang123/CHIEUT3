<?php
require_once('app/config/database.php');
require_once('app/models/AccountModel.php');
require_once 'app/helpers/SessionHelper.php';

class AccountController {
    private $accountModel;
    private $db;

    public function __construct() {
        $this->db = (new Database())->getConnection();
        $this->accountModel = new AccountModel($this->db);
    }

    public function register() {
        include_once 'app/views/account/register.php';
    }

    public function login() {
        include_once 'app/views/account/login.php';
    }

    public function save() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'] ?? '';
            $fullName = $_POST['fullname'] ?? '';
            $password = $_POST['password'] ?? '';
            $email = $_POST['email'] ?? '';
            $phone = $_POST['phone'] ?? '';
            $avatar = $_POST['avatar'] ?? ''; // hoặc xử lý upload ảnh

            $confirmPassword = $_POST['confirmpassword'] ?? '';
            $role = $_POST['role'] ?? 'user';

            $errors = [];
            if (empty($username)) {
                $errors['username'] = "Vui lòng nhập username!";
            } elseif (strlen($username) < 3 || strlen($username) > 50) {
                $errors['username'] = "Tên đăng nhập phải từ 3-50 ký tự!";
            }
            if (empty($fullName)) {
                $errors['fullname'] = "Vui lòng nhập fullname!";
            }
            if (empty($email)) {
                $errors['email'] = "Vui lòng nhập email!";
            }
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = "Email không hợp lệ!";
            }
            if (empty($phone)) {
                $errors['phone'] = "Vui lòng nhập số điện thoại!";
            } elseif (!preg_match('/^\d{10,15}$/', $phone)) {
                $errors['phone'] = "Số điện thoại phải từ 10-15 chữ số!";
            }
            // Kiểm tra định dạng avatar nếu cần
            if (!empty($avatar) && !filter_var($avatar, FILTER_VALIDATE_URL)) {
                $errors['avatar'] = "Đường dẫn avatar không hợp lệ!";
            }
            if (empty($password)) {
                $errors['password'] = "Vui lòng nhập password!";
            } elseif (strlen($password) < 6 || strlen($password) > 20) {
                $errors['password'] = "Mật khẩu phải từ 6-20 ký tự!";
            }
            if (empty($confirmPassword)) {
                $errors['confirmPass'] = "Vui lòng nhập xác nhận mật khẩu!";
            } elseif ($password != $confirmPassword) {
                $errors['confirmPass'] = "Mật khẩu và xác nhận chưa khớp!";
            }
            if (!in_array($role, ['admin', 'user'])) {
                $errors['role'] = "Vai trò không hợp lệ!";
                $role = 'user';
            }
            if ($this->accountModel->getAccountByUsername($username)) {
                $errors['account'] = "Tài khoản này đã được đăng ký!";
            }

            if (count($errors) > 0) {
                include_once 'app/views/account/register.php';
            } else {
                    $result = $this->accountModel->save($username, $fullName, $password, $role, $email, $phone, $avatar);
                if ($result) {
                    header('Location: /webbanhang/account/login');
                    exit;
                } else {
                    $errors['general'] = "Đăng ký thất bại. Vui lòng thử lại!";
                    include_once 'app/views/account/register.php';
                }
            }
        }
    }

    public function logout() {
        session_start();
        unset($_SESSION['username']);
        unset($_SESSION['role']);
        header('Location: /webbanhang/');
        exit;
    }

    public function checkLogin() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';

            $account = $this->accountModel->getAccountByUsername($username);
            if ($account && password_verify($password, $account->password)) {
                session_start();
                if (!isset($_SESSION['username'])) {
                    $_SESSION['username'] = $account->username;
                    $_SESSION['role'] = $account->role;
                }
                header('Location: /webbanhang/');
                exit;
            } else {
                $error = $account ? "Mật khẩu không đúng!" : "Không tìm thấy tài khoản!";
                include_once 'app/views/account/login.php';
                exit;
            }
        }
    }

    public function listUsers() 
    {
        if (!SessionHelper::isAdmin()) {
            echo "Bạn không có quyền truy cập chức năng này!";
            exit;
        }
        $query = "SELECT id, username, email, phone, avatar, role FROM account";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $users = $stmt->fetchAll(PDO::FETCH_OBJ);

        include 'app/views/account/list.php';
    }

    // Hiển thị form thêm người dùng mới (chỉ Admin)
    public function addUser() 
    {
        if (!SessionHelper::isAdmin()) {
            echo "Bạn không có quyền truy cập chức năng này!";
            exit;
        }

        include 'app/views/account/add.php';
    }

    // Xử lý thêm người dùng mới (chỉ Admin)
    public function processAddUser() 
    {
        if (!SessionHelper::isAdmin()) {
            echo "Bạn không có quyền truy cập chức năng này!";
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
            $confirm_password = $_POST['confirm_password'] ?? '';
            $role = $_POST['role'] ?? 'user';

            $errors = [];
            if (empty($username)) {
                $errors['username'] = "Vui lòng nhập username!";
            } elseif (strlen($username) < 3 || strlen($username) > 50) {
                $errors['username'] = "Tên đăng nhập phải từ 3-50 ký tự!";
            }
            if (empty($password)) {
                $errors['password'] = "Vui lòng nhập password!";
            } elseif (strlen($password) < 6 || strlen($password) > 20) {
                $errors['password'] = "Mật khẩu phải từ 6-20 ký tự!";
            }
            if (empty($confirm_password)) {
                $errors['confirm_password'] = "Vui lòng nhập xác nhận mật khẩu!";
            } elseif ($password !== $confirm_password) {
                $errors['confirm_password'] = "Mật khẩu xác nhận không khớp!";
            }
            if (!in_array($role, ['admin', 'user'])) {
                $errors['role'] = "Vai trò không hợp lệ!";
                $role = 'user';
            }
            if ($this->accountModel->getAccountByUsername($username)) {
                $errors['username'] = "Tên đăng nhập đã tồn tại!";
            }

            if (count($errors) > 0) {
                include 'app/views/account/add.php';
                return;
            }

            // Mã hóa mật khẩu và lưu vào cơ sở dữ liệu
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $query = "INSERT INTO account (username, password, role) VALUES (:username, :password, :role)";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':password', $hashed_password);
            $stmt->bindParam(':role', $role);
            $stmt->execute();

            // Chuyển hướng đến trang danh sách người dùng
            header('Location: /webbanhang/account/listUsers');
            exit;
        }
    }
    // Hiển thị form sửa người dùng (chỉ Admin)
    public function editUser($id) 
    {
        if (!SessionHelper::isAdmin()) {
            echo "Bạn không có quyền truy cập chức năng này!";
            exit;
        }

        $user = $this->accountModel->getAccountById($id);
        if (!$user) {
            header('Location: /webbanhang/account/listUsers');
            exit;
        }

        include 'app/views/account/edit.php';
    }

    // Xử lý sửa người dùng (chỉ Admin)
    public function processEditUser($id) 
    {
        if (!SessionHelper::isAdmin()) {
            echo "Bạn không có quyền truy cập chức năng này!";
            exit;
        }

        $user = $this->accountModel->getAccountById($id);
        if (!$user) {
            header('Location: /webbanhang/account/listUsers');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'] ?? '';
            $fullName = $_POST['fullname'] ?? '';
            $email = $_POST['email'] ?? '';
            $phone = $_POST['phone'] ?? '';
            $avatar = $user->avatar; // giữ avatar cũ mặc định
            $role = $_POST['role'] ?? 'user';

            $errors = []; // Đặt ở đây để không bị ghi đè

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

            // Validate các trường khác
            if (empty($username)) {
                $errors['username'] = "Vui lòng nhập username!";
            } elseif (strlen($username) < 3 || strlen($username) > 50) {
                $errors['username'] = "Tên đăng nhập phải từ 3-50 ký tự!";
            }

            // Nếu có lỗi, hiển thị lại form
            if (!empty($errors)) {
                include 'app/views/account/edit.php';
                return;
            }

            // Cập nhật thông tin người dùng
            $query = "UPDATE account SET username = :username, fullname = :fullname, email = :email, phone = :phone, role = :role, avatar = :avatar WHERE id = :id";    
            $stmt = $this->db->prepare($query);  
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':fullname', $fullName);
            $stmt->bindParam(':email', $email); 
            $stmt->bindParam(':phone', $phone);
            $stmt->bindParam(':avatar', $avatar);
            $stmt->bindParam(':role', $role);
            $stmt->execute();

            // Chuyển hướng đến trang danh sách người dùng
            header('Location: /webbanhang/account/listUsers');
            exit;
        }
        include 'app/views/account/edit.php';
    }

            public function editProfile()
        {
            if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }   
            if (!isset($_SESSION['username'])) {
                header('Location: /webbanhang/account/login');
                exit;
            }
            $user = $this->accountModel->getAccountByUsername($_SESSION['username']);
            if (!$user) {
                echo "Không tìm thấy tài khoản!";
                exit;
            }
            include 'app/views/account/profile_edit.php'; // Tạo file này hoặc dùng lại edit.php
        }

    // Xử lý cập nhật hồ sơ cá nhân
    public function processEditProfile()
    {
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
                include 'app/views/account/profile_edit.php';
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

            header('Location: /webbanhang/account/editProfile?success=1');
            exit;
        }
    }   
    // Xóa người dùng (chỉ Admin)
    public function deleteUser($id) 
    {
        if (!SessionHelper::isAdmin()) {
            echo "Bạn không có quyền truy cập chức năng này!";
            exit;
        }

        $user = $this->accountModel->getAccountById($id);
        if (!$user) {
            header('Location: /webbanhang/account/listUsers');
            exit;
        }

        $query = "DELETE FROM account WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        // Chuyển hướng đến trang danh sách người dùng
        header('Location: /webbanhang/account/listUsers');
        exit;
    }
    
}
?>