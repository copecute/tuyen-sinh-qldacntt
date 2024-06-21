<?php
require_once ($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');

$search = isset($_POST['search']) ? $_POST['search'] : '';
$page = isset($_POST['page']) ? $_POST['page'] : 1;
$nghanh_id = isset($_POST['nghanh_id']) ? $_POST['nghanh_id'] : null;
$limit = 10; // Số lượng lớp trên mỗi trang
$offset = ($page - 1) * $limit;

$query = "SELECT lop.*, nghanh.ten_nghanh 
          FROM lop 
          LEFT JOIN nghanh ON lop.nghanh_id = nghanh.id 
          WHERE lop.ten_lop LIKE :search";
$params = [':search' => '%' . $search . '%'];

if ($nghanh_id) {
    $query .= " AND nghanh_id = :nghanh_id";
    $params[':nghanh_id'] = $nghanh_id;
}

$query .= " LIMIT $limit OFFSET $offset";
$stmt = $conn->prepare($query);
$stmt->execute($params);

$lops = $stmt->fetchAll(PDO::FETCH_ASSOC);

$query = "SELECT COUNT(*) FROM lop WHERE ten_lop LIKE :search";
if ($nghanh_id) {
    $query .= " AND nghanh_id = :nghanh_id";
}

$stmt = $conn->prepare($query);
$stmt->execute($params);
$total_lops = $stmt->fetchColumn();
$total_pages = ceil($total_lops / $limit);
?>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Tên Lớp</th>
            <th>Ngành</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($lops as $lop) { ?>
            <tr>
                <td><?= htmlspecialchars($lop['ten_lop']) ?></td>
                <td><?= htmlspecialchars($lop['ten_nghanh']) ?></td>
                <td>
                    <button class="btn btn-primary btn-sm editLopBtn" data-id="<?= $lop['id'] ?>">Sửa</button>
                    <button class="btn btn-danger btn-sm deleteLopBtn" data-id="<?= $lop['id'] ?>">Xóa</button>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>
<nav>
    <ul class="pagination">
        <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
            <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                <a class="page-link" href="javascript:void(0)" data-page="<?= $i ?>"><?= $i ?></a>
            </li>
        <?php } ?>
    </ul>
</nav>
<script>
    $('.pagination a').click(function () {
        var page = $(this).data('page');
        loadLops($('#searchInput').val(), page);
    });
</script>
