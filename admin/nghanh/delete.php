<?php
require_once ($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');

$nghanh_id = isset($_POST['nghanh_id']) ? $_POST['nghanh_id'] : '';

if ($nghanh_id) {
    $query = "DELETE FROM nghanh WHERE id = :nghanh_id";
    $stmt = $conn->prepare($query);
    $stmt->execute([':nghanh_id' => $nghanh_id]);

    echo "Xóa nghành thành công!";
}
?>
