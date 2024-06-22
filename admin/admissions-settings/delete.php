<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');

$response = [
    'status' => 'error',
    'message' => 'Xóa không thành công. Vui lòng thử lại.'
];

if (isset($_POST['id'])) {
    $id = $_POST['id'];

    try {
        $stmt = $conn->prepare("DELETE FROM admissions_settings WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount()) {
            $response = [
                'status' => 'success',
                'message' => 'Xóa thành công!'
            ];
        }
    } catch (Exception $e) {
        $response['message'] = 'Lỗi: ' . $e->getMessage();
    }
}

echo json_encode($response);
?>
