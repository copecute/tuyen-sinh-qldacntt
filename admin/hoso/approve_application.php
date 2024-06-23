<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');

// Kiểm tra xem có dữ liệu ID được gửi từ client không
if (!isset($_POST['id'])) {
    $response = [
        'status' => 'error',
        'message' => 'Không có ID hồ sơ được cung cấp.'
    ];
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}

$id = $_POST['id'];

try {
    $conn->beginTransaction();

    // Sử dụng JOIN để lấy dữ liệu từ admission_application và admissions_settings
    $fetchApplicationQuery = $conn->prepare("
        SELECT aa.*, asettings.academic
        FROM admission_application aa
        INNER JOIN admissions_settings asettings ON aa.id_admissions_settings = asettings.id
        WHERE aa.id = :id
    ");
    $fetchApplicationQuery->bindParam(':id', $id, PDO::PARAM_INT);
    $fetchApplicationQuery->execute();
    $applicationData = $fetchApplicationQuery->fetch(PDO::FETCH_ASSOC);

    // Kiểm tra xem có tồn tại hồ sơ không
    if (!$applicationData) {
        throw new Exception('Không tìm thấy hồ sơ với ID đã cho.');
    }

    // Tạo username và password từ thông tin hồ sơ
    if (!isset($applicationData['academic']) || !isset($applicationData['major'])) {
        throw new Exception('Dữ liệu hồ sơ không đầy đủ.');
    }

    $username = $applicationData['academic'] . $applicationData['major'] . $id;
    $hashedPassword = password_hash($username, PASSWORD_DEFAULT);

    // Chèn vào bảng student_accounts
    $insertAccountQuery = $conn->prepare("INSERT INTO student_accounts (username, password) VALUES (:username, :password)");
    $insertAccountQuery->bindParam(':username', $username, PDO::PARAM_STR);
    $insertAccountQuery->bindParam(':password', $hashedPassword, PDO::PARAM_STR);
    $insertAccountQuery->execute();

    // Lấy ID của bản ghi vừa chèn vào bảng student_accounts
    $account_id = $conn->lastInsertId();

    // Kiểm tra xem có chèn thành công vào bảng student_accounts không
    if (!$account_id) {
        throw new Exception('Không thể chèn dữ liệu vào bảng student_accounts.');
    }

    // Cập nhật trạng thái trong bảng admission_application thành '1'
    $updateQuery = $conn->prepare("UPDATE admission_application SET status = '1' WHERE id = :id");
    $updateQuery->bindParam(':id', $id, PDO::PARAM_INT);
    $updateQuery->execute();

    // Kiểm tra xem có cập nhật thành công không
    if ($updateQuery->rowCount() === 0) {
        throw new Exception('Không có hồ sơ nào được cập nhật.');
    }

    // Chèn dữ liệu từ admission_application vào bảng student_profiles
    $insertProfileQuery = $conn->prepare("
        INSERT INTO student_profiles (account_id, fullname, birthday, permanent_residence, phone_number, high_school, id_nghanh)
        VALUES (:account_id, :fullname, :birthday, :permanent_residence, :phone_number, :high_school, :major)
    ");
    $insertProfileQuery->bindParam(':account_id', $account_id, PDO::PARAM_INT);
    $insertProfileQuery->bindParam(':fullname', $applicationData['fullname'], PDO::PARAM_STR);
    $insertProfileQuery->bindParam(':birthday', $applicationData['birthday'], PDO::PARAM_STR);
    $insertProfileQuery->bindParam(':permanent_residence', $applicationData['permanent_residence'], PDO::PARAM_STR);
    $insertProfileQuery->bindParam(':phone_number', $applicationData['phone_number'], PDO::PARAM_STR);
    $insertProfileQuery->bindParam(':high_school', $applicationData['high_school'], PDO::PARAM_STR);
    $insertProfileQuery->bindParam(':major', $applicationData['major'], PDO::PARAM_INT);
    $insertProfileQuery->execute();

    // Kiểm tra xem có chèn thành công vào bảng student_profiles không
    if ($insertProfileQuery->rowCount() === 0) {
        throw new Exception('Không thể chèn dữ liệu vào bảng student_profiles.');
    }

    // Hoàn thành giao dịch
    $conn->commit();

    // Trả về thông báo thành công
    $response = [
        'status' => 'success',
        'message' => 'Hồ sơ đã được phê duyệt thành công !'
    ];
} catch (Exception $e) {
    // Quay lại trạng thái trước đó nếu có lỗi
    $conn->rollback();

    // Trả về thông báo lỗi chi tiết
    $response = [
        'status' => 'error',
        'message' => 'Đã xảy ra lỗi khi phê duyệt hồ sơ. ' . $e->getMessage()
    ];
}

// Trả về kết quả dưới dạng JSON
header('Content-Type: application/json');
echo json_encode($response);
?>
