<?php
require_once ($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');

$response = [
    'status' => 'error',
    'message' => 'Gửi hồ sơ xét tuyển không thành công. Vui lòng thử lại.'
];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = $_POST['fullname'];
    $birthday = $_POST['birthday'];
    $permanent_residence = $_POST['permanent_residence'];
    $city = $_POST['city'];
    $district = $_POST['district'];
    $ward = $_POST['ward'];
    $phone_number = $_POST['phone_number'];
    $high_school = $_POST['high_school'];
    $you_are = $_POST['you_are'];
    $major = $_POST['nghanh_id'];
    
    try {
        // Kiểm tra xem số điện thoại đã tồn tại trong database hay chưa
        $sql_check_phone = "SELECT COUNT(*) AS count FROM admission_application WHERE phone_number = :phone_number";
        $stmt_check_phone = $conn->prepare($sql_check_phone);
        $stmt_check_phone->bindParam(':phone_number', $phone_number);
        $stmt_check_phone->execute();
        $result = $stmt_check_phone->fetch(PDO::FETCH_ASSOC);

        if ($result['count'] > 0) {
            // Nếu số điện thoại đã tồn tại, trả về thông báo lỗi
            $response = [
                'status' => 'error',
                'message' => 'Bạn đã gửi hồ sơ xét tuyển rồi, vui lòng tra cứu kết quả'
            ];
        } else {
            // Kiểm tra ngày tháng hiện tại nằm trong khoảng start_date và end_date
            $sql_check_date = "SELECT id FROM admissions_settings WHERE :current_date BETWEEN start_date AND end_date";
            $stmt_check_date = $conn->prepare($sql_check_date);
            $current_date = date('Y-m-d'); // Ngày hiện tại
            $stmt_check_date->bindParam(':current_date', $current_date);
            $stmt_check_date->execute();
            $settings_result = $stmt_check_date->fetch(PDO::FETCH_ASSOC);

            if (!$settings_result) {
                // Nếu không tìm thấy bản ghi thỏa điều kiện ngày tháng
                $response = [
                    'status' => 'error',
                    'message' => 'Hiện tại không trong thời gian nhận hồ sơ xét tuyển.'
                ];
            } else {
                // Lấy id_admissions_settings từ kết quả truy vấn
                $id_admissions_settings = $settings_result['id'];

                // Thực hiện chèn dữ liệu vào bảng admission_application
                $sql_insert = "INSERT INTO admission_application (fullname, birthday, permanent_residence, city,  district,  ward, phone_number, high_school, you_are, major, status, id_admissions_settings)
                               VALUES (:fullname, :birthday, :permanent_residence, :city, :district, :ward, :phone_number, :high_school, :you_are, :major, 0, :id_admissions_settings)";
                $stmt_insert = $conn->prepare($sql_insert);
                $stmt_insert->bindParam(':fullname', $fullname);
                $stmt_insert->bindParam(':birthday', $birthday);
                $stmt_insert->bindParam(':permanent_residence', $permanent_residence);
                $stmt_insert->bindParam(':city', $city);
                $stmt_insert->bindParam(':district', $district);
                $stmt_insert->bindParam(':ward', $ward);
                $stmt_insert->bindParam(':phone_number', $phone_number);
                $stmt_insert->bindParam(':high_school', $high_school);
                $stmt_insert->bindParam(':you_are', $you_are);
                $stmt_insert->bindParam(':major', $major);
                $stmt_insert->bindParam(':id_admissions_settings', $id_admissions_settings);
                $stmt_insert->execute();
                
                $response = [
                    'status' => 'success',
                    'message' => 'Đã gửi đơn thành công!'
                ];
            }
        }
    } catch (PDOException $e) {
        $response['message'] = 'Lỗi: ' . $e->getMessage();
    }
}

echo json_encode($response);
?>
