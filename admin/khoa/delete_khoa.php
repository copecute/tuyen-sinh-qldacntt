<?php
require_once ($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $khoa_id = $_POST['id'];

    try {
        $stmt = $conn->prepare("DELETE FROM khoa WHERE id = :khoa_id");
        $stmt->bindParam(':khoa_id', $khoa_id);

        if ($stmt->execute()) {
            echo 'Xoá khoa thành công.';
        } else {
            throw new Exception('Xoá khoa thất bại.');
        }
    } catch (PDOException $e) {
        echo 'Xoá khoa thất bại: ' . $e->getMessage();
    } catch (Exception $e) {
        echo 'Xoá khoa thất bại: ' . $e->getMessage();
    }
} else {
    echo 'Lỗi: Không có hành động được xác định hoặc không được phép truy cập.';
}
?>
