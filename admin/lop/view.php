<?php
//                       _oo0oo_
//                      o8888888o
//                      88" . "88
//                      (| -_- |)
//                      0\  =  /0
//                    ___/`---'\___
//                  .' \\|     |// '.
//                 / \\|||  :  |||// \
//                / _||||| -:- |||||- \
//               |   | \\\  -  /// |   |
//               | \_|  ''\---/''  |_/ |
//               \  .-\__  '-'  ___/-. /
//             ___'. .'  /--.--\  `. .'___
//          ."" '<  `.___\_<|>_/___.' >' "".
//         | | :  `- \`.;`\ _ /`;.`/ - ` : | |
//         \  \ `_.   \_ __\ /__ _/   .-` /  /
//     =====`-.____`.___ \_____/___.-`___.-'=====
//                       `=---='
//
//     ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//            amen đà phật copecute 
//     ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
require_once ($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/functions.php');


if (isset($_GET['id'])) {
    $id_lop = $_GET['id'];
    
// Truy vấn danh sách sinh viên trong lớp
$query = $conn->prepare("SELECT * FROM student_profiles WHERE id_lop = :id_lop");
$query->bindParam(':id_lop', $id_lop, PDO::PARAM_INT);
$query->execute();
$students = $query->fetchAll(PDO::FETCH_ASSOC);
renderHeader("Danh sách sinh viên trong lớp");
?>
    <div class="container mt-5">
        <h2>Danh Sách Sinh Viên Trong Lớp</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Họ và Tên</th>
                    <th>Ngày Sinh</th>
                    <th>Địa Chỉ</th>
                    <th>Số Điện Thoại</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($students) > 0): ?>
                    <?php foreach ($students as $student): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($student['id']); ?></td>
                            <td><?php echo htmlspecialchars($student['fullname']); ?></td>
                            <td><?php echo htmlspecialchars($student['birthday']); ?></td>
                            <td><?php echo htmlspecialchars($student['address']); ?></td>
                            <td><?php echo htmlspecialchars($student['phone_number']); ?></td>
                            <!-- Các cột khác nếu cần -->
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5">Không có sinh viên nào trong lớp này.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
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