<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');

// Thiết lập số bản ghi trên mỗi trang
$records_per_page = 10;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$query = isset($_GET['query']) ? $_GET['query'] : '';
$start_from = ($page - 1) * $records_per_page;

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conn->prepare("SELECT *, SUBSTRING_INDEX(academic_year, ' - ', 1) AS start_year, SUBSTRING_INDEX(academic_year, ' - ', -1) AS end_year FROM admissions_settings WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    echo json_encode($row);
    exit();
}

$total_records = $conn->query("SELECT COUNT(*) FROM admissions_settings WHERE academic_year LIKE '%$query%'")->fetchColumn();
$total_pages = ceil($total_records / $records_per_page);

$stmt = $conn->prepare("SELECT * FROM admissions_settings WHERE academic_year LIKE :query ORDER BY id DESC LIMIT :start_from, :records_per_page");
$stmt->bindValue(':query', '%' . $query . '%', PDO::PARAM_STR);
$stmt->bindValue(':start_from', $start_from, PDO::PARAM_INT);
$stmt->bindValue(':records_per_page', $records_per_page, PDO::PARAM_INT);
$stmt->execute();
$settings = $stmt->fetchAll(PDO::FETCH_ASSOC);

$table = '';
foreach ($settings as $setting) {
    $table .= '<tr>
        <td>' . htmlspecialchars($setting['id']) . '</td>
        <td>' . htmlspecialchars($setting['academic_year']) . '</td>
        <td>' . htmlspecialchars($setting['academic']) . '</td>
        <td>' . htmlspecialchars($setting['max_students_per_class']) . '</td>
        <td>' . htmlspecialchars($setting['start_date']) . '</td>
        <td>' . htmlspecialchars($setting['end_date']) . '</td>
        <td>
            <button class="btn btn-info view-btn" data-id="' . htmlspecialchars($setting['id']) . '">Xem</button>
            <button class="btn btn-warning edit-btn" data-id="' . htmlspecialchars($setting['id']) . '">Sửa</button>
            <button class="btn btn-danger delete-btn" data-id="' . htmlspecialchars($setting['id']) . '">Xóa</button>
        </td>
    </tr>';
}

$pagination = '';
for ($i = 1; $i <= $total_pages; $i++) {
    $pagination .= '<li class="page-item"><a class="page-link" href="#" data-page="' . $i . '">' . $i . '</a></li>';
}

$response = [
    'table' => $table,
    'pagination' => $pagination
];

echo json_encode($response);
?>
