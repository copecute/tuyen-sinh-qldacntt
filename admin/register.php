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
require_once ($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php'); ?>

<?php renderHeader("Đăng ký"); ?>

<h2>Đăng ký</h2>
<form id="registerForm" action="/admin/includes/authencation.php?action=register" method="post">
    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
    <label for="username">Tên đăng nhập:</label><br>
    <input type="text" id="username" name="username" required><br>
    <label for="password">Mật khẩu:</label><br>
    <input type="password" id="password" name="password" required><br><br>
    <input type="submit" value="Đăng ký">
</form>
<p>Đã có tài khoản? <a href="login.php">Đăng nhập</a></p>

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

<?php renderFooter(); ?>