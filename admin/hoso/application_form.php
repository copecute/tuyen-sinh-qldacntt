<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');

$action = $_POST['action'];
$id = isset($_POST['id']) ? $_POST['id'] : '';
$application = [
    'fullname' => '',
    'birthday' => '',
    'major' => '',
    'status' => '',
    'permanent_residence' => '',
    'phone_number' => '',
    'high_school' => '',
    'you_are' => ''
];

if ($action == 'edit' && $id) {
    $query = $conn->prepare("SELECT * FROM admission_application WHERE id = :id");
    $query->bindParam(':id', $id, PDO::PARAM_INT);
    $query->execute();
    $application = $query->fetch(PDO::FETCH_ASSOC);
}
?>

<div class="modal-header">
    <h5 class="modal-title" id="addModalLabel"><?php echo $action == 'add' ? 'Thêm Hồ Sơ' : 'Sửa Hồ Sơ'; ?></h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <form id="application-form">
        <input type="hidden" name="action" value="<?php echo $action; ?>">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <div class="form-group">
            <label for="fullname">Họ và Tên</label>
            <input type="text" class="form-control" id="fullname" name="fullname" value="<?php echo htmlspecialchars($application['fullname']); ?>" required>
        </div>
        <div class="form-group">
            <label for="birthday">Ngày Sinh</label>
            <input type="date" class="form-control" id="birthday" name="birthday" value="<?php echo htmlspecialchars($application['birthday']); ?>" required>
        </div>
        <div class="form-group">
            <label for="major">Chuyên Ngành</label>
            <input type="text" class="form-control" id="major" name="major" value="<?php echo htmlspecialchars($application['major']); ?>" required>
        </div>
        <div class="form-group">
            <label for="status">Trạng Thái</label>
            <select class="form-control" id="status" name="status" required>
                <option value="0" <?php echo $application['status'] == '0' ? 'selected' : ''; ?>>Chờ Duyệt</option>
                <option value="1" <?php echo $application['status'] == '1' ? 'selected' : ''; ?>>Phê Duyệt</option>
                <option value="2" <?php echo $application['status'] == '2' ? 'selected' : ''; ?>>Từ Chối</option>
            </select>
        </div>
        <div class="form-group">
            <label for="permanent_residence">Hộ Khẩu Thường Trú</label>
            <input type="text" class="form-control" id="permanent_residence" name="permanent_residence" value="<?php echo htmlspecialchars($application['permanent_residence']); ?>" required>
        </div>
        <div class="form-group">
            <label for="phone_number">Số Điện Thoại</label>
            <input type="text" class="form-control" id="phone_number" name="phone_number" value="<?php echo htmlspecialchars($application['phone_number']); ?>" required>
        </div>
        <div class="form-group">
            <label for="high_school">Trường THPT</label>
            <input type="text" class="form-control" id="high_school" name="high_school" value="<?php echo htmlspecialchars($application['high_school']); ?>" required>
        </div>
        <div class="form-group">
            <label for="you_are">Bạn Là</label>
            <input type="text" class="form-control" id="you_are" name="you_are" value="<?php echo htmlspecialchars($application['you_are']); ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Lưu</button>
    </form>
</div>

<script>
    $('#application-form').on('submit', function (e) {
        e.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            type: 'POST',
            url: 'save_application.php',
            data: formData,
            success: function (response) {
                $('#addModal').modal('hide');
                loadApplications();
            }
        });
    });
</script>
