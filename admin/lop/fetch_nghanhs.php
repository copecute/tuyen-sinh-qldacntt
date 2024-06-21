<?php
require_once ($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');

if (isset($_GET['khoa_id'])) {
    $khoa_id = $_GET['khoa_id'];

    $query = "SELECT * FROM nghanh WHERE khoa_id = :khoa_id";
    $stmt = $conn->prepare($query);
    $stmt->execute([':khoa_id' => $khoa_id]);
    $nghanhs = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $options = '<option value="">Chọn Ngành</option>';
    foreach ($nghanhs as $nghanh) {
        $options .= '<option value="' . $nghanh['id'] . '">' . htmlspecialchars($nghanh['ten_nghanh']) . '</option>';
    }

    echo json_encode($options);
}
?>
