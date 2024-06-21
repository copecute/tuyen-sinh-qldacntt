<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');

$id = $_POST['id'];

try {
    // Bắt đầu transaction
    $conn->beginTransaction();

    // Cập nhật trạng thái trong bảng admission_application nếu chưa được từ chối
    $query = $conn->prepare("UPDATE admission_application SET status = '2' WHERE id = :id AND status <> '2'");
    $query->bindParam(':id', $id, PDO::PARAM_INT);
    $query->execute();

    // Kiểm tra và trả về phản hồi dựa trên kết quả cập nhật
    if ($query->rowCount() > 0) {
        // Nếu cập nhật thành công
        $response = array(
            'status' => 'success',
            'message' => 'Hồ sơ đã bị từ chối.'
        );
    } else {
        // Nếu đã từ chối sẵn
        $response = array(
            'status' => 'success',
            'message' => 'Hồ sơ đã bị từ chối.'
        );
    }

    // Commit transaction
    $conn->commit();
} catch (PDOException $e) {
    // Rollback transaction nếu có lỗi
    $conn->rollback();

    // Phản hồi lỗi
    $response = array(
        'status' => 'error',
        'message' => 'Đã xảy ra lỗi khi từ chối hồ sơ. Vui lòng thử lại.'
    );
}

// Trả về JSON response
header('Content-Type: application/json');
echo json_encode($response);
?>
