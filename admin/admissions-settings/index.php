<?php
require_once ($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Cài đặt tuyển sinh</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Toast CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
</head>

<body>
    <div class="container">
        <h2 class="my-4">Cài đặt tuyển sinh</h2>

        <!-- Nút mở modal Thêm -->
        <button class="btn btn-primary my-3" data-toggle="modal" data-target="#addEditModal">Thêm mới cài đặt</button>

        <!-- Tìm kiếm và phân trang -->
        <div class="form-inline my-3">
            <input type="text" class="form-control mr-2" id="search" placeholder="Tìm kiếm theo năm học">
            <button class="btn btn-secondary" id="searchBtn">Tìm kiếm</button>
        </div>

        <!-- Bảng hiển thị dữ liệu -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Năm học</th>
                    <th>Số học sinh tối đa trong lớp</th>
                    <th>Ngày bắt đầu</th>
                    <th>Ngày kết thúc</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody id="settingsTable">
                <!-- Nội dung động -->
            </tbody>
        </table>

        <!-- Phân trang -->
        <nav>
            <ul class="pagination">
                <!-- Liên kết phân trang động -->
            </ul>
        </nav>
    </div>

    <!-- Modal Thêm/Sửa -->
    <div class="modal fade" id="addEditModal" tabindex="-1" role="dialog" aria-labelledby="addEditModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="admissionsForm">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addEditModalLabel">Thêm/Sửa Cài đặt tuyển sinh</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Đóng">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="id" name="id">
                        <div class="form-group">
                            <label for="start_year">Năm bắt đầu</label>
                            <input type="number" class="form-control" id="start_year" name="start_year" required>
                        </div>
                        <div class="form-group">
                            <label for="end_year">Năm kết thúc</label>
                            <input type="number" class="form-control" id="end_year" name="end_year" required>
                        </div>
                        <div class="form-group">
                            <label for="max_students_per_class">Số học sinh tối đa trong lớp</label>
                            <input type="number" class="form-control" id="max_students_per_class"
                                name="max_students_per_class" required>
                        </div>
                        <div class="form-group">
                            <label for="start_date">Ngày bắt đầu</label>
                            <input type="date" class="form-control" id="start_date" name="start_date" required>
                        </div>
                        <div class="form-group">
                            <label for="end_date">Ngày kết thúc</label>
                            <input type="date" class="form-control" id="end_date" name="end_date" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary">Lưu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Xem -->
    <div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewModalLabel">Xem Cài đặt tuyển sinh</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Đóng">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <dl class="row">
                        <dt class="col-sm-4">ID:</dt>
                        <dd class="col-sm-8" id="view_id"></dd>

                        <dt class="col-sm-4">Năm học:</dt>
                        <dd class="col-sm-8" id="view_academic_year"></dd>

                        <dt class="col-sm-4">Số học sinh tối đa trong lớp:</dt>
                        <dd class="col-sm-8" id="view_max_students_per_class"></dd>

                        <dt class="col-sm-4">Ngày bắt đầu:</dt>
                        <dd class="col-sm-8" id="view_start_date"></dd>

                        <dt class="col-sm-4">Ngày kết thúc:</dt>
                        <dd class="col-sm-8" id="view_end_date"></dd>
                    </dl>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>


        <!-- Bootstrap JS và jQuery -->
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <!-- Toast JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script>
        $(document).ready(function () {
            loadSettings();

            // Tải cài đặt với phân trang
            function loadSettings(page = 1, query = '') {
                $.ajax({
                    url: 'fetch.php',
                    type: 'GET',
                    data: { page: page, query: query },
                    dataType: 'json',
                    success: function (data) {
                        $('#settingsTable').html(data.table);
                        $('.pagination').html(data.pagination);
                    },
                    error: function (xhr, status, error) {
                        console.error('Lỗi khi tải dữ liệu:', error);
                        showToast('error', 'Đã xảy ra lỗi khi tải dữ liệu. Vui lòng thử lại.');
                    }
                });
            }

            // Tìm kiếm
            $('#searchBtn').on('click', function () {
                var query = $('#search').val();
                loadSettings(1, query);
            });

            // Lưu cài đặt
            $('#admissionsForm').on('submit', function (e) {
                e.preventDefault();
                $.ajax({
                    url: 'save.php',
                    type: 'POST',
                    data: $(this).serialize(),
                    dataType: 'json',
                    success: function (response) {
                        if (response.status === 'success') {
                            showToast('success', response.message);
                            loadSettings();
                            $('#admissionsForm')[0].reset();
                            $('#addEditModal').modal('hide');
                        } else {
                            showToast('error', response.message);
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error('Lỗi khi lưu dữ liệu:', error);
                        showToast('error', 'Đã xảy ra lỗi khi lưu dữ liệu. Vui lòng thử lại.');
                    }
                });
            });

            // Sự kiện khi click vào nút Sửa
            $(document).on('click', '.edit-btn', function () {
                var id = $(this).data('id');
                $.ajax({
                    url: 'fetch.php',
                    type: 'GET',
                    data: { id: id },
                    dataType: 'json',
                    success: function (data) {
                        $('#id').val(data.id);
                        $('#start_year').val(data.start_year);
                        $('#end_year').val(data.end_year);
                        $('#max_students_per_class').val(data.max_students_per_class);
                        $('#start_date').val(data.start_date);
                        $('#end_date').val(data.end_date);
                        $('#addEditModal').modal('show');
                    },
                    error: function (xhr, status, error) {
                        console.error('Lỗi khi tải dữ liệu:', error);
                        showToast('error', 'Đã xảy ra lỗi khi tải dữ liệu. Vui lòng thử lại.');
                    }
                });
            });

            // Sự kiện khi click vào nút Xem
            $(document).on('click', '.view-btn', function () {
                var id = $(this).data('id');
                $.ajax({
                    url: 'fetch.php',
                    type: 'GET',
                    data: { id: id },
                    dataType: 'json',
                    success: function (data) {
                        $('#view_id').text(data.id);
                        $('#view_academic_year').text(data.start_year + ' - ' + data.end_year);
                        $('#view_max_students_per_class').text(data.max_students_per_class);
                        $('#view_start_date').text(data.start_date);
                        $('#view_end_date').text(data.end_date);
                        $('#viewModal').modal('show');
                    },
                    error: function (xhr, status, error) {
                        console.error('Lỗi khi tải dữ liệu:', error);
                        showToast('error', 'Đã xảy ra lỗi khi tải dữ liệu. Vui lòng thử lại.');
                    }
                });
            });

            // Sự kiện khi click vào nút Xóa
            $(document).on('click', '.delete-btn', function () {
                var id = $(this).data('id');
                if (confirm('Bạn có chắc chắn muốn xóa hồ sơ này không?')) {
                    $.ajax({
                        url: 'delete.php',
                        type: 'POST',
                        data: { id: id },
                        dataType: 'json',
                        success: function (response) {
                            if (response.status === 'success') {
                                showToast('success', response.message);
                                loadSettings();
                            } else {
                                showToast('error', response.message);
                            }
                        },
                        error: function (xhr, status, error) {
                            console.error('Lỗi khi xóa dữ liệu:', error);
                            showToast('error', 'Đã xảy ra lỗi khi xóa dữ liệu. Vui lòng thử lại.');
                        }
                    });
                }
            });

            // Sự kiện click vào phân trang
            $(document).on('click', '.pagination a', function (e) {
                e.preventDefault();
                var page = $(this).attr('data-page');
                var query = $('#search').val();
                loadSettings(page, query);
            });

            // Hàm hiển thị toast
            function showToast(type, message) {
                toastr.options = {
                    "closeButton": true,
                    "progressBar": true,
                    "timeOut": "3000",
                };
                if (type === 'success') {
                    toastr.success(message);
                } else if (type === 'error') {
                    toastr.error(message);
                }
            }
        });
    </script>
</body>

</html>