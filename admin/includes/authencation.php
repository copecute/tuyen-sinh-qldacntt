<?php
require_once ($_SERVER['DOCUMENT_ROOT'] . '/includes/config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = isset($_GET['action']) ? $_GET['action'] : '';
    $csrf_token = $_POST['csrf_token'];

    if (!validate_csrf_token($csrf_token)) {
        die(json_encode(['status' => 'error', 'message' => 'CSRF token không hợp lệ.']));
    }

    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($action === 'register') {
        // Xử lý đăng ký
        $password_hashed = password_hash($password, PASSWORD_DEFAULT);

        try {
            $sql = "INSERT INTO admins (username, password) VALUES (:username, :password)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':password', $password_hashed);
            $stmt->execute();
            echo json_encode(['status' => 'success', 'message' => 'Đăng ký thành công.']);
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                echo json_encode(['status' => 'error', 'message' => 'Tên đăng nhập đã tồn tại. Vui lòng chọn tên đăng nhập khác.']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Lỗi: ' . $e->getMessage()]);
            }
        }
    } elseif ($action === 'login') {
        // Xử lý đăng nhập
        try {
            $sql = "SELECT id, username, password FROM admins WHERE username = :username";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':username', $username);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                if (password_verify($password, $row['password'])) {
                    $_SESSION['admin_id'] = $row['id'];
                    echo json_encode(['status' => 'success', 'message' => 'Đăng nhập thành công.']);
                    exit;
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Tên đăng nhập hoặc mật khẩu không chính xác.']);
                }
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Tên đăng nhập hoặc mật khẩu không chính xác.']);
            }
        } catch (PDOException $e) {
            echo json_encode(['status' => 'error', 'message' => 'Lỗi: ' . $e->getMessage()]);
        }
    }

    $conn = null; // Đóng kết nối cơ sở dữ liệu
} else {
    header("HTTP/1.1 403 Forbidden");
    echo json_encode(['status' => 'error', 'message' => 'Truy cập bị từ chối.']);
}
?>
