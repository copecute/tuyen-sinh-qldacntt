<?php
require_once ($_SERVER['DOCUMENT_ROOT'] . '/includes/config.php');

$student = null; // Khởi tạo biến student

// Kiểm tra nếu account_id có trong session
if (isset($_SESSION['account_id'])) {
    $account_id = $_SESSION['account_id'];

    try {

        $sql = "
            SELECT *
            FROM student_accounts sa
            JOIN student_profiles sp ON sa.account_id = sp.account_id
            WHERE sa.account_id = :account_id
        ";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':account_id', $account_id, PDO::PARAM_INT);
        $stmt->execute();
        $student = $stmt->fetch(PDO::FETCH_ASSOC);

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
