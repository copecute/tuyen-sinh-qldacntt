<?php
require_once ($_SERVER['DOCUMENT_ROOT'] . '/includes/config.php');

<<<<<<< Updated upstream
$username = null;
if (isset($_SESSION['account_id'])) {
    $account_id = $_SESSION['account_id'];

    try {
        $sql = "SELECT a.username, ai.fullname 
                FROM accounts a
                LEFT JOIN accounts_info ai ON a.account_id = ai.account_id
                WHERE a.account_id = :account_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':account_id', $account_id);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user) {
            $username = !empty($user['fullname']) ? htmlspecialchars($user['fullname']) : htmlspecialchars($user['username']);
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
function renderHeader($title = "Your Website Title", $description = "Your website description here", $keywords = "keyword1, keyword2, keyword3")
{
=======
// Hàm kiểm tra đăng nhập
function checkLogin()
{
    if (isset($_SESSION['account_id'])) {
        return true;
    } else {
        return false;
    }
}


// Sử dụng hàm để lọc username tuong ung voi account_id
function getUserFromAccountId($conn)
{
    try {
        $sql = "SELECT * FROM accounts WHERE account_id = :account_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':account_id', $_SESSION['account_id']);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row; // Trả về toàn bộ dữ liệu của người dùng
        } else {
            return null; // Trả về null nếu không tìm thấy người dùng
        }
    } catch (PDOException $e) {
        echo "Lỗi: " . $e->getMessage();
        return null; // Trả về null nếu có lỗi xảy ra trong quá trình truy vấn CSDL
    }
}

$user = getUserFromAccountId($conn);

function renderHeader($title = "title", $description = "description", $keywords = "keyword1, keyword2, keyword3")
{
    // Sử dụng biến toàn cục $conn
    global $conn;

    if (isset($_SESSION['account_id'])) {
        // Lấy account_id từ session
        $accountId = $_SESSION['account_id'];
    
        // Thực hiện truy vấn để lấy level từ bảng accounts
        $sql = "SELECT level FROM accounts WHERE account_id = :account_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':account_id', $accountId);
        $stmt->execute();
    
        // Lấy kết quả truy vấn
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $userLevel = $row['level'];
    }
>>>>>>> Stashed changes
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