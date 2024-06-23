<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $fullname = $_POST['fullname'];
    $birthday = $_POST['birthday'];
    $permanent_residence = $_POST['permanent_residence'];
    $phone_number = $_POST['phone_number'];

    try {
        // Bắt đầu transaction
        $conn->beginTransaction();

        // Thêm vào bảng student_accounts
        $stmt = $conn->prepare("INSERT INTO student_accounts (username, password) VALUES (:username, :password)");
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->bindParam(':password', $password, PDO::PARAM_STR);
        $stmt->execute();
        $account_id = $conn->lastInsertId();

        // Thêm vào bảng student_profiles
        $stmt = $conn->prepare("INSERT INTO student_profiles (account_id, fullname, birthday, permanent_residence, phone_number) 
                                VALUES (:account_id, :fullname, :birthday, :permanent_residence, :phone_number)");
        $stmt->bindParam(':account_id', $account_id, PDO::PARAM_INT);
        $stmt->bindParam(':fullname', $fullname, PDO::PARAM_STR);
        $stmt->bindParam(':birthday', $birthday, PDO::PARAM_STR);
        $stmt->bindParam(':permanent_residence', $permanent_residence, PDO::PARAM_STR);
        $stmt->bindParam(':phone_number', $phone_number, PDO::PARAM_STR);
        $stmt->execute();

        // Commit transaction
        $conn->commit();

        // Redirect sau khi thêm thành công
        header('Location: index.php');
        exit();
    } catch (Exception $e) {
        // Rollback transaction nếu có lỗi
        $conn->rollBack();
        echo 'Lỗi: ' . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm mới Sinh viên</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Thêm mới Sinh viên</h2>
        <form method="POST">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="fullname">Họ và Tên:</label>
                <input type="text" class="form-control" id="fullname" name="fullname" required>
            </div>
            <div class="form-group">
                <label for="birthday">Ngày sinh:</label>
                <input type="date" class="form-control" id="birthday" name="birthday" required>
            </div>
            <div class="form-group">
                <label for="permanent_residence">Hộ khẩu thường trú:</label>
                <input type="text" class="form-control" id="permanent_residence" name="permanent_residence">
            </div>
            <div class="form-group">
                <label for="phone_number">Số điện thoại:</label>
                <input type="tel" class="form-control" id="phone_number" name="phone_number">
            </div>
            <button type="submit" class="btn btn-primary">Thêm Sinh viên</button>
        </form>
    </div>
</body>
</html>
