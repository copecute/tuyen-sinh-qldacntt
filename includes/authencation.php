<?php
//                       _oo0oo_
//                      o8888888o
//                      88" . "88
//                      (| -_- |)
//                      0\  =  /0
//                    ___/`---'\___
//                  .' \\|     |// '.
//                 / \\|||  :  |||// \
//                / _||||| -:- |||||- \
//               |   | \\\  -  /// |   |
//               | \_|  ''\---/''  |_/ |
//               \  .-\__  '-'  ___/-. /
//             ___'. .'  /--.--\  `. .'___
//          ."" '<  `.___\_<|>_/___.' >' "".
//         | | :  `- \`.;`\ _ /`;.`/ - ` : | |
//         \  \ `_.   \_ __\ /__ _/   .-` /  /
//     =====`-.____`.___ \_____/___.-`___.-'=====
//                       `=---='
//
//     ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//            amen đà phật copecute 
//     ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
require_once ($_SERVER['DOCUMENT_ROOT'] . '/includes/config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = isset($_GET['action']) ? $_GET['action'] : '';
    $csrf_token = $_POST['csrf_token'];

    if (!validate_csrf_token($csrf_token)) {
        die("CSRF token không hợp lệ.");
    }

    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($action === 'register') {
        // Xử lý đăng ký
        $password_hashed = password_hash($password, PASSWORD_DEFAULT);


        try {
            $sql = "INSERT INTO accounts (username, password) VALUES (:username, :password)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':password', $password_hashed);
            $stmt->execute();
            echo "Đăng ký thành công. <a href='../login.php'>Đăng nhập</a>";
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                echo "Tên đăng nhập đã tồn tại. Vui lòng chọn tên đăng nhập khác. <a href='../register.php'>Thử lại</a>";
            } else {
                echo "Lỗi: " . $e->getMessage();
            }
        }

    } elseif ($action === 'login') {
        // Xử lý đăng nhập
        try {
            $sql = "SELECT account_id, username, password FROM accounts WHERE username = :username";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':username', $username);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                if (password_verify($password, $row['password'])) {
                    $_SESSION['account_id'] = $row['account_id'];
                    header("Location: ../index.php");
                    exit;
                }
            }

            // Thông báo chung chung cho cả hai trường hợp: sai mật khẩu hoặc không tìm thấy tài khoản
            echo "Tên đăng nhập hoặc mật khẩu không chính xác. <a href='../login.php'>Thử lại</a>";
        } catch (PDOException $e) {
            echo "Lỗi: " . $e->getMessage();
        }
    }

    $conn = null; // Đóng kết nối cơ sở dữ liệu
} else {
    header("HTTP/1.1 403 Forbidden");
    echo "Thằng tó mày không có quyền!";
}
?>