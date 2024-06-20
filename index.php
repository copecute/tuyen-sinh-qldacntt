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

renderHeader("Tuyển sinh");
?>
<div class="container">
<<<<<<< Updated upstream
    <?php if (isset($_SESSION['account_id'])): ?>
        <h2>Chào mừng, <?php echo $username ?>!</h2>
=======
    <?php if (checkLogin()): ?>
        <h2>Chào mừng, <?php echo $user['username']; ?>!</h2>
        <p><a href="logout.php">Đăng xuất</a></p>
>>>>>>> Stashed changes
    <?php else: ?>
        <h2>Chào mừng đến trang web của chúng tôi!</h2>
    <?php endif; ?>
</div>
<?php renderFooter(); ?>