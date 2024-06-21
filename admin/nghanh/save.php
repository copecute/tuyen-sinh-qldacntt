<?php
require_once ($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');

$action = isset($_POST['action']) ? $_POST['action'] : '';

if ($action == 'add') {
    $ten_nghanh = $_POST['ten_nghanh'];
    $khoa_id = $_POST['khoa_id'];

    $query = "INSERT INTO nghanh (ten_nghanh, khoa_id) VALUES (:ten_nghanh, :khoa_id)";
    $stmt = $conn->prepare($query);
    $stmt->execute([':ten_nghanh' => $ten_nghanh, ':khoa_id' => $khoa_id]);

    echo "Thêm nghành thành công!";
} elseif ($action == 'edit') {
    $ten_nghanh = $_POST['edit_ten_nghanh'];
    $nghanh_id = $_POST['edit_nghanh_id'];
    $new_khoa_id = $_POST['edit_khoa_id'];

    // Kiểm tra xem có thay đổi khoa hay không
    $query_check_khoa = "SELECT khoa_id FROM nghanh WHERE id = :nghanh_id";
    $stmt_check_khoa = $conn->prepare($query_check_khoa);
    $stmt_check_khoa->execute([':nghanh_id' => $nghanh_id]);
    $current_khoa_id = $stmt_check_khoa->fetchColumn();

    if ($new_khoa_id != $current_khoa_id) {
        // Nếu có thay đổi khoa, cập nhật lại khoa_id của nghành
        $query_update_khoa = "UPDATE nghanh SET khoa_id = :khoa_id WHERE id = :nghanh_id";
        $stmt_update_khoa = $conn->prepare($query_update_khoa);
        $stmt_update_khoa->execute([':khoa_id' => $new_khoa_id, ':nghanh_id' => $nghanh_id]);
    }

    // Tiếp tục cập nhật tên nghành (nếu có thay đổi)
    $query_update_ten = "UPDATE nghanh SET ten_nghanh = :ten_nghanh WHERE id = :nghanh_id";
    $stmt_update_ten = $conn->prepare($query_update_ten);
    $stmt_update_ten->execute([':ten_nghanh' => $ten_nghanh, ':nghanh_id' => $nghanh_id]);

    echo "Sửa nghành thành công!";
}
?>
