<?php
require_once ($_SERVER['DOCUMENT_ROOT'] . '/includes/config.php');

$username = null;
$userLevel = null;

if (isset($_SESSION['admin_id'])) {
    $admin_id = $_SESSION['admin_id'];

    try {
        $sql = "SELECT * 
                FROM admins
                WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $admin_id);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user) {
            $username = htmlspecialchars($user['username']);
            $userLevel = htmlspecialchars($user['level']);
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    // Lấy URL hiện tại
    $currentUrl = $_SERVER['REQUEST_URI'];

    // Kiểm tra nếu URL hiện tại không phải là '/admin/login.php' hoặc '/admin/register.php'
    if ($currentUrl !== '/admin/login.php' && $currentUrl !== '/admin/register.php') {
        // Thì chuyển hướng tới trang đăng nhập
        header("Location: /admin/login.php");
        exit;
    }
}

function renderHeader($title = "Tuyển Sinh", $description = "Trang web tuyển sinh", $keywords = "keyword1, keyword2, keyword3")
{
    global $userLevel;
    global $username;
    // Tạo các biến để truyền vào header.php
    $metaTitle = htmlspecialchars($title);
    $metaDescription = htmlspecialchars($description);
    $metaKeywords = htmlspecialchars($keywords);

    include ($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/views/layout/header.php');
}

function renderFooter()
{
    include ($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/views/layout/footer.php');
}
?>