<?php
require_once ($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');

$limit = 10; // Số lượng sinh viên mỗi trang
$page = isset($_POST['page']) ? $_POST['page'] : 1;
$search = isset($_POST['search']) ? $_POST['search'] : '';

// Tính offset
$offset = ($page - 1) * $limit;

// Truy vấn danh sách sinh viên với phân trang và tìm kiếm
$query = "SELECT sp.id, sp.fullname, sp.birthday, sp.permanent_residence, sp.phone_number, sa.username 
          FROM student_profiles sp 
          INNER JOIN student_accounts sa ON sp.account_id = sa.account_id 
          WHERE sp.fullname LIKE :search 
          ORDER BY sp.id ASC 
          LIMIT :limit OFFSET :offset";
$stmt = $conn->prepare($query);
$stmt->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$students = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Đếm tổng số sinh viên
$queryCount = "SELECT COUNT(*) AS total FROM student_profiles WHERE fullname LIKE :search";
$stmtCount = $conn->prepare($queryCount);
$stmtCount->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
$stmtCount->execute();
$rowCount = $stmtCount->fetch(PDO::FETCH_ASSOC);
$total = $rowCount['total'];

// Hiển thị danh sách sinh viên
if ($students) {
    echo '<table class="table table-striped">';
    echo '<thead>
            <tr>
                <th>#</th>
                <th>Họ và Tên</th>
                <th>Ngày sinh</th>
                <th>Địa chỉ</th>
                <th>Số điện thoại</th>
                <th>Username</th>
                <th>Thao tác</th>
            </tr>
          </thead>';
    echo '<tbody>';
    foreach ($students as $student) {
        echo '<tr>';
        echo '<td>' . htmlspecialchars($student['id']) . '</td>';
        echo '<td>' . htmlspecialchars($student['fullname']) . '</td>';
        echo '<td>' . htmlspecialchars($student['birthday']) . '</td>';
        echo '<td>' . htmlspecialchars($student['permanent_residence']) . '</td>';
        echo '<td>' . htmlspecialchars($student['phone_number']) . '</td>';
        echo '<td>' . htmlspecialchars($student['username']) . '</td>';
        echo '<td>
                    <a href="view.php?id=' . $student['id'] . '" class="btn btn-info btn-sm">Xem</a>
                <a href="edit.php?id=' . $student['id'] . '" class="btn btn-sm btn-info">Sửa</a>
                <button type="button" class="btn btn-sm btn-danger delete-btn" data-id="' . $student['id'] . '">Xóa</button>
              </td>';
        echo '</tr>';
    }
    echo '</tbody>';
    echo '</table>';

    // Hiển thị phân trang
    $totalPages = ceil($total / $limit);
    echo '<ul class="pagination">';
    for ($i = 1; $i <= $totalPages; $i++) {
        echo '<li class="page-item ' . ($page == $i ? 'active' : '') . '"><a class="page-link" href="#" data-page="' . $i . '">' . $i . '</a></li>';
    }
    echo '</ul>';
} else {
    echo '<p>Không tìm thấy sinh viên nào.</p>';
}
?>