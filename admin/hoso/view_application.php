<?php
require_once ($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');

// Hàm lấy tên thành phố từ ID
function getCity($id)
{
    $jsonData = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/includes/ajax/DiaGioiHanhChinhVN.json');
    $data = json_decode($jsonData, true);

    foreach ($data as $city) {
        if ($city['Id'] == $id) {
            return $city['Name'];
        }
    }

    return 'Không có dữ liệu';
}

// Hàm lấy tên quận/huyện từ ID
function getDistrict($cityId, $districtId)
{
    $jsonData = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/includes/ajax/DiaGioiHanhChinhVN.json');
    $data = json_decode($jsonData, true);

    foreach ($data as $city) {
        if ($city['Id'] == $cityId) {
            foreach ($city['Districts'] as $district) {
                if ($district['Id'] == $districtId) {
                    return $district['Name'];
                }
            }
        }
    }

    return 'Không có dữ liệu';
}

// Hàm lấy tên phường/xã từ ID
function getWard($cityId, $districtId, $wardId)
{
    $jsonData = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/includes/ajax/DiaGioiHanhChinhVN.json');
    $data = json_decode($jsonData, true);

    foreach ($data as $city) {
        if ($city['Id'] == $cityId) {
            foreach ($city['Districts'] as $district) {
                if ($district['Id'] == $districtId) {
                    foreach ($district['Wards'] as $ward) {
                        if ($ward['Id'] == $wardId) {
                            return $ward['Name'];
                        }
                    }
                }
            }
        }
    }

    return 'Không có dữ liệu';
}

$id = $_POST['id']; // Nhận ID từ AJAX POST request

// Cập nhật truy vấn SQL để join với bảng nghanh
$query = $conn->prepare("
    SELECT aa.*, n.ten_nghanh
    FROM admission_application aa
    JOIN nghanh n ON aa.major = n.id
    WHERE aa.id = :id
");
$query->bindParam(':id', $id, PDO::PARAM_INT);
$query->execute();
$application = $query->fetch(PDO::FETCH_ASSOC);

// Dịch ngữ nghĩa các giá trị you_are
function translateYouAre($youAre)
{
    switch ($youAre) {
        case 1:
            return 'Học sinh lớp 12';
        case 2:
            return 'Người đi làm';
        case 3:
            return 'Sinh viên';
        default:
            return 'Không xác định';
    }
}
?>

<div class="modal-body">
    <dl class="row">
        <dt class="col-sm-4">Mã hồ sơ:</dt>
        <dd class="col-sm-8"><?php echo $application['id']; ?></dd>

        <dt class="col-sm-4">Họ và Tên:</dt>
        <dd class="col-sm-8"><?php echo htmlspecialchars($application['fullname']); ?></dd>

        <dt class="col-sm-4">Ngày Sinh:</dt>
        <dd class="col-sm-8"><?php echo htmlspecialchars($application['birthday']); ?></dd>

        <dt class="col-sm-4">Chuyên Ngành:</dt>
        <dd class="col-sm-8"><?php echo htmlspecialchars($application['ten_nghanh']); ?></dd>

        <dt class="col-sm-4">Hộ Khẩu Thường Trú:</dt>
        <dd class="col-sm-8"><?php echo htmlspecialchars($application['permanent_residence']); ?></dd>

        <dt class="col-sm-4">Phường/Xã:</dt>
        <dd class="col-sm-8">
            <?php echo htmlspecialchars(getWard($application['city'], $application['district'], $application['ward'])); ?>
        </dd>

        <dt class="col-sm-4">Quận/Huyện:</dt>
        <dd class="col-sm-8">
            <?php echo htmlspecialchars(getDistrict($application['city'], $application['district'])); ?></dd>

        <dt class="col-sm-4">Tỉnh/Thành phố:</dt>
        <dd class="col-sm-8"><?php echo htmlspecialchars(getCity($application['city'])); ?></dd>

        <dt class="col-sm-4">Số Điện Thoại:</dt>
        <dd class="col-sm-8"><?php echo htmlspecialchars($application['phone_number']); ?></dd>

        <dt class="col-sm-4">Trường THPT:</dt>
        <dd class="col-sm-8"><?php echo htmlspecialchars($application['high_school']); ?></dd>

        <dt class="col-sm-4">Bạn Là:</dt>
        <dd class="col-sm-8"><?php echo htmlspecialchars(translateYouAre($application['you_are'])); ?></dd>
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
</script>

<!-- Toastr CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">

<!-- Toastr JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>