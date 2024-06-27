<?php
require_once ($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/functions.php');

if (isset($_GET['id'])) {
    $id_lop = $_GET['id'];

    // Thiết lập số sinh viên trên mỗi trang
    $studentsPerPage = 10;
    $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $offset = ($currentPage - 1) * $studentsPerPage;

    // Truy vấn danh sách sinh viên trong lớp với phân trang
    $query = $conn->prepare("
        SELECT student_accounts.username, student_profiles.*
        FROM student_profiles
        JOIN student_accounts ON student_profiles.account_id = student_accounts.account_id
        WHERE id_lop = :id_lop
        LIMIT :limit OFFSET :offset
    ");
    $query->bindParam(':id_lop', $id_lop, PDO::PARAM_INT);
    $query->bindParam(':limit', $studentsPerPage, PDO::PARAM_INT);
    $query->bindParam(':offset', $offset, PDO::PARAM_INT);
    $query->execute();
    $students = $query->fetchAll(PDO::FETCH_ASSOC);

    // Truy vấn tổng số sinh viên trong lớp để tính tổng số trang
    $countQuery = $conn->prepare("SELECT COUNT(*) FROM student_profiles WHERE id_lop = :id_lop");
    $countQuery->bindParam(':id_lop', $id_lop, PDO::PARAM_INT);
    $countQuery->execute();
    $totalStudents = $countQuery->fetchColumn();
    $totalPages = ceil($totalStudents / $studentsPerPage);

    renderHeader("Danh sách sinh viên trong lớp");
?>
    <div class="container mt-5">
        <h2>Danh Sách Sinh Viên Trong Lớp</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>MSSV</th>
                    <th>Họ và Tên</th>
                    <th>Ngày Sinh</th>
                    <th>Địa Chỉ</th>
                    <th>Số Điện Thoại</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($students) > 0): ?>
                    <?php 
                    $stt = $offset + 1;
                    foreach ($students as $student): ?>
                        <tr>
                            <td><?php echo $stt++; ?></td>
                            <td><?php echo htmlspecialchars($student['username']); ?></td>
                            <td><?php echo htmlspecialchars($student['fullname']); ?></td>
                            <td><?php echo htmlspecialchars($student['birthday']); ?></td>
                            <td><?php echo htmlspecialchars($student['permanent_residence']); ?></td>
                            <td><?php echo htmlspecialchars($student['phone_number']); ?></td>
                            <!-- Các cột khác nếu cần -->
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6">Không có sinh viên nào trong lớp này.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <!-- Điều hướng trang -->
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">
                <li class="page-item <?php if ($currentPage == 1) echo 'disabled'; ?>">
                    <a class="page-link" href="?id=<?php echo $id_lop; ?>&page=<?php echo $currentPage - 1; ?>">Previous</a>
                </li>
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <li class="page-item <?php if ($i == $currentPage) echo 'active'; ?>">
                        <a class="page-link" href="?id=<?php echo $id_lop; ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                    </li>
                <?php endfor; ?>
                <li class="page-item <?php if ($currentPage == $totalPages) echo 'disabled'; ?>">
                    <a class="page-link" href="?id=<?php echo $id_lop; ?>&page=<?php echo $currentPage + 1; ?>">Next</a>
                </li>
            </ul>
        </nav>
        <a href="/admin/lop" class="btn btn-secondary">Quay lại</a>
    </div>

    <!-- Include jQuery and Bootstrap JS if needed -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
<?php
    renderFooter();
} else {
    echo "ID lớp không hợp lệ.";
}
?>
