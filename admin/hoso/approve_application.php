<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');

$id = $_POST['id'];

try {
    // Begin transaction
    $conn->beginTransaction();

    // Update status in admission_application table
    $query = $conn->prepare("UPDATE admission_application SET status = '1' WHERE id = :id");
    $query->bindParam(':id', $id, PDO::PARAM_INT);
    $query->execute();

    // Check if any row was affected by the update
    if ($query->rowCount() === 0) {
        throw new Exception('Không có hồ sơ nào được cập nhật.');
    }

    // Insert data into student_profiles table
    $insertQuery = $conn->prepare("INSERT INTO student_profiles (fullname, birthday, permanent_residence, phone_number, high_school, you_are, major, status)
                                  SELECT fullname, birthday, permanent_residence, phone_number, high_school, you_are, major, status
                                  FROM admission_application
                                  WHERE id = :id");
    $insertQuery->bindParam(':id', $id, PDO::PARAM_INT);
    $insertQuery->execute();

    // Check if any row was inserted into student_profiles
    if ($insertQuery->rowCount() === 0) {
        throw new Exception('Không thể chèn dữ liệu vào bảng student_profiles.');
    }

    // Commit transaction
    $conn->commit();

    // Return success message
    $response = array(
        'status' => 'success',
        'message' => 'Hồ sơ đã được phê duyệt thành công !'
    );
} catch (Exception $e) {
    // Rollback transaction on error
    $conn->rollback();

    // Return error message
    $response = array(
        'status' => 'error',
        'message' => 'Đã xảy ra lỗi khi phê duyệt hồ sơ. ' . $e->getMessage()
    );
}

// Send JSON response
header('Content-Type: application/json');
echo json_encode($response);
?>
