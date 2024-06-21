<?php
require_once ($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Nghành</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Toast CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
</head>

<body>
    <div class="container mt-5">
        <h2 class="mb-4">Quản lý Nghành</h2>
        <div class="row mb-3">
            <div class="col">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addNghanhModal" data-action="add">Thêm Nghành</button>
            </div>
            <div class="col-md-4">
                <input type="text" class="form-control" id="searchInput" placeholder="Tìm kiếm Nghành...">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <select class="form-control" id="khoaFilter">
                    <option value="">Tất cả Khoa</option>
                    <?php
                    // Fetch all "khoa" from the database
                    $query = "SELECT * FROM khoa";
                    $stmt = $conn->prepare($query);
                    $stmt->execute();
                    $khoas = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($khoas as $khoa) {
                        echo '<option value="' . $khoa['id'] . '">' . $khoa['ten_khoa'] . '</option>';
                    }
                    ?>
                </select>
            </div>
        </div>
        <div id="nghanh-table">
            <!-- Bảng hiển thị danh sách Nghành -->
        </div>
    </div>

    <!-- Add Nghành Modal -->
    <div class="modal fade" id="addNghanhModal" tabindex="-1" role="dialog" aria-labelledby="addNghanhModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="addNghanhForm">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addNghanhModalLabel">Thêm Nghành Mới</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="ten_nghanh">Tên Nghành</label>
                            <input type="text" class="form-control" id="ten_nghanh" name="ten_nghanh" required>
                            <label for="khoa_id">Khoa</label>
                            <select class="form-control" id="khoa_id" name="khoa_id" required>
                                <?php
                                foreach ($khoas as $khoa) {
                                    echo '<option value="' . $khoa['id'] . '">' . $khoa['ten_khoa'] . '</option>';
                                }
                                ?>
                            </select>
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

    <!-- Edit Nghành Modal -->
    <div class="modal fade" id="editNghanhModal" tabindex="-1" role="dialog" aria-labelledby="editNghanhModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="editNghanhForm">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editNghanhModalLabel">Sửa Nghành</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="edit_ten_nghanh">Tên Nghành</label>
                            <input type="text" class="form-control" id="edit_ten_nghanh" name="edit_ten_nghanh" required>
                            <input type="hidden" id="edit_nghanh_id" name="edit_nghanh_id">
                        </div>
                        <div class="form-group">
                            <label for="edit_khoa_id">Khoa</label>
                            <select class="form-control" id="edit_khoa_id" name="edit_khoa_id" required>
                                <?php
                                foreach ($khoas as $khoa) {
                                    echo '<option value="' . $khoa['id'] . '">' . $khoa['ten_khoa'] . '</option>';
                                }
                                ?>
                            </select>
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
    <!-- Script AJAX để thực hiện thêm, sửa, xoá và tìm kiếm nghành -->
    <script>
        $(document).ready(function () {
            // Tải danh sách nghành khi trang được load
            loadNghanh();

            // Submit form thêm nghành
            $('#addNghanhForm').on('submit', function (e) {
                e.preventDefault();

                var form = $(this);
                $.ajax({
                    type: "POST",
                    url: "/admin/nghanh/save.php",
                    data: form.serialize() + '&action=add',
                    success: function (response) {
                        loadNghanh(); // Reload danh sách sau khi thêm thành công
                        $('#addNghanhModal').modal('hide'); // Đóng modal thêm
                        showToast('success', response); // Hiển thị toast thông báo thành công
                    },
                    error: function (xhr, status, error) {
                        console.error('Lỗi khi thêm nghành:', error); // Log lỗi vào console để kiểm tra
                        showToast('error', 'Đã xảy ra lỗi khi thêm Nghành. Vui lòng thử lại.'); // Hiển thị toast thông báo lỗi
                    }
                });
            });

            // Tìm kiếm nghành
            $('#searchInput').on('keyup', function () {
                var searchText = $(this).val().toLowerCase();
                $.ajax({
                    url: "/admin/nghanh/fetch.php",
                    type: "POST",
                    data: { search: searchText, khoa_id: $('#khoaFilter').val() },
                    success: function (data) {
                        $("#nghanh-table").html(data);
                    }
                });
            });

            // Lọc theo khoa
            $('#khoaFilter').on('change', function () {
                loadNghanh();
            });

            // Xử lý khi click vào phân trang
            $(document).on('click', '.pagination a.page-link', function (e) {
                e.preventDefault();
                var page = $(this).data('page');
                loadNghanh(page);
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

            // Hàm AJAX để load danh sách nghành
            function loadNghanh(page) {
                $.ajax({
                    url: "/admin/nghanh/fetch.php",
                    type: "POST",
                    data: {
                        page: page,
                        search: $('#searchInput').val(),
                        khoa_id: $('#khoaFilter').val()
                    },
                    success: function (data) {
                        $("#nghanh-table").html(data);
                    }
                });
            }

            // Sửa nghành
            $(document).on('click', '.edit-btn', function () {
                var nghanh_id = $(this).data('nghanh_id');
                var ten_nghanh = $(this).data('ten_nghanh');
                var khoa_id = $(this).data('khoa_id');
                $('#edit_nghanh_id').val(nghanh_id);
                $('#edit_ten_nghanh').val(ten_nghanh);
                $('#edit_khoa_id').val(khoa_id);
                $('#editNghanhModal').modal('show');
            });

            $('#editNghanhForm').on('submit', function (e) {
                e.preventDefault();

                var form = $(this);
                $.ajax({
                    type: "POST",
                    url: "/admin/nghanh/save.php",
                    data: form.serialize() + '&action=edit',
                    success: function (response) {
                        loadNghanh(); // Reload danh sách sau khi sửa thành công
                        $('#editNghanhModal').modal('hide'); // Đóng modal sửa
                        showToast('success', response); // Hiển thị toast thông báo thành công
                    },
                    error: function (xhr, status, error) {
                        console.error('Lỗi khi sửa:', error); // Log lỗi vào console để kiểm tra
                        showToast('error', 'Đã xảy ra lỗi khi sửa nghành. Vui lòng thử lại.'); // Hiển thị toast thông báo lỗi
                    }
                });
            });

            // Xóa nghành
            $(document).on('click', '.delete-btn', function () {
                var nghanh_id = $(this).data('nghanh_id');
                if (confirm('Bạn có chắc chắn muốn xóa nghành này không?')) {
                    $.ajax({
                        type: "POST",
                        url: "/admin/nghanh/delete.php",
                        data: { nghanh_id: nghanh_id },
                        success: function (response) {
                            loadNghanh(); // Reload danh sách sau khi xóa thành công
                            showToast('success', response); // Hiển thị toast thông báo thành công
                        },
                        error: function (xhr, status, error) {
                            console.error('Lỗi khi xóa nghành:', error); // Log lỗi vào console để kiểm tra
                            showToast('error', 'Đã xảy ra lỗi khi xóa nghành. Vui lòng thử lại.'); // Hiển thị toast thông báo lỗi
                        }
                    });
                }
            });
        });
    </script>
</body>

</html>
