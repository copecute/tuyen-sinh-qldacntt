<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');

$response = [
    'status' => 'error',
    'message' => 'Xoá sinh viên không thành công.'
];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];

    try {
        $stmt = $conn->prepare("DELETE FROM student_profiles WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $response = [
                'status' => 'success',
                'message' => 'Xoá sinh viên thành công!'
            ];
        }
    } catch (Exception $e) {
        $response['message'] = 'Lỗi: ' . $e->getMessage();
    }
}

echo json_encode($response);
?>
