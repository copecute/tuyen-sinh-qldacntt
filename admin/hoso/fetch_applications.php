<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');

$query = $conn->query("SELECT * FROM admission_application");
$applications = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Họ và Tên</th>
            <th>Ngày Sinh</th>
            <th>Chuyên Ngành</th>
            <th>Trạng Thái</th>
            <th>Hành Động</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($applications as $application): ?>
            <tr>
                <td><?php echo $application['id']; ?></td>
                <td><?php echo htmlspecialchars($application['fullname']); ?></td>
                <td><?php echo htmlspecialchars($application['birthday']); ?></td>
                <td><?php echo htmlspecialchars($application['major']); ?></td>
                <td><?php echo htmlspecialchars($application['status']); ?></td>
                <td>
                    <button class="btn btn-info view-btn" data-toggle="modal" data-target="#viewModal" data-id="<?php echo $application['id']; ?>">Xem</button>
                    <button class="btn btn-success approve-btn" data-id="<?php echo $application['id']; ?>">Phê Duyệt</button>
                    <button class="btn btn-danger delete-btn" data-id="<?php echo $application['id']; ?>">Xóa</button>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
