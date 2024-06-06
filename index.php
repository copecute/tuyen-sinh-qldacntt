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
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Trang chủ</title>
</head>
<body>
    <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
        <h2>Chào mừng, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
        <p><a href="logout.php">Đăng xuất</a></p>
    <?php else: ?>
        <h2>Chào mừng đến trang web của chúng tôi!</h2>
        <p><a href="login.php">Đăng nhập</a> | <a href="register.php">Đăng ký</a></p>
    <?php endif; ?>
</body>
</html>