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

// Lấy tổng số lượng hồ sơ đăng ký nhập học
$totaladmission_application = $conn->query("SELECT COUNT(*) FROM admission_application")->fetchColumn();

// Lấy tổng số lượng hồ sơ đăng ký nhập học có 'status' = 1 (đã duyệt)
$totalApprovedadmission_application = $conn->query("SELECT COUNT(*) FROM admission_application WHERE status = 1")->fetchColumn();

// Lấy tổng số lượng hồ sơ đăng ký nhập học có 'status' = 0 (đang chờ)
$totalPendingadmission_application = $conn->query("SELECT COUNT(*) FROM admission_application WHERE status = 0")->fetchColumn();

// Lấy tổng số lượng hồ sơ đăng ký nhập học có 'status' = 2 (bị từ chối)
$totalRejectedadmission_application = $conn->query("SELECT COUNT(*) FROM admission_application WHERE status = 2")->fetchColumn();

renderHeader("Admin Control Panel");
?>
<div class="container mt-5">
    <div class="row mt-3">
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">
                    Tổng số đơn đăng ký
                </div>
                <div class="card-body">
                    <p class="card-text"><?php echo $totaladmission_application; ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">
                    Được phê duyệt
                </div>
                <div class="card-body">
                    <p class="card-text"><?php echo $totalApprovedadmission_application; ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">
                    Chờ xét duyệt
                </div>
                <div class="card-body">
                    <p class="card-text"><?php echo $totalPendingadmission_application; ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">
                    Bị từ chối
                </div>
                <div class="card-body">
                    <p class="card-text"><?php echo $totalRejectedadmission_application; ?></p>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-5">

        <?php if (isset($_SESSION['admin_id']) && ($userLevel == 1)): ?>
            <div class="col-lg-4 mb-4">
                <div class="card" data-step="1" data-intro="Danh Sách khoa bạn có thể thêm sửa xoá hoặc tìm kiếm!">
                    <div class="card-body">
                        <h5 class="card-title">Quản Lý Khoa</h5>
                        <p class="card-text">Thêm, sửa, xoá, danh sách khoa.</p>
                        <a href="/admin/khoa" class="btn btn-primary">Quản Lý</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mb-4">
                <div class="card">
                    <div class="card-body" data-step="2" data-intro="Nghành phải thuộc 1 khoa nào đó">
                        <h5 class="card-title">Quản Lý Ngành</h5>
                        <p class="card-text">Thêm, sửa, xoá, danh sách ngành.</p>
                        <a href="/admin/nghanh" class="btn btn-primary">Quản Lý</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mb-4">
                <div class="card">
                    <div class="card-body" data-step="3"
                        data-intro="Bạn xem danh sách lớp tại đây, danh sách sinh viên trong 1 lớp">
                        <h5 class="card-title">Quản Lý Lớp</h5>
                        <p class="card-text">Thêm, sửa, xoá, danh sách lớp.</p>
                        <a href="/admin/lop" class="btn btn-primary">Quản Lý</a>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <div class="col-lg-4 mb-4">
            <div class="card">
                <div class="card-body" data-step="4" data-intro="Hồ sơ xét tuyển của các ứng viên">
                    <h5 class="card-title">Quản Lý Hồ sơ tuyển sinh</h5>
                    <p class="card-text">Thêm, sửa, xoá, phê duyệt hồ sơ</p>
                    <a href="/admin/hoso" class="btn btn-primary">Quản Lý</a>
                </div>
            </div>
        </div>

        <?php if (isset($_SESSION['admin_id']) && ($userLevel == 1)): ?>
            <div class="col-lg-4 mb-4">
                <div class="card">
                    <div class="card-body" data-step="5"
                        data-intro="Hồ sơ, tài khoản sinh viên! nếu hồ sơ xét tuyển được phê duyệt tự động tạo tài khoản sinh viên">
                        <h5 class="card-title">Quản Lý Sinh viên</h5>
                        <p class="card-text">Tài khoản, Hồ sơ sinh viên</p>
                        <a href="/admin/sinhvien" class="btn btn-primary">Quản Lý</a>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <div class="col-lg-4 mb-4">
            <div class="card">
                <div class="card-body" data-step="6" data-intro="Thống kê hồ sơ xét tuyển">
                    <h5 class="card-title">Thống kê</h5>
                    <p class="card-text">Thống kê báo cáo</p>
                    <a href="/admin/thongke.php" class="btn btn-primary">Xem</a>
                </div>
            </div>
        </div>
        <?php if (isset($_SESSION['admin_id']) && ($userLevel == 1)): ?>
            <div class="col-lg-4 mb-4">
                <div class="card">
                    <div class="card-body" data-step="7" data-intro="Bạn cài đặt thời gian tuyển sinh, khoá tại đây">
                        <h5 class="card-title">Quản Lý năm tuyển sinh</h5>
                        <p class="card-text">Thêm, sửa, xoá...</p>
                        <a href="/admin/admissions-settings" class="btn btn-primary">Quản Lý</a>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 mb-4">
                <div class="card">
                    <div class="card-body" data-step="8" data-intro="Bạn cài đặt thời gian tuyển sinh, khoá tại đây">
                        <h5 class="card-title">Tài khoản giáo viên, admin</h5>
                        <p class="card-text">Quản lý tài khoản quản trị</p>
                        <a href="/admin/register.php" class="btn btn-primary">Thêm</a>
                    </div>
                </div>
            </div>

        <?php endif; ?>

    </div>
</div>

<?php renderFooter(); ?>