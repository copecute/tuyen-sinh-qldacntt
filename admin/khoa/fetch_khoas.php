<?php
require_once ($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');

// Số mục trên mỗi trang
$records_per_page = 10;

// Xác định trang hiện tại
$page = isset($_POST['page']) ? $_POST['page'] : 1;

// Tính vị trí bắt đầu của mục trong CSDL
$start_from = ($page - 1) * $records_per_page;

// Tìm kiếm
$searchText = isset($_POST['search']) ? $_POST['search'] : '';

// Query lấy danh sách khoa với LIMIT và OFFSET và điều kiện tìm kiếm
$query = "SELECT * FROM khoa";
$whereClause = "";

if (!empty($searchText)) {
    $whereClause = " WHERE ten_khoa LIKE :searchText";
    $query .= $whereClause;
}

$query .= " LIMIT $start_from, $records_per_page";

$stmt = $conn->prepare($query);

if (!empty($searchText)) {
    $searchParam = "%$searchText%";
    $stmt->bindParam(':searchText', $searchParam, PDO::PARAM_STR);
}

$stmt->execute();
$khoas = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Tính tổng số trang
$query_count = "SELECT COUNT(*) AS total_rows FROM khoa $whereClause";
$stmt_count = $conn->prepare($query_count);

if (!empty($searchText)) {
    $stmt_count->bindParam(':searchText', $searchParam, PDO::PARAM_STR);
}

$stmt_count->execute();
$row_count = $stmt_count->fetch(PDO::FETCH_ASSOC);
$total_rows = $row_count['total_rows'];
$total_pages = ceil($total_rows / $records_per_page);
?>

<table class="table table-bordered">
    <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Tên Khoa</th>
            <th scope="col">Thao tác</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($stmt->rowCount() > 0): ?>
            <?php foreach ($khoas as $khoa): ?>
                <tr>
                    <td><?php echo $khoa['id']; ?></td>
                    <td><?php echo $khoa['ten_khoa']; ?></td>
                    <td>
                        <button class="btn btn-primary view-nganh" data-khoa_id="<?php echo $khoa['id']; ?>">Xem Ngành</button>
                        <button class="btn btn-info edit-btn" data-khoa_id="<?php echo $khoa['id']; ?>" data-ten_khoa="<?php echo $khoa['ten_khoa']; ?>">Sửa</button>
                        <button class="btn btn-danger delete-btn" data-khoa_id="<?php echo $khoa['id']; ?>">Xoá</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="3">Không có dữ liệu khoa.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<!-- Phân trang -->
<nav aria-label="Page navigation">
    <ul class="pagination justify-content-center">
        <?php if ($page > 1): ?>
            <li class="page-item">
                <button class="page-link" data-page="<?php echo ($page - 1); ?>">Trang trước</button>
            </li>
        <?php endif; ?>
        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                <button class="page-link" data-page="<?php echo $i; ?>"><?php echo $i; ?></button>
            </li>
        <?php endfor; ?>
        <?php if ($page < $total_pages): ?>
            <li class="page-item">
                <button class="page-link" data-page="<?php echo ($page + 1); ?>">Trang sau</button>
            </li>
        <?php endif; ?>
    </ul>
</nav>

<script>
    // Xử lý click vào nút phân trang
    $(document).on('click', '.pagination .page-link', function () {
        var page = $(this).data('page');
        loadKhoas(page);
    });

    // Xem chi tiết Ngành khi click vào nút Xem Ngành
    $(document).on('click', '.view-nganh', function () {
        var khoa_id = $(this).data('khoa_id');
        window.location.href = '/admin/nganh/index.php?khoa=' + khoa_id;
    });

    // Mở modal sửa khoa khi click vào nút Sửa
    $(document).on('click', '.edit-btn', function () {
        var khoa_id = $(this).data('khoa_id');
        var ten_khoa = $(this).data('ten_khoa');
        $('#edit_khoa_id').val(khoa_id);
        $('#edit_ten_khoa').val(ten_khoa);
        $('#editKhoaModal').modal('show');
    });

    // Xoá khoa khi click vào nút Xoá
    $(document).on('click', '.delete-btn', function () {
        var khoa_id = $(this).data('khoa_id');
        if (confirm("Bạn có chắc chắn muốn xoá khoa này?")) {
            $.ajax({
                url: '/admin/khoa/delete_khoa.php',
                type: 'POST',
                data: { id: khoa_id },
                success: function (response) {
                    loadKhoas(); // Reload danh sách khoa sau khi xoá thành công
                    showToast('success', response); // Hiển thị toast thông báo thành công
                },
                error: function (xhr, status, error) {
                    console.error('Lỗi khi xoá khoa:', error); // Log lỗi vào console để kiểm tra
                    showToast('error', 'Đã xảy ra lỗi khi xoá khoa. Vui lòng thử lại.'); // Hiển thị toast thông báo lỗi
                }
            });
        }
    });

    // Tìm kiếm khoa khi nhập từ khóa
    $('#searchInput').on('keyup', function () {
        var searchText = $(this).val().toLowerCase();
        loadKhoas(1, searchText); // Load lại dữ liệu từ trang đầu tiên khi tìm kiếm
    });

    // Hàm AJAX để load danh sách khoa
    function loadKhoas(page = 1, search = '') {
        $.ajax({
            url: "/admin/khoa/fetch_khoas.php",
            type: "POST",
            data: {
                page: page,
                search: search
            },
            success: function (data) {
                $("#khoa-table").html(data);
            }
        });
    }
</script>
