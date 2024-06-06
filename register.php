<<<<<<< HEAD
<?php require_once ($_SERVER['DOCUMENT_ROOT'] . '/includes/config.php'); ?>
<!DOCTYPE html>
<html>

<head>
    <title>Đăng ký</title>
</head>

<body>
    <h2>Đăng ký</h2>
    <form action="/includes/authencation.php?action=register" method="post">
        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
=======
<!DOCTYPE html>
<html>
<head>
    <title>Đăng ký</title>
</head>
<body>
    <h2>Đăng ký</h2>
    <form action="/includes/authencation/register_action.php" method="post">
>>>>>>> c48b8e629d3c7b2d767d9730e283d6c5408ea0e9
        <label for="username">Tên đăng nhập:</label><br>
        <input type="text" id="username" name="username" required><br>
        <label for="password">Mật khẩu:</label><br>
        <input type="password" id="password" name="password" required><br><br>
        <input type="submit" value="Đăng ký">
    </form>
    <p>Đã có tài khoản? <a href="login.php">Đăng nhập</a></p>
</body>
<<<<<<< HEAD

</html>
=======
</html>
>>>>>>> c48b8e629d3c7b2d767d9730e283d6c5408ea0e9
