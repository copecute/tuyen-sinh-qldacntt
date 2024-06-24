<?php
//                       _oo0oo_
//                      o8888888o
//                      88" . "88
//                      (| -_- |)
//                      0\  =  /0
//                    ___/`---'\___
//                  .' \\|     |// '.
//                 / \\|||  :  |||// \
//                / _||||| -:- |||||- \
//               |   | \\\  -  /// |   |
//               | \_|  ''\---/''  |_/ |
//               \  .-\__  '-'  ___/-. /
//             ___'. .'  /--.--\  `. .'___
//          ."" '<  `.___\_<|>_/___.' >' "".
//         | | :  `- \`.;`\ _ /`;.`/ - ` : | |
//         \  \ `_.   \_ __\ /__ _/   .-` /  /
//     =====`-.____`.___ \_____/___.-`___.-'=====
//                       `=---='
//
//     ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//            amen đà phật copecute 
//     ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
require_once ($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/functions.php');

renderHeader("Quản lý lớp");
?>
    <div class="container mt-5">
        <h2 class="mb-4">Quản lý Lớp</h2>
        <div class="row mb-3">
            <div class="col">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addLopModal" data-action="add">Thêm Lớp</button>
            </div>
            <div class="col-md-4">
                <input type="text" class="form-control" id="searchInput" placeholder="Tìm kiếm Lớp...">
            </div>
        </div>
        <div id="lop-table">
            <!-- Bảng hiển thị danh sách Lớp -->
        </div>
    </div>

    <!-- Add Lớp Modal -->
    <div class="modal fade" id="addLopModal" tabindex="-1" role="dialog" aria-labelledby="addLopModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="addLopForm">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addLopModalLabel">Thêm Lớp Mới</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="khoa_id">Khoa</label>
                            <select class="form-control" id="khoa_id" name="khoa_id" required>
                                <!-- Options sẽ được tải động từ cơ sở dữ liệu -->
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="nghanh_id">Ngành</label>
                            <select class="form-control" id="nghanh_id" name="nghanh_id" required disabled>
                                <!-- Options sẽ được tải động từ cơ sở dữ liệu -->
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="ten_lop">Tên Lớp</label>
                            <input type="text" class="form-control" id="ten_lop" name="ten_lop" required>
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

    <!-- Edit Lớp Modal -->
    <div class="modal fade" id="editLopModal" tabindex="-1" role="dialog" aria-labelledby="editLopModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="editLopForm">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editLopModalLabel">Sửa Lớp</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="edit_khoa_id">Khoa</label>
                            <select class="form-control" id="edit_khoa_id" name="edit_khoa_id" required>
                                <!-- Options sẽ được tải động từ cơ sở dữ liệu -->
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="edit_nghanh_id">Ngành</label>
                            <select class="form-control" id="edit_nghanh_id" name="edit_nghanh_id" required disabled>
                                <!-- Options sẽ được tải động từ cơ sở dữ liệu -->
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="edit_ten_lop">Tên Lớp</label>
                            <input type="text" class="form-control" id="edit_ten_lop" name="edit_ten_lop" required>
                            <input type="hidden" id="edit_lop_id" name="edit_lop_id">
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
    <!-- Script AJAX để thực hiện thêm, sửa, xoá và tìm kiếm lớp -->
    <script>
        $(document).ready(function () {
            // Tải danh sách lớp khi trang được load
            loadLops();

            // Tải danh sách khoa cho modal thêm và sửa lớp
            function loadKhoas() {
                $.ajax({
                    url: "/admin/lop/fetch_khoas.php",
                    type: "GET",
                    success: function (data) {
                        var khoaOptions = JSON.parse(data);
                        $('#khoa_id').html(khoaOptions);
                        $('#edit_khoa_id').html(khoaOptions);
                    }
                });
            }

            loadKhoas(); // Gọi hàm để tải danh sách khoa

            // Khi chọn khoa, tải danh sách ngành tương ứng
            $('#khoa_id').change(function () {
                var khoa_id = $(this).val();
                if (khoa_id) {
                    loadNganhs(khoa_id, '#nghanh_id');
                    $('#nghanh_id').prop('disabled', false);
                } else {
                    $('#nghanh_id').html('<option value="">Chọn Ngành</option>').prop('disabled', true);
                }
            });

            $('#edit_khoa_id').change(function () {
                var khoa_id = $(this).val();
                if (khoa_id) {
                    loadNganhs(khoa_id, '#edit_nghanh_id');
                    $('#edit_nghanh_id').prop('disabled', false);
                } else {
                    $('#edit_nghanh_id').html('<option value="">Chọn Ngành</option>').prop('disabled', true);
                }
            });

            // Hàm AJAX để tải danh sách ngành theo khoa
            function loadNganhs(khoa_id, selectElement) {
                $.ajax({
                    url: "/admin/lop/fetch_nghanhs.php",
                    type: "GET",
                    data: { khoa_id: khoa_id },
                    success: function (data) {
                        var nghanhOptions = JSON.parse(data);
                        $(selectElement).html(nghanhOptions);
                    }
                });
            }

            // Submit form thêm lớp
            $('#addLopForm').on('submit', function (e) {
                e.preventDefault();

                var form = $(this);
                $.ajax({
                    type: "POST",
                    url: "/admin/lop/save.php",
                    data: form.serialize() + '&action=add',
                    success: function (response) {
                        loadLops(); // Reload danh sách sau khi thêm thành công
                        $('#addLopModal').modal('hide'); // Đóng modal thêm
                        showToast('success', response); // Hiển thị toast thông báo thành công
                    },
                    error: function (xhr, status, error) {
                        console.error('Lỗi khi thêm lớp:', error); // Log lỗi vào console để kiểm tra
                        showToast('error', 'Đã xảy ra lỗi khi thêm lớp. Vui lòng thử lại.'); // Hiển thị toast thông báo lỗi
                    }
                });
            });

            // Tìm kiếm
            $('#searchInput').on('keyup', function () {
                var searchText = $(this).val();
                loadLops(searchText);
            });

            // Hàm tải danh sách lớp
            function loadLops(search = '', page = 1, nghanh_id = null) {
                $.ajax({
                    url: "/admin/lop/fetch_lops.php",
                    type: "POST",
                    data: { search: search, page: page, nghanh_id: nghanh_id },
                    success: function (data) {
                        $("#lop-table").html(data);
                    }
                });
            }

            // Hiển thị modal sửa với dữ liệu lớp
            $(document).on('click', '.editLopBtn', function () {
                var lop_id = $(this).data('id');
                $.ajax({
                    url: "/admin/lop/get_lop.php",
                    type: "POST",
                    data: { id: lop_id },
                    success: function (data) {
                        var lop = JSON.parse(data);
                        $('#edit_lop_id').val(lop.id);
                        $('#edit_ten_lop').val(lop.ten_lop);
                        $('#edit_khoa_id').val(lop.khoa_id).trigger('change'); // Gọi trigger để load ngành
                        $('#edit_nghanh_id').val(lop.nghanh_id);
                        $('#editLopModal').modal('show');
                    }
                });
            });

            // Submit form sửa lớp
            $('#editLopForm').on('submit', function (e) {
                e.preventDefault();

                var form = $(this);
                $.ajax({
                    type: "POST",
                    url: "/admin/lop/save.php",
                    data: form.serialize() + '&action=edit',
                    success: function (response) {
                        loadLops(); // Reload danh sách sau khi sửa thành công
                        $('#editLopModal').modal('hide'); // Đóng modal sửa
                        showToast('success', response); // Hiển thị toast thông báo thành công
                    },
                    error: function (xhr, status, error) {
                        console.error('Lỗi khi sửa lớp:', error); // Log lỗi vào console để kiểm tra
                        showToast('error', 'Đã xảy ra lỗi khi sửa lớp. Vui lòng thử lại.'); // Hiển thị toast thông báo lỗi
                    }
                });
            });

            // Xoá lớp
            $(document).on('click', '.deleteLopBtn', function () {
                var lop_id = $(this).data('id');
                if (confirm('Bạn có chắc chắn muốn xóa lớp này?')) {
                    $.ajax({
                        url: "/admin/lop/delete.php",
                        type: "POST",
                        data: { id: lop_id },
                        success: function (response) {
                            loadLops(); // Reload danh sách sau khi xóa thành công
                            showToast('success', response); // Hiển thị toast thông báo thành công
                        },
                        error: function (xhr, status, error) {
                            console.error('Lỗi khi xóa lớp:', error); // Log lỗi vào console để kiểm tra
                            showToast('error', 'Đã xảy ra lỗi khi xóa lớp. Vui lòng thử lại.'); // Hiển thị toast thông báo lỗi
                        }
                    });
                }
            });

            // Hiển thị thông báo
            function showToast(type, message) {
                toastr[type](message);
            }
        });
    </script>
<?php renderFooter(); ?>