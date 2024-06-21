<?php
require_once ($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');

if (isset($_POST['id'])) {
    $lop_id = $_POST['id'];

    $query = "SELECT lop.*, nghanh.khoa_id 
              FROM lop 
              LEFT JOIN nghanh ON lop.nghanh_id = nghanh.id 
              WHERE lop.id = :lop_id";
    $stmt = $conn->prepare($query);
    $stmt->execute([':lop_id' => $lop_id]);

    $lop = $stmt->fetch(PDO::FETCH_ASSOC);
    echo json_encode($lop);
}
?>
