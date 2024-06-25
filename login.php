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
renderHeader("Đăng nhập");
?>

<div class="login-registration-wrapper">
    <div class="container">
        <div class="row g-0">
            <div class="col-lg-6">
                <div class="login-page-form-area" data-step="1" data-intro="Nếu bạn được cấp tài khoản hãy nhập thông tin vào các trường sau">
                    <h4 class="title">Đăng nhập</h4>
                    <form id="loginForm">
                        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                        <div class="single-input-wrapper">
                            <label for="username">Mã sinh viên</label>
                            <input id="username" name="username" type="text" placeholder="Nhập mã sinh viên" required>
                        </div>
                        <div class="single-input-wrapper">
                            <label for="password">Mật khẩu</label>
                            <input id="password" name="password" type="password" placeholder="Mật khẩu" required>
                        </div>
                        <button type="submit" class="rts-btn btn-primary" data-step="2" data-intro="Ấn nút này để đăng nhập">Đăng nhập</button>

                        <div class="google-apple-wrapper">
                            <div class="google">
                                <img src="/resources/images/contact/06.png" alt="contact">
                            </div>
                            <div class="google">
                                <img src="/resources/images/contact/07.png" alt="contact">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="contact-thumbnail-login-p mt--100">
                    <img src="/resources/images/banner/login-bg.png" width="600" height="495" alt="login-form">
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#loginForm').on('submit', function (e) {
            e.preventDefault();
            $.ajax({
                url: '/includes/authencation.php?action=login',
                type: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                success: function (response) {
                    if (response.status === 'success') {
                        toastr.success(response.message);
                        setTimeout(function () {
                            window.location.href = '/';
                        }, 2000);
                    } else {
                        toastr.error(response.message);
                    }
                },
                error: function (xhr, status, error) {
                    toastr.error('Đã xảy ra lỗi khi xử lý yêu cầu đăng nhập. Vui lòng thử lại.');
                }
            });
        });
    });
</script>
</body>

</html>
<?php renderFooter(); ?>