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

// Lấy tổng số lượng hồ sơ đăng ký
$totaladmission_application = $conn->query("SELECT COUNT(*) FROM admission_application")->fetchColumn();

// Lấy tổng số lượng hồ sơ đăng ký nhập học có 'status' = 1 (đã duyệt)
$totalApprovedadmission_application = $conn->query("SELECT COUNT(*) FROM admission_application WHERE status = 1")->fetchColumn();

// Lấy tổng số lượng hồ sơ đăng ký nhập học có 'status' = 0 (đang chờ)
$totalPendingadmission_application = $conn->query("SELECT COUNT(*) FROM admission_application WHERE status = 0")->fetchColumn();

// Lấy tổng số lượng hồ sơ đăng ký nhập học có 'status' = 2 (bị từ chối)
$totalRejectedadmission_application = $conn->query("SELECT COUNT(*) FROM admission_application WHERE status = 2")->fetchColumn();

// Lấy số lượng hồ sơ đăng ký nhập học theo ngành học
$admission_applicationByMajor = $conn->query("SELECT major, COUNT(*) as count FROM admission_application GROUP BY major")->fetchAll();

// Lấy số lượng hồ sơ đăng ký nhập học theo 'you_are' (đối tượng bạn là ai)
$admission_applicationByYouAre = $conn->query("SELECT you_are, COUNT(*) as count FROM admission_application GROUP BY you_are")->fetchAll();

// Lấy số lượng hồ sơ đăng ký nhập học theo trường trung học
$admission_applicationByHighSchool = $conn->query("SELECT high_school, COUNT(*) as count FROM admission_application GROUP BY high_school")->fetchAll();

// Lấy số lượng hồ sơ đăng ký nhập học theo trạng thái
$admission_applicationByStatus = $conn->query("SELECT status, COUNT(*) as count FROM admission_application GROUP BY status")->fetchAll();

// Lấy số lượng hồ sơ đăng ký nhập học theo nơi cư trú
$admission_applicationByResidence = $conn->query("SELECT permanent_residence, COUNT(*) as count FROM admission_application GROUP BY permanent_residence")->fetchAll();

renderHeader("Thống kê hồ sơ xét tuyển");
?>

<div class="container">
    <h1 class="mt-5">Thống Kê Hồ Sơ</h1>
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

    <h2 class="mt-5">Hồ Sơ Theo Chuyên Ngành</h2>
    <table class="table table-bordered mt-3">
        <thead class="thead-dark">
            <tr>
                <th>Chuyên Ngành</th>
                <th>Số Lượng</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($admission_applicationByMajor as $row): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['major']); ?></td>
                    <td><?php echo $row['count']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h2 class="mt-5">Hồ Sơ Theo Loại Học Sinh</h2>
    <table class="table table-bordered mt-3">
        <thead class="thead-dark">
            <tr>
                <th>Loại Học Sinh</th>
                <th>Số Lượng</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($admission_applicationByYouAre as $row): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['you_are']); ?></td>
                    <td><?php echo $row['count']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h2 class="mt-5">Hồ Sơ Theo Trường THPT</h2>
    <table class="table table-bordered mt-3">
        <thead class="thead-dark">
            <tr>
                <th>Trường THPT</th>
                <th>Số Lượng</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($admission_applicationByHighSchool as $row): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['high_school']); ?></td>
                    <td><?php echo $row['count']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h2 class="mt-5">Hồ Sơ Theo Trạng Thái</h2>
    <table class="table table-bordered mt-3">
        <thead class="thead-dark">
            <tr>
                <th>Trạng Thái</th>
                <th>Số Lượng</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($admission_applicationByStatus as $row): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['status']); ?></td>
                    <td><?php echo $row['count']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h2 class="mt-5">Hồ Sơ Theo Nơi Thường Trú</h2>
    <table class="table table-bordered mt-3">
        <thead class="thead-dark">
            <tr>
                <th>Nơi Thường Trú</th>
                <th>Số Lượng</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($admission_applicationByResidence as $row): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['permanent_residence']); ?></td>
                    <td><?php echo $row['count']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<?php renderFooter(); ?>