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

renderHeader("Quản lý hồ sơ");
?>
<div class="container mt-5">
    <h2 class="mb-4">Quản lý Hồ Sơ</h2>
    <div class="row mb-3">
        <div class="col-md-4">
            <input type="text" class="form-control" id="searchInput" placeholder="Tìm kiếm...">
        </div>
        <div class="col-md-4">
            <select class="form-control" id="filterStatus">
                <option value="">Lọc theo Trạng Thái</option>
                <option value="0">Đang chờ xét duyệt</option>
                <option value="1">Đủ điều kiện nhập học</option>
                <option value="2">Bị từ chối</option>
            </select>
        </div>
        <div class="col-md-4">
            <select class="form-control" id="filterMajor">
                <option value="">Lọc theo Chuyên Ngành</option>
                <!-- Tạo các option từ danh sách chuyên ngành -->
                <?php
                $nghanhQuery = "SELECT id, ten_nghanh FROM nghanh";
                $nghanhStmt = $conn->prepare($nghanhQuery);
                $nghanhStmt->execute();
                $nghanhs = $nghanhStmt->fetchAll(PDO::FETCH_ASSOC);
                foreach ($nghanhs as $nghanh) {
                    echo '<option value="' . $nghanh['id'] . '">' . htmlspecialchars($nghanh['ten_nghanh']) . '</option>';
                }
                ?>
            </select>
        </div>
    </div>
    <div id="applicationsTable">
        <!-- Bảng danh sách hồ sơ sẽ được load bằng AJAX -->
    </div>
</div>

<!-- View Application Modal -->
<div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewModalLabel">Chi tiết hồ sơ</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div id="viewModalBody">
                <!-- Nội dung chi tiết hồ sơ sẽ được tải bằng AJAX -->
            </div>
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
<!-- Script AJAX để thực hiện tìm kiếm và phân trang -->
<script>
    $(document).ready(function () {
        // Load danh sách hồ sơ khi trang được load
        loadApplications();

        // Tìm kiếm hồ sơ
        $('#searchInput').on('keyup', function () {
            loadApplications();
        });

        // Lọc hồ sơ theo trạng thái
        $('#filterStatus').change(function () {
            loadApplications();
        });

        // Lọc hồ sơ theo chuyên ngành
        $('#filterMajor').change(function () {
            loadApplications();
        });

        // Xử lý khi click vào phân trang
        $(document).on('click', '.pagination a.page-link', function (e) {
            e.preventDefault();
            var page = $(this).data('page');
            loadApplications(page);
        });

        // Hàm AJAX để load danh sách hồ sơ
        function loadApplications(page) {
            $.ajax({
                url: "/admin/hoso/fetch_applications.php",
                type: "POST",
                data: {
                    page: page || 1,
                    search: $('#searchInput').val(),
                    filterStatus: $('#filterStatus').val(),
                    filterMajor: $('#filterMajor').val()
                },
                success: function (data) {
                    $('#applicationsTable').html(data); // Thay đổi nội dung của bảng
                }
            });
        }

        // Xem chi tiết hồ sơ
        $(document).on('click', '.view-btn', function () {
            var applicationId = $(this).data('id');
            $.ajax({
                url: "/admin/hoso/view_application.php",
                type: "POST",
                data: { id: applicationId },
                success: function (data) {
                    $('#viewModalBody').html(data); // Thay đổi nội dung modal
                    $('#viewModal').modal('show'); // Hiển thị modal
                }
            });
        });

        // Xóa hồ sơ
        $(document).on('click', '.delete-btn', function () {
            var applicationId = $(this).data('id');
            if (confirm('Bạn có chắc chắn muốn xóa hồ sơ này không?')) {
                $.ajax({
                    url: "/admin/hoso/delete_application.php",
                    type: "POST",
                    data: { id: applicationId },
                    dataType: 'json', // Chỉ định dữ liệu trả về là JSON
                    success: function (response) {
                        if (response.status === 'success') {
                            loadApplications(); // Reload danh sách sau khi xóa thành công
                            showToast('success', response.message); // Hiển thị toast thông báo thành công
                        } else {
                            showToast('error', response.message); // Hiển thị toast thông báo lỗi từ server
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error('Lỗi khi xóa hồ sơ:', error); // Log lỗi vào console để kiểm tra
                        showToast('error', 'Đã xảy ra lỗi khi xóa hồ sơ. Vui lòng thử lại.'); // Hiển thị toast thông báo lỗi
                    }
                });
            }
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
<?php renderFooter() ?>