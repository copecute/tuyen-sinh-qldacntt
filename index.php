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
    <?php if (isset($_SESSION['account_id'])): ?>
        
        <h2>Chào mừng, <?php echo htmlspecialchars($student['fullname']) ?>!</h2>
        <p>Đến từ <?php echo htmlspecialchars($student['permanent_residence']) ?></p>
    <?php else: ?>
        <h2>Chào mừng đến trang web của chúng tôi!</h2>
    <?php endif; ?>
</div>
<?php renderFooter(); ?>