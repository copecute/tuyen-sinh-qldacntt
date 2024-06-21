<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Quản Lý Hồ Sơ Nhập Học</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>
    <div class="container mt-5">
        <h2 class="mb-4">Dashboard Quản Lý Hồ Sơ Nhập Học</h2>
        <div class="row">
            <div class="col-lg-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Quản Lý Khoa</h5>
                        <p class="card-text">Thêm, sửa, xoá, danh sách khoa.</p>
                        <a href="/admin/khoa" class="btn btn-primary">Quản Lý</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Quản Lý Ngành</h5>
                        <p class="card-text">Thêm, sửa, xoá, danh sách ngành.</p>
                        <a href="/admin/nghanh" class="btn btn-primary">Quản Lý</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Quản Lý Lớp</h5>
                        <p class="card-text">Thêm, sửa, xoá, danh sách lớp.</p>
                        <a href="/admin/lop" class="btn btn-primary">Quản Lý</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Quản Lý Hồ sơ tuyển sinh</h5>
                        <p class="card-text">Thêm, sửa, xoá, phê duyệt hồ sơ</p>
                        <a href="/admin/hoso" class="btn btn-primary">Quản Lý</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Thống kê</h5>
                        <p class="card-text">Thống kê báo cáo</p>
                        <a href="/admin/thongke.php" class="btn btn-primary">Xem</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Quản Lý năm tuyển sinh</h5>
                        <p class="card-text">Thêm, sửa, xoá...</p>
                        <a href="/admin/admissions-settings" class="btn btn-primary">Quản Lý</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS và jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- Custom Script -->
    <script src="js/script.js"></script>
</body>

</html>
