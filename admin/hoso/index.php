<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Hồ Sơ Nhập Học</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h2 class="mb-4">Quản Lý Hồ Sơ Nhập Học</h2>
        <div class="row mb-3">
            <div class="col">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addModal" data-action="add">Thêm Hồ Sơ</button>
            </div>
        </div>
        <div id="application-table">
            <!-- Bảng hiển thị dữ liệu sẽ được tải qua AJAX -->
        </div>
    </div>

    <!-- Add/Edit Modal -->
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <!-- Nội dung form thêm/sửa sẽ được tải bằng AJAX -->
            </div>
        </div>
    </div>

    <!-- View Modal -->
    <div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <!-- Nội dung chi tiết hồ sơ sẽ được tải bằng AJAX -->
            </div>
        </div>
    </div>

    <!-- Bootstrap JS và jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- Script AJAX để tải dữ liệu và thực hiện các hành động -->
    <script>
        $(document).ready(function () {
            loadApplications();

            // Hàm AJAX để load danh sách applications
            function loadApplications() {
                $.ajax({
                    url: "fetch_applications.php",
                    type: "POST",
                    success: function (data) {
                        $("#application-table").html(data);
                    }
                });
            }

            // Hiển thị modal thêm/sửa application
            $('#addModal').on('show.bs.modal', function (e) {
                var btn = $(e.relatedTarget);
                var action = btn.data('action'); // Kiểm tra biến action từ data-action của nút
                var modal = $(this);
                var id = btn.data('id'); // Lấy giá trị ID từ data-id của nút (chỉ khi sửa)
                $.ajax({
                    type: 'POST',
                    url: 'application_form.php',
                    data: { action: action, id: id }, // Truyền giá trị action và id qua AJAX
                    success: function (response) {
                        modal.find('.modal-content').html(response);
                    }
                });
            });

            // Hiển thị modal xem chi tiết application
            $('#viewModal').on('show.bs.modal', function (e) {
                var btn = $(e.relatedTarget);
                var id = btn.data('id'); // Lấy giá trị ID từ data-id của nút
                var modal = $(this);
                $.ajax({
                    type: 'POST',
                    url: 'view_application.php',
                    data: { id: id }, // Truyền giá trị id qua AJAX
                    success: function (response) {
                        modal.find('.modal-content').html(response);
                    }
                });
            });

            // Hàm AJAX để xoá application
            $(document).on('click', '.delete-btn', function () {
                var id = $(this).data("id");
                if (confirm("Bạn có chắc chắn muốn xóa hồ sơ này?")) {
                    $.ajax({
                        url: "delete_application.php",
                        method: "POST",
                        data: { id: id },
                        success: function (data) {
                            loadApplications();
                        }
                    });
                }
            });

            // Hàm AJAX để phê duyệt application
            $(document).on('click', '.approve-btn', function () {
                var id = $(this).data("id");
                $.ajax({
                    url: "approve_application.php",
                    method: "POST",
                    data: { id: id },
                    success: function (data) {
                        loadApplications();
                    }
                });
            });
        });
    </script>
</body>

</html>
