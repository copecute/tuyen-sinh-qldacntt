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
require_once ($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/functions.php'); ?>

<?php renderHeader("Đăng ký"); ?>
<?php if (isset($_SESSION['admin_id']) && ($userLevel == 1)): ?>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header text-center">
                        <h2>Đăng ký</h2>
                    </div>
                    <div class="card-body">
                        <form id="registerForm">
                            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                            <div class="form-group">
                                <label for="username">Tên đăng nhập:</label>
                                <input type="text" id="username" name="username" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Mật khẩu:</label>
                                <input type="password" id="password" name="password" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Đăng ký</button>
                        </form>
                        <p class="mt-3 text-center">Đã có tài khoản? <a href="/admin/login.php">Đăng nhập</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        // Xử lý Ajax cho form đăng ký
        $(document).ready(function () {
            $('#registerForm').submit(function (event) {
                event.preventDefault(); // Ngăn chặn form submit mặc định

                var formData = $(this).serialize(); // Lấy dữ liệu form

                $.ajax({
                    type: 'POST',
                    url: '/admin/includes/authencation.php?action=register',
                    data: formData,
                    dataType: 'json',
                    success: function (response) {
                        if (response.status === 'success') {
                            // Đăng ký thành công
                            toastr.success(response.message);
                            setTimeout(function () {
                                window.location.href = '/admin/login.php';
                            }, 3000);
                        } else {
                            // Hiển thị thông báo lỗi
                            toastr.error(response.message);
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error('Lỗi Ajax: ' + error);
                        toastr.error('Đã xảy ra lỗi trong quá trình xử lý.');
                    }
                });
            });
        });
    </script>
<?php else: ?>
    <p>bạn không có quyền</p>
<?php endif; ?>

<?php renderFooter(); ?>