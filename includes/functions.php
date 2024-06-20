<?php
require_once ($_SERVER['DOCUMENT_ROOT'] . '/includes/config.php');

$username = null;
$userLevel = null;

if (isset($_SESSION['account_id'])) {
    $account_id = $_SESSION['account_id'];

    try {
        $sql = "SELECT * 
                FROM accounts
                WHERE account_id = :account_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':account_id', $account_id);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user) {
            $username = !empty($user['fullname']) ? htmlspecialchars($user['fullname']) : htmlspecialchars($user['username']);
            $userLevel = $user['level'];
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

function renderHeader($title = "Tuyển Sinh", $description = "Trang web tuyển sinh", $keywords = "keyword1, keyword2, keyword3")
{
    global $userLevel;
    // Tạo các biến để truyền vào header.php
    $metaTitle = htmlspecialchars($title);
    $metaDescription = htmlspecialchars($description);
    $metaKeywords = htmlspecialchars($keywords);

    include ($_SERVER['DOCUMENT_ROOT'] . '/includes/views/layout/header.php');
}

function renderFooter()
{
    include ($_SERVER['DOCUMENT_ROOT'] . '/includes/views/layout/footer.php');
}
?>
