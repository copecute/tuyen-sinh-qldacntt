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
        $response = ['status' => 'error', 'message' => 'CSRF token không hợp lệ.'];
        echo json_encode($response);
        exit;
    }

    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($action === 'login') {
        // Xử lý đăng nhập
        try {
            $sql = "SELECT account_id, username, password FROM student_accounts WHERE username = :username";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':username', $username);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                if (password_verify($password, $row['password'])) {
                    $_SESSION['account_id'] = $row['account_id'];
                    $response = ['status' => 'success', 'message' => 'Đăng nhập thành công!'];
                    echo json_encode($response);
                    exit;
                }
            }

            // Thông báo chung chung cho cả hai trường hợp: sai mật khẩu hoặc không tìm thấy tài khoản
            $response = ['status' => 'error', 'message' => 'Tên đăng nhập hoặc mật khẩu không chính xác.'];
            echo json_encode($response);
            exit;
        } catch (PDOException $e) {
            $response = ['status' => 'error', 'message' => 'Lỗi: ' . $e->getMessage()];
            echo json_encode($response);
            exit;
        }
    }

    $conn = null; // Đóng kết nối cơ sở dữ liệu
} else {
    header("HTTP/1.1 403 Forbidden");
    echo "Thằng tó mày không có quyền!";
}
?>