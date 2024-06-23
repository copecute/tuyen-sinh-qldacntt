<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];
    $fullname = $_POST['fullname'];
    $birthday = $_POST['birthday'];
    $permanent_residence = $_POST['permanent_residence'];
    $phone_number = $_POST['phone_number'];

    try {
        $stmt = $conn->prepare("UPDATE student_profiles SET fullname = :fullname, birthday = :birthday, 
                                permanent_residence = :permanent_residence, phone_number = :phone_number 
                                WHERE id = :id");
        $stmt->bindParam(':fullname', $fullname, PDO::PARAM_STR);
        $stmt->bindParam(':birthday', $birthday, PDO::PARAM_STR);
        $stmt->bindParam(':permanent_residence', $permanent_residence, PDO::PARAM_STR);
        $stmt->bindParam(':phone_number', $phone_number, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        echo json_encode(['status' => 'success', 'message' => 'Cập nhật thành công.']);
        exit;
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => 'Lỗi: ' . $e->getMessage()]);
        exit;
    }
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $conn->prepare("SELECT * FROM student_profiles WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $student = $stmt->fetch(PDO::FETCH_ASSOC);
} else {
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa Sinh viên</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Sửa Sinh viên</h2>
        <form id="editStudentForm" method="POST">
            <input type="hidden" name="id" value="<?php echo $student['id']; ?>">
            <div class="form-group">
                <label for="fullname">Họ và Tên:</label>
                <input type="text" class="form-control" id="fullname" name="fullname" value="<?php echo htmlspecialchars($student['fullname']); ?>" required>
            </div>
            <div class="form-group">
                <label for="birthday">Ngày sinh:</label>
                <input type="date" class="form-control" id="birthday" name="birthday" value="<?php echo $student['birthday']; ?>" required>
            </div>
            <div class="form-group">
                <label for="permanent_residence">Hộ khẩu thường trú:</label>
                <input type="text" class="form-control" id="permanent_residence" name="permanent_residence" value="<?php echo htmlspecialchars($student['permanent_residence']); ?>">
            </div>
            <div class="form-group">
                <label for="phone_number">Số điện thoại:</label>
                <input type="tel" class="form-control" id="phone_number" name="phone_number" value="<?php echo htmlspecialchars($student['phone_number']); ?>">
            </div>
            <button type="submit" class="btn btn-primary">Cập nhật</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#editStudentForm').submit(function (event) {
                event.preventDefault();
                var form = $(this);
                $.ajax({
                    url: 'edit.php',
                    method: 'POST',
                    data: form.serialize(),
                    dataType: 'json',
                    success: function (response) {
                        if (response.status === 'success') {
                            alert(response.message);
                            window.location.href = 'index.php';
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function () {
                        alert('Có lỗi xảy ra, vui lòng thử lại sau.');
                    }
                });
            });
        });
    </script>
</body>
</html>
