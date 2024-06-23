<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $conn->prepare("SELECT * FROM student_profiles WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $student = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$student) {
        echo "Sinh viên không tồn tại.";
        exit;
    }
} else {
    echo "Không tìm thấy sinh viên.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông tin Sinh viên</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .container {
            max-width: 600px;
        }
        .mt-5 {
            margin-top: 50px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2>Thông tin Sinh viên</h2>
        <div class="card mt-4">
            <div class="card-body">
                <h5 class="card-title"><?php echo htmlspecialchars($student['fullname']); ?></h5>
                <p class="card-text"><strong>Ngày sinh:</strong> <?php echo date('d/m/Y', strtotime($student['birthday'])); ?></p>
                <p class="card-text"><strong>Hộ khẩu thường trú:</strong> <?php echo htmlspecialchars($student['permanent_residence']); ?></p>
                <p class="card-text"><strong>Số điện thoại:</strong> <?php echo htmlspecialchars($student['phone_number']); ?></p>
                <a href="edit.php?id=<?php echo $student['id']; ?>" class="btn btn-primary">Chỉnh sửa</a>
                <a href="index.php" class="btn btn-secondary">Quay lại</a>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS và jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
