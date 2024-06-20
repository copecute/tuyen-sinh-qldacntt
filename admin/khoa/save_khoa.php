<?php
require_once ($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');

if ($_POST['action'] == 'add') {
    $ten_khoa = $_POST['ten_khoa'];

    try {
        $stmt = $conn->prepare("INSERT INTO khoa (ten_khoa) VALUES (:ten_khoa)");
        $stmt->bindParam(':ten_khoa', $ten_khoa);

        if ($stmt->execute()) {
            echo 'Thêm khoa thành công.';
        } else {
            throw new Exception('Thêm khoa thất bại.');
        }
    } catch (PDOException $e) {
        echo 'Thêm khoa thất bại: ' . $e->getMessage();
    } catch (Exception $e) {
        echo 'Thêm khoa thất bại: ' . $e->getMessage();
    }
} elseif ($_POST['action'] == 'edit') {
    $khoa_id = $_POST['edit_khoa_id'];
    $ten_khoa = $_POST['edit_ten_khoa'];

    try {
        $stmt = $conn->prepare("UPDATE khoa SET ten_khoa = :ten_khoa WHERE id = :khoa_id");
        $stmt->bindParam(':ten_khoa', $ten_khoa);
        $stmt->bindParam(':khoa_id', $khoa_id);

        if ($stmt->execute()) {
            echo 'Sửa khoa thành công.';
        } else {
            throw new Exception('Sửa khoa thất bại.');
        }
    } catch (PDOException $e) {
        echo 'Sửa khoa thất bại: ' . $e->getMessage();
    } catch (Exception $e) {
        echo 'Sửa khoa thất bại: ' . $e->getMessage();
    }
} elseif ($_POST['action'] == 'delete') {
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
