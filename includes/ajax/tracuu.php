<?php
require_once ($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');

$response = [
    'status' => 'error',
    'message' => 'Không có kết quả phù hợp.'
];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $phone_number = $_POST['phone_number'];

    try {
        $sql = "SELECT * FROM admission_application WHERE phone_number = :phone_number";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':phone_number', $phone_number);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            $response = [
                'status' => 'success',
                'message' => 'Đã tìm thấy hồ sơ!',
                'data' => $result
            ];
        } else {
            $response = [
                'status' => 'error',
                'message' => 'Không có kết quả phù hợp.'
            ];
        }
    } catch (PDOException $e) {
        $response['message'] = 'Lỗi: ' . $e->getMessage();
    }
}

echo json_encode($response);
?>
