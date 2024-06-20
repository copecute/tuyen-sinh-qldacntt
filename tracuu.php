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
require_once ($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');
renderHeader("Tra cứu");

$phone_number = '';
$result = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $phone_number = $_POST['phone_number'];

    try {
        $sql = "SELECT * FROM admission_application WHERE phone_number = :phone_number";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':phone_number', $phone_number);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Lỗi: " . $e->getMessage();
    }
}
?>

    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <div class="container mt-5">
        <h2>Tra cứu kết quả hồ sơ</h2>
        <form method="post">
            <div class="form-group">
                <label for="phone_number">Phone Number:</label>
                <input type="text" class="form-control" id="phone_number" name="phone_number" required>
            </div>
            <button type="submit" class="btn btn-primary">Search</button>
        </form>

        <?php if ($result): ?>
            <div class="mt-5">
                <h3>Hồ sơ tuyển sinh</h3>
                <p><strong>Họ và Tên:</strong> <?php echo htmlspecialchars($result['fullname']); ?></p>
                <p><strong>Năm sinh:</strong> <?php echo htmlspecialchars($result['birthday']); ?></p>
                <p><strong>Số điện thoại:</strong> <?php echo htmlspecialchars($result['phone_number']); ?></p>
                <p><strong>Trường trung học:</strong> <?php echo htmlspecialchars($result['high_school']); ?></p>
                <p><strong>Ứng tuyển nghành:</strong> <?php echo htmlspecialchars($result['major']); ?></p>
                <p><strong>Trạng thái:</strong> <?php
                if ($result['status'] == 0) {
                    echo "<div class='alert alert-warning'>Đang xét duyệt</div>";
                } elseif ($result['status'] == 1) {
                    echo "<div class='alert alert-success'>Đủ điều kiện nhập học</div>";
                } elseif ($result['status'] == 2) {
                    echo "<div class='alert alert-danger'>Hồ sơ bị từ chối</div>";
                }
                ?></p>
            </div>
        <?php elseif ($_SERVER["REQUEST_METHOD"] == "POST"): ?>
            <div class="mt-5">
                <p>Không có kết quả</p>
            </div>
        <?php endif; ?>
    </div>
    <?php renderFooter(); ?>