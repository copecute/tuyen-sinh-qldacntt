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
    $academic = isset($_POST['academic']) ? $_POST['academic'] : null;

    try {
        // Lấy giá trị academic của bản ghi cuối cùng
        $query = "SELECT academic FROM admissions_settings ORDER BY id DESC LIMIT 1";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $last_record = $stmt->fetch(PDO::FETCH_ASSOC);
        $last_academic = $last_record ? (int)$last_record['academic'] : 0;

        // Nếu academic không được gửi trong POST request thì tự động tăng giá trị
        if ($academic === null || $academic === "") {
            $academic = $last_academic + 1;
        }

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
                $stmt = $conn->prepare("INSERT INTO admissions_settings (academic, academic_year, max_students_per_class, start_date, end_date) VALUES (:academic, :academic_year, :max_students_per_class, :start_date, :end_date)");
                $stmt->bindParam(':academic', $academic, PDO::PARAM_INT);
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
} else {
    $response['message'] = 'Thiếu thông tin cần thiết để lưu bản ghi.';
}

echo json_encode($response);
?>
