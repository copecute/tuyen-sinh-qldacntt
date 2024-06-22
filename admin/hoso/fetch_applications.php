<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');

// Số lượng hồ sơ trên mỗi trang
$records_per_page = 10;

// Xác định trang hiện tại
$page = isset($_POST['page']) ? $_POST['page'] : 1;

// Tính offset
$start_from = ($page - 1) * $records_per_page;

// Lấy điều kiện tìm kiếm từ request POST
$search = isset($_POST['search']) ? $_POST['search'] : '';

// Lấy điều kiện lọc trạng thái từ request POST
$filterStatus = isset($_POST['filterStatus']) ? $_POST['filterStatus'] : '';

// Lấy điều kiện lọc chuyên ngành từ request POST
$filterMajor = isset($_POST['filterMajor']) ? $_POST['filterMajor'] : '';

// Query lấy danh sách hồ sơ với phân trang, điều kiện tìm kiếm và lọc trạng thái, chuyên ngành
$query = "SELECT a.id, a.fullname, a.birthday, COALESCE(n.ten_nghanh, a.major) AS chuyen_nganh, a.status
          FROM admission_application a
          LEFT JOIN nghanh n ON a.major = n.id
          WHERE (a.fullname LIKE :search OR a.birthday LIKE :search OR COALESCE(n.ten_nghanh, a.major) LIKE :search)
          AND (:filterStatus = '' OR a.status = :filterStatus)
          AND (:filterMajor = '' OR a.major = :filterMajor)
          ORDER BY a.id DESC
          LIMIT $start_from, $records_per_page";

// Bind parameters
$params = [
    ':search' => '%' . $search . '%',
    ':filterStatus' => $filterStatus,
    ':filterMajor' => $filterMajor,
];

$stmt = $conn->prepare($query);
$stmt->execute($params);

$applications = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Tính tổng số hồ sơ
$countQuery = "SELECT COUNT(*) FROM admission_application
               WHERE (fullname LIKE :search OR birthday LIKE :search OR major LIKE :search)
               AND (:filterStatus = '' OR status = :filterStatus)
               AND (:filterMajor = '' OR major = :filterMajor)";
$countStmt = $conn->prepare($countQuery);
$countStmt->execute($params);
$totalRecords = $countStmt->fetchColumn();

// Tính số trang
$totalPages = ceil($totalRecords / $records_per_page);

// HTML cho bảng danh sách hồ sơ
echo '<table class="table table-bordered">';
echo '<thead>';
echo '<tr>';
echo '<th>ID</th>';
echo '<th>Họ và Tên</th>';
echo '<th>Ngày Sinh</th>';
echo '<th>Chuyên Ngành</th>';
echo '<th>Trạng Thái</th>';
echo '<th>Hành Động</th>';
echo '</tr>';
echo '</thead>';
echo '<tbody>';

if ($stmt->rowCount() > 0) {
    foreach ($applications as $application) {
        echo '<tr>';
        echo '<td>' . $application['id'] . '</td>';
        echo '<td>' . htmlspecialchars($application['fullname']) . '</td>';
        echo '<td>' . htmlspecialchars($application['birthday']) . '</td>';
        echo '<td>' . htmlspecialchars($application['chuyen_nganh']) . '</td>';
        echo '<td>';

        // Xử lý hiển thị trạng thái
        $status = '';
        $statusClass = '';
        switch ($application['status']) {
            case '0':
                $status = 'Đang chờ xét duyệt';
                $statusClass = 'text-info';
                break;
            case '1':
                $status = 'Đủ điều kiện nhập học';
                $statusClass = 'text-success';
                break;
            case '2':
                $status = 'Bị từ chối';
                $statusClass = 'text-danger';
                break;
            default:
                $status = 'Không xác định';
                break;
        }

        echo '<span class="' . $statusClass . '">' . htmlspecialchars($status) . '</span>';
        echo '</td>';
        echo '<td>';
        echo '<button class="btn btn-info view-btn" data-toggle="modal" data-target="#viewModal" data-id="' . $application['id'] . '">Xem</button> ';
        echo '<button class="btn btn-danger delete-btn" data-id="' . $application['id'] . '">Xóa</button>';
        echo '</td>';
        echo '</tr>';
    }
} else {
    echo '<tr><td colspan="6">Không có dữ liệu hồ sơ.</td></tr>';
}

echo '</tbody>';
echo '</table>';

// Nút phân trang
echo '<nav>';
echo '<ul class="pagination">';
if ($page > 1) {
    echo '<li class="page-item"><a class="page-link" href="#" data-page="' . ($page - 1) . '">Trang trước</a></li>';
}
for ($i = 1; $i <= $totalPages; $i++) {
    if ($i == $page) {
        echo '<li class="page-item active"><a class="page-link" href="#" data-page="' . $i . '">' . $i . '</a></li>';
    } else {
        echo '<li class="page-item"><a class="page-link" href="#" data-page="' . $i . '">' . $i . '</a></li>';
    }
}
if ($page < $totalPages) {
    echo '<li class="page-item"><a class="page-link" href="#" data-page="' . ($page + 1) . '">Trang sau</a></li>';
}
echo '</ul>';
echo '</nav>';
?>
