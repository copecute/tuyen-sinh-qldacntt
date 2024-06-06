<!DOCTYPE html>
<html>
<head>
    <title>Đăng nhập</title>
</head>
<body>
    <h2>Đăng nhập</h2>
    <form action="/includes/authencation/login_action.php" method="post">
        <label for="username">Tên đăng nhập:</label><br>
        <input type="text" id="username" name="username" required><br>
        <label for="password">Mật khẩu:</label><br>
        <input type="password" id="password" name="password" required><br><br>
        <input type="submit" value="Đăng nhập">
    </form>
    <p>Chưa có tài khoản? <a href="register.php">Đăng ký</a></p>
</body>
</html>