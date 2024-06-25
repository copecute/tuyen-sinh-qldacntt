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
        SELECT aa.*, asettings.academic, asettings.max_students_per_class, ng.ten_nghanh
        FROM admission_application aa
        INNER JOIN admissions_settings asettings ON aa.id_admissions_settings = asettings.id
        INNER JOIN nghanh ng ON aa.major = ng.id
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
    if (!isset($applicationData['academic']) || !isset($applicationData['ten_nghanh'])) {
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

    // Tạo tên lớp dựa trên academic và viết tắt của tên ngành
    $academic = $applicationData['academic'];
    $nghanh_ten = $applicationData['ten_nghanh'];
    $nghanh_viet_tat = implode('', array_map(function ($word) {
        return strtoupper($word[0]);
    }, explode(' ', $nghanh_ten)));

    // Kiểm tra xem có lớp hiện tại nào thỏa mãn không
    $lopQuery = $conn->prepare("
        SELECT l.id, l.ten_lop, COUNT(sp.id) AS student_count
        FROM lop l
        LEFT JOIN student_profiles sp ON l.id = sp.id_lop
        WHERE l.ten_lop LIKE :ten_lop
        GROUP BY l.id, l.ten_lop
        ORDER BY l.ten_lop ASC
    ");
    $ten_lop = $academic . $nghanh_viet_tat . '%';
    $lopQuery->bindParam(':ten_lop', $ten_lop, PDO::PARAM_STR);
    $lopQuery->execute();
    $lopData = $lopQuery->fetchAll(PDO::FETCH_ASSOC);

    $lop_id = null;
    $lop_so_thu_tu = 1;

    foreach ($lopData as $lop) {
        if ($lop['student_count'] < $applicationData['max_students_per_class']) {
            $lop_id = $lop['id'];
            break;
        }
        $lop_so_thu_tu++;
    }

    // Nếu không có lớp nào thỏa mãn, tạo lớp mới
    if ($lop_id === null) {
        $new_lop_ten = $academic . $nghanh_viet_tat . $lop_so_thu_tu;
        $insertLopQuery = $conn->prepare("INSERT INTO lop (ten_lop, nghanh_id) VALUES (:ten_lop, :nghanh_id)");
        $insertLopQuery->bindParam(':ten_lop', $new_lop_ten, PDO::PARAM_STR);
        $insertLopQuery->bindParam(':nghanh_id', $applicationData['major'], PDO::PARAM_INT);
        $insertLopQuery->execute();
        $lop_id = $conn->lastInsertId();

        if (!$lop_id) {
            throw new Exception('Không thể tạo lớp mới.');
        }
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
        INSERT INTO student_profiles (account_id, fullname, birthday, permanent_residence, phone_number, high_school, id_nghanh, id_lop)
        VALUES (:account_id, :fullname, :birthday, :permanent_residence, :phone_number, :high_school, :major, :id_lop)
    ");
    $insertProfileQuery->bindParam(':account_id', $account_id, PDO::PARAM_INT);
    $insertProfileQuery->bindParam(':fullname', $applicationData['fullname'], PDO::PARAM_STR);
    $insertProfileQuery->bindParam(':birthday', $applicationData['birthday'], PDO::PARAM_STR);
    $insertProfileQuery->bindParam(':permanent_residence', $applicationData['permanent_residence'], PDO::PARAM_STR);
    $insertProfileQuery->bindParam(':phone_number', $applicationData['phone_number'], PDO::PARAM_STR);
    $insertProfileQuery->bindParam(':high_school', $applicationData['high_school'], PDO::PARAM_STR);
    $insertProfileQuery->bindParam(':major', $applicationData['major'], PDO::PARAM_INT);
    $insertProfileQuery->bindParam(':id_lop', $lop_id, PDO::PARAM_INT);
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
        'message' => 'Hồ sơ đã được phê duyệt thành công!'
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
