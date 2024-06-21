<?php
require_once ($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');

$query = "SELECT * FROM khoa";
$stmt = $conn->prepare($query);
$stmt->execute();
$khoas = $stmt->fetchAll(PDO::FETCH_ASSOC);

$options = '<option value="">Chọn Khoa</option>';
foreach ($khoas as $khoa) {
    $options .= '<option value="' . $khoa['id'] . '">' . htmlspecialchars($khoa['ten_khoa']) . '</option>';
}

echo json_encode($options);
?>
