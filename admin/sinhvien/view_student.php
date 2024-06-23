<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');

$id = isset($_GET['id']) ? $_GET['id'] : '';

$sql = "SELECT sp.*, sa.username FROM student_profiles sp 
        JOIN student_accounts sa ON sp.account_id = sa.account_id 
        WHERE sp.id = :id";
$stmt = $conn->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$stmt->execute();
$student = $stmt->fetch(PDO::FETCH_ASSOC);

if ($student) {
    echo json_encode($student);
} else {
    echo json_encode(['error' => 'Không tìm thấy sinh viên này.']);
}
?>
