<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Sinh viên</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="container mt-5">
        <h2>Quản lý Sinh viên</h2>
        <div class="row mb-3">
            <div class="col-md-6">
                <input type="text" class="form-control" id="searchInput" placeholder="Tìm kiếm...">
            </div>
            <div class="col-md-6 text-right">
                <a href="add.php" class="btn btn-primary">Thêm mới</a>
            </div>
        </div>
        <div id="studentsTable">
            <!-- Bảng danh sách sinh viên sẽ được load bằng AJAX -->
        </div>
    </div>

    <script>
        $(document).ready(function () {
            loadStudents();

            $('#searchInput').on('keyup', function () {
                loadStudents();
            });

            $(document).on('click', '.pagination a.page-link', function (e) {
                e.preventDefault();
                var page = $(this).data('page');
                loadStudents(page);
            });

            function loadStudents(page) {
                $.ajax({
                    url: "/admin/sinhvien/fetch_students.php",
                    type: "POST",
                    data: {
                        page: page || 1,
                        search: $('#searchInput').val()
                    },
                    success: function (data) {
                        $('#studentsTable').html(data);
                    }
                });
            }
        });
    </script>
</body>
</html>
