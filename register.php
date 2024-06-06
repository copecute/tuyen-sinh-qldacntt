<!DOCTYPE html>
<html>
<head>
    <title>Đăng ký</title>
</head>
<body>
    <h2>Đăng ký</h2>
    <form action="/includes/authencation/register_action.php" method="post">
        <label for="username">Tên đăng nhập:</label><br>
        <input type="text" id="username" name="username" required><br>
        <label for="password">Mật khẩu:</label><br>
        <input type="password" id="password" name="password" required><br><br>
        <input type="submit" value="Đăng ký">
    </form>
    <p>Đã có tài khoản? <a href="login.php">Đăng nhập</a></p>
</body>
</html>
