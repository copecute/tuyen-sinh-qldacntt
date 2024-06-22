<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');

$response = [
    'status' => 'error',
    'message' => 'Lưu bản ghi không thành công. Vui lòng thử lại.'
];

if (isset($_POST['start_year'], $_POST['end_year'], $_POST['max_students_per_class'], $_POST['start_date'], $_POST['end_date'])) {
    $id = isset($_POST['id']) ? $_POST['id'] : null;
    $start_year = $_POST['start_year'];
    $end_year = $_POST['end_year'];
    $academic_year = $start_year . ' - ' . $end_year;
    $max_students_per_class = $_POST['max_students_per_class'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    // Kiểm tra ngày kết thúc phải lớn hơn hoặc bằng ngày bắt đầu
    if (strtotime($end_date) < strtotime($start_date)) {
        $response['message'] = 'Ngày kết thúc phải lớn hơn hoặc bằng ngày bắt đầu.';
        echo json_encode($response);
        exit;
    }

    try {
        // Kiểm tra trùng lặp thời gian với các bản ghi khác
        $query = "SELECT * FROM admissions_settings WHERE (:start_date BETWEEN start_date AND end_date OR :end_date BETWEEN start_date AND end_date OR start_date BETWEEN :start_date AND :end_date OR end_date BETWEEN :start_date AND :end_date)";
        if ($id) {
            $query .= " AND id != :id";
        }
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':start_date', $start_date, PDO::PARAM_STR);
        $stmt->bindParam(':end_date', $end_date, PDO::PARAM_STR);
        if ($id) {
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        }
        $stmt->execute();
        $duplicate = $stmt->fetch();

        if ($duplicate) {
            $response['message'] = 'Khoảng thời gian này trùng với đợt tuyển sinh khác.';
        } else {
            if ($id) {
                // Cập nhật bản ghi hiện có
                $stmt = $conn->prepare("UPDATE admissions_settings SET academic_year = :academic_year, max_students_per_class = :max_students_per_class, start_date = :start_date, end_date = :end_date WHERE id = :id");
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            } else {
                // Thêm bản ghi mới
                $stmt = $conn->prepare("INSERT INTO admissions_settings (academic_year, max_students_per_class, start_date, end_date) VALUES (:academic_year, :max_students_per_class, :start_date, :end_date)");
            }

            $stmt->bindParam(':academic_year', $academic_year, PDO::PARAM_STR);
            $stmt->bindParam(':max_students_per_class', $max_students_per_class, PDO::PARAM_INT);
            $stmt->bindParam(':start_date', $start_date, PDO::PARAM_STR);
            $stmt->bindParam(':end_date', $end_date, PDO::PARAM_STR);

            if ($stmt->execute()) {
                $response = [
                    'status' => 'success',
                    'message' => 'Lưu bản ghi thành công!'
                ];
            }
        }
    } catch (Exception $e) {
        $response['message'] = 'Lỗi: ' . $e->getMessage();
    }
}

echo json_encode($response);
?>
