<?php
require_once ($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');

$action = isset($_POST['action']) ? $_POST['action'] : '';

if ($action == 'add') {
    $ten_lop = $_POST['ten_lop'];
    $nghanh_id = $_POST['nghanh_id'];

    $query = "INSERT INTO lop (ten_lop, nghanh_id) VALUES (:ten_lop, :nghanh_id)";
    $stmt = $conn->prepare($query);
    $stmt->execute([':ten_lop' => $ten_lop, ':nghanh_id' => $nghanh_id]);

    echo "Thêm lớp thành công!";
} elseif ($action == 'edit') {
    $ten_lop = $_POST['edit_ten_lop'];
    $nghanh_id = $_POST['edit_nghanh_id'];
    $lop_id = $_POST['edit_lop_id'];

    $query = "UPDATE lop SET ten_lop = :ten_lop, nghanh_id = :nghanh_id WHERE id = :lop_id";
    $stmt = $conn->prepare($query);
    $stmt->execute([':ten_lop' => $ten_lop, ':nghanh_id' => $nghanh_id, ':lop_id' => $lop_id]);

    echo "Sửa lớp thành công!";
}
?>
