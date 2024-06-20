<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');

$id = $_POST['id'];
$query = $conn->prepare("SELECT * FROM admission_application WHERE id = :id");
$query->bindParam(':id', $id, PDO::PARAM_INT);
$query->execute();
$application = $query->fetch(PDO::FETCH_ASSOC);
?>

<div class="modal-header">
    <h5 class="modal-title" id="viewModalLabel">Chi Tiết Hồ Sơ</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <p><strong>ID:</strong> <?php echo $application['id']; ?></p>
    <p><strong>Họ và Tên:</strong> <?php echo htmlspecialchars($application['fullname']); ?></p>
    <p><strong>Ngày Sinh:</strong> <?php echo htmlspecialchars($application['birthday']); ?></p>
    <p><strong>Chuyên Ngành:</strong> <?php echo htmlspecialchars($application['major']); ?></p>
    <p><strong>Trạng Thái:</strong> <?php echo htmlspecialchars($application['status']); ?></p>
    <p><strong>Hộ Khẩu Thường Trú:</strong> <?php echo htmlspecialchars($application['permanent_residence']); ?></p>
    <p><strong>Số Điện Thoại:</strong> <?php echo htmlspecialchars($application['phone_number']); ?></p>
    <p><strong>Trường THPT:</strong> <?php echo htmlspecialchars($application['high_school']); ?></p>
    <p><strong>Bạn Là:</strong> <?php echo htmlspecialchars($application['you_are']); ?></p>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
    <button type="button" class="btn btn-primary" onclick="printApplication()">In</button>
</div>

<script>
    function printApplication() {
        var printContents = document.querySelector('.modal-body').innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;

        window.print();

        document.body.innerHTML = originalContents;
        location.reload();
    }
</script>
