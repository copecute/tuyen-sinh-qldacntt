<?php
require_once ($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Khoa</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Toast CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
</head>

<body>
    <div class="container mt-5">
        <h2 class="mb-4">Quản lý Khoa</h2>
        <div class="row mb-3">
            <div class="col">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addKhoaModal"
                    data-action="add">Thêm Khoa</button>
            </div>
            <div class="col-md-4">
                <input type="text" class="form-control" id="searchInput" placeholder="Tìm kiếm Khoa...">
            </div>
        </div>
        <div id="khoa-table">
            <!-- Bảng hiển thị danh sách khoa -->
        </div>
    </div>

    <!-- Add Khoa Modal -->
    <div class="modal fade" id="addKhoaModal" tabindex="-1" role="dialog" aria-labelledby="addKhoaModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="addKhoaForm">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addKhoaModalLabel">Thêm Khoa Mới</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="ten_khoa">Tên Khoa</label>
                            <input type="text" class="form-control" id="ten_khoa" name="ten_khoa" required>
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

    <!-- Edit Khoa Modal -->
    <div class="modal fade" id="editKhoaModal" tabindex="-1" role="dialog" aria-labelledby="editKhoaModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="editKhoaForm">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editKhoaModalLabel">Sửa Khoa</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="edit_ten_khoa">Tên Khoa</label>
                            <input type="text" class="form-control" id="edit_ten_khoa" name="edit_ten_khoa" required>
                            <input type="hidden" id="edit_khoa_id" name="edit_khoa_id">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Toast Container -->
    <div class="toast-container position-fixed bottom-0 end-0 p-3"></div>

    <!-- Bootstrap JS và jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- Toast JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <!-- Script AJAX để thực hiện thêm, sửa, xoá và tìm kiếm khoa -->
    <script>
        $(document).ready(function () {
            // Tải danh sách khoa khi trang được load
            loadKhoas();

            // Submit form thêm khoa
            $('#addKhoaForm').on('submit', function (e) {
                e.preventDefault();

                var form = $(this);
                $.ajax({
                    type: "POST",
                    url: "/admin/khoa/save_khoa.php",
                    data: form.serialize() + '&action=add',
                    success: function (response) {
                        loadKhoas(); // Reload danh sách khoa sau khi thêm thành công
                        $('#addKhoaModal').modal('hide'); // Đóng modal thêm khoa
                        showToast('success', response); // Hiển thị toast thông báo thành công
                    },
                    error: function (xhr, status, error) {
                        console.error('Lỗi khi thêm khoa:', error); // Log lỗi vào console để kiểm tra
                        showToast('error', 'Đã xảy ra lỗi khi thêm khoa. Vui lòng thử lại.'); // Hiển thị toast thông báo lỗi
                    }
                });
            });

            // Tìm kiếm khoa
            $('#searchInput').on('keyup', function () {
                var searchText = $(this).val().toLowerCase();
                $.ajax({
                    url: "/admin/khoa/fetch_khoas.php",
                    type: "POST",
                    data: { search: searchText },
                    success: function (data) {
                        $("#khoa-table").html(data);
                    }
                });
            });

            // Xử lý khi click vào phân trang
            $(document).on('click', '.pagination a.page-link', function (e) {
                e.preventDefault();
                var page = $(this).data('page');
                $.ajax({
                    url: "/admin/khoa/fetch_khoas.php",
                    type: "POST",
                    data: { page: page },
                    success: function (data) {
                        $("#khoa-table").html(data);
                    }
                });
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

            // Hàm AJAX để load danh sách khoa
            function loadKhoas() {
                $.ajax({
                    url: "/admin/khoa/fetch_khoas.php",
                    type: "POST",
                    success: function (data) {
                        $("#khoa-table").html(data);
                    }
                });
            }

            // Xem chi tiết Ngành khi click vào nút Xem Ngành
            $(document).on('click', '.view-nganh-btn', function () {
                var khoa_id = $(this).data('khoa_id');
                window.location.href = '/admin/nganh/index.php?khoa=' + khoa_id;
            });

            // Submit form sửa khoa
            $('#editKhoaForm').on('submit', function (e) {
                e.preventDefault();

                var form = $(this);
                $.ajax({
                    type: "POST",
                    url: "/admin/khoa/save_khoa.php",
                    data: form.serialize() + '&action=edit',
                    success: function (response) {
                        loadKhoas(); // Reload danh sách khoa sau khi sửa thành công
                        $('#editKhoaModal').modal('hide'); // Đóng modal sửa khoa
                        showToast('success', response); // Hiển thị toast thông báo thành công
                    },
                    error: function (xhr, status, error) {
                        console.error('Lỗi khi sửa khoa:', error); // Log lỗi vào console để kiểm tra
                        showToast('error', 'Đã xảy ra lỗi khi sửa khoa. Vui lòng thử lại.'); // Hiển thị toast thông báo lỗi
                    }
                });
            });

            // Hàm load danh sách khoa
            function loadKhoas(page) {
                $.ajax({
                    url: "/admin/khoa/fetch_khoas.php",
                    type: "POST",
                    data: { page: page },
                    success: function (data) {
                        $("#khoa-table").html(data);
                    }
                });
            }

            // Click vào nút phân trang
            $(document).on('click', '.pagination .btn', function () {
                var page = $(this).data('page');
                loadKhoas(page);
            });
        });
    </script>
</body>

</html>