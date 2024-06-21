<?php
require_once ($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');

// Số mục trên mỗi trang
$records_per_page = 10;

// Xác định trang hiện tại
$page = isset($_POST['page']) ? $_POST['page'] : 1;

// Tính vị trí bắt đầu của mục trong CSDL
$start_from = ($page - 1) * $records_per_page;

// Lấy ID khoa từ request
$khoa_id = isset($_POST['khoa_id']) ? $_POST['khoa_id'] : 0;

// Lọc tìm kiếm nếu có
$search = isset($_POST['search']) ? $_POST['search'] : '';

// Query lấy danh sách nghành với LIMIT và OFFSET
$query = "SELECT n.id, n.ten_nghanh, k.ten_khoa, n.khoa_id
          FROM nghanh n 
          LEFT JOIN khoa k ON n.khoa_id = k.id 
          WHERE (n.khoa_id = :khoa_id OR :khoa_id = 0) 
          AND n.ten_nghanh LIKE :search 
          LIMIT $start_from, $records_per_page";
$stmt = $conn->prepare($query);
$stmt->bindValue(':khoa_id', $khoa_id, PDO::PARAM_INT);
$stmt->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
$stmt->execute();
$nghanhs = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Tính tổng số trang
$query_count = "SELECT COUNT(*) AS total_rows 
                FROM nghanh 
                WHERE (khoa_id = :khoa_id OR :khoa_id = 0) 
                AND ten_nghanh LIKE :search";
$stmt_count = $conn->prepare($query_count);
$stmt_count->bindValue(':khoa_id', $khoa_id, PDO::PARAM_INT);
$stmt_count->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
$stmt_count->execute();
$row_count = $stmt_count->fetch(PDO::FETCH_ASSOC);
$total_rows = $row_count['total_rows'];
$total_pages = ceil($total_rows / $records_per_page);

echo '<table class="table table-bordered">';
echo '<thead>';
echo '<tr>';
echo '<th>ID</th>';
echo '<th>Tên Nghành</th>';
echo '<th>Tên Khoa</th>';
echo '<th>Hành động</th>';
echo '</tr>';
echo '</thead>';
echo '<tbody>';
if ($stmt->rowCount() > 0) {
    foreach ($nghanhs as $nghanh) {
        echo '<tr>';
        echo '<td>' . $nghanh['id'] . '</td>';
        echo '<td>' . $nghanh['ten_nghanh'] . '</td>';
        echo '<td>' . $nghanh['ten_khoa'] . '</td>';
        echo '<td>';
        echo '<button class="btn btn-primary edit-btn" data-nghanh_id="' . $nghanh['id'] . '" data-ten_nghanh="' . $nghanh['ten_nghanh'] . '" data-khoa_id="' . $nghanh['khoa_id'] . '">Sửa</button> ';
        echo '<button class="btn btn-danger delete-btn" data-nghanh_id="' . $nghanh['id'] . '">Xóa</button>';
        echo '</td>';
        echo '</tr>';
    }
} else {
    echo '<tr><td colspan="4">Không có dữ liệu nghành.</td></tr>';
}
echo '</tbody>';
echo '</table>';

// Nút phân trang
echo '<nav><ul class="pagination">';
if ($page > 1) {
    echo '<li class="page-item"><a class="page-link" href="#" data-page="' . ($page - 1) . '">Trang trước</a></li>';
}
for ($i = 1; $i <= $total_pages; $i++) {
    if ($i == $page) {
        echo '<li class="page-item active"><a class="page-link" href="#" data-page="' . $i . '">' . $i . '</a></li>';
    } else {
        echo '<li class="page-item"><a class="page-link" href="#" data-page="' . $i . '">' . $i . '</a></li>';
    }
}
if ($page < $total_pages) {
    echo '<li class="page-item"><a class="page-link" href="#" data-page="' . ($page + 1) . '">Trang sau</a></li>';
}
echo '</ul></nav>';
?>
