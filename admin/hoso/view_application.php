<?php
require_once ($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');

$id = $_POST['id'];
$query = $conn->prepare("SELECT * FROM admission_application WHERE id = :id");
$query->bindParam(':id', $id, PDO::PARAM_INT);
$query->execute();
$application = $query->fetch(PDO::FETCH_ASSOC);
?>

<div class="modal-body">
    <dl class="row">
        <dt class="col-sm-4">ID:</dt>
        <dd class="col-sm-8"><?php echo $application['id']; ?></dd>

        <dt class="col-sm-4">Họ và Tên:</dt>
        <dd class="col-sm-8"><?php echo htmlspecialchars($application['fullname']); ?></dd>

        <dt class="col-sm-4">Ngày Sinh:</dt>
        <dd class="col-sm-8"><?php echo htmlspecialchars($application['birthday']); ?></dd>

        <dt class="col-sm-4">Chuyên Ngành:</dt>
        <dd class="col-sm-8"><?php echo htmlspecialchars($application['major']); ?></dd>

        <dt class="col-sm-4">Trạng Thái:</dt>
        <dd class="col-sm-8"><?php echo htmlspecialchars($application['status']); ?></dd>

        <dt class="col-sm-4">Hộ Khẩu Thường Trú:</dt>
        <dd class="col-sm-8"><?php echo htmlspecialchars($application['permanent_residence']); ?></dd>

        <dt class="col-sm-4">Số Điện Thoại:</dt>
        <dd class="col-sm-8"><?php echo htmlspecialchars($application['phone_number']); ?></dd>

        <dt class="col-sm-4">Trường THPT:</dt>
        <dd class="col-sm-8"><?php echo htmlspecialchars($application['high_school']); ?></dd>

        <dt class="col-sm-4">Bạn Là:</dt>
        <dd class="col-sm-8"><?php echo htmlspecialchars($application['you_are']); ?></dd>
    </dl>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-success" onclick="approveApplication(<?php echo $application['id']; ?>)">Phê
        Duyệt</button>
    <button type="button" class="btn btn-danger" onclick="rejectApplication(<?php echo $application['id']; ?>)">Từ
        Chối</button>
    <button type="button" class="btn btn-primary" onclick="printApplication()">In</button>
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
</div>

<script>
    function printApplication() {
        var printContents = document.querySelector('.modal-body').innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;

        window.print();


        document.body.innerHTML = originalContents;
        $('#viewModal').modal('hide'); // Đóng modal
                    updateApplicationsList();

    }

    function approveApplication(id) {
    $.ajax({
        url: '/admin/hoso/approve_application.php',
        type: 'POST',
        data: { id: id },
        dataType: 'json',
        success: function (response) {
            if (response.status === 'success') {
                toastr.success(response.message);
                $('#viewModal').modal('hide');
                updateApplicationsList();
            } else {
                toastr.error(response.message);
            }
        },
        error: function (xhr, status, error) {
            console.error('Lỗi khi phê duyệt hồ sơ:', error);
            toastr.error('Đã xảy ra lỗi khi phê duyệt hồ sơ. Vui lòng thử lại.');
        }
    });
}




    function rejectApplication(id) {
        $.ajax({
            url: '/admin/hoso/reject_application.php',
            type: 'POST',
            data: { id: id },
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    toastr.success(response.message);
                    $('#viewModal').modal('hide'); // Đóng modal
                    updateApplicationsList(); // Gọi hàm để cập nhật danh sách hồ sơ
                } else {
                    toastr.error(response.message);
                }
            },
            error: function (xhr, status, error) {
                console.error('Lỗi khi từ chối hồ sơ:', error);
                toastr.error('Đã xảy ra lỗi khi từ chối hồ sơ. Vui lòng thử lại.');
            }
        });
    }

    function updateApplicationsList() {
        $.ajax({
            url: '/admin/hoso/fetch_applications.php',
            type: 'GET',
            success: function (response) {
                $('#applicationsTable').html(response); // Thay đổi nội dung danh sách hồ sơ
            },
            error: function (xhr, status, error) {
                console.error('Lỗi khi cập nhật danh sách hồ sơ:', error);
                toastr.error('Đã xảy ra lỗi khi cập nhật danh sách hồ sơ. Vui lòng thử lại.');
            }
        });
    }

    function updateApplicationsList() {
        $.ajax({
            url: '/admin/hoso/fetch_applications.php',
            type: 'GET',
            success: function (response) {
                $('#applicationsTable').html(response); // Thay đổi nội dung danh sách hồ sơ
            },
            error: function (xhr, status, error) {
                console.error('Lỗi khi cập nhật danh sách hồ sơ:', error);
                toastr.error('Đã xảy ra lỗi khi cập nhật danh sách hồ sơ. Vui lòng thử lại.');
            }
        });
    }

</script>
<!-- Toastr CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">

<!-- Toastr JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>