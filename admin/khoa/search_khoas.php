<?php
require_once ($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');

// Số bản ghi trên mỗi trang
$records_per_page = 5;

// Trang hiện tại, mặc định là trang 1
$current_page = isset($_POST['page']) ? intval($_POST['page']) : 1;

// Vị trí bắt đầu lấy dữ liệu từ bảng
$start_from = ($current_page - 1) * $records_per_page;

// Tìm kiếm từ khóa
$search = isset($_POST['search']) ? $_POST['search'] : '';

try {
    if (!empty($search)) {
        // Query tìm kiếm Khoa theo tên
        $stmt = $conn->prepare("SELECT * FROM khoa WHERE ten_khoa LIKE :search ORDER BY id LIMIT :start, :limit");
        $stmt->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
    } else {
        // Query lấy danh sách tất cả Khoa với phân trang
        $stmt = $conn->prepare("SELECT * FROM khoa ORDER BY id LIMIT :start, :limit");
    }

    $stmt->bindParam(':start', $start_from, PDO::PARAM_INT);
    $stmt->bindParam(':limit', $records_per_page, PDO::PARAM_INT);
    
    $stmt->execute();
    $count = $stmt->rowCount();

    if ($count > 0) {
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Hiển thị kết quả dưới dạng bảng
        echo '<table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Tên Khoa</th>
                        <th scope="col">Hành động</th>
                    </tr>
                </thead>
                <tbody>';

        foreach ($result as $row) {
            echo '<tr>
                    <th scope="row">' . $row['id'] . '</th>
                    <td>' . htmlspecialchars($row['ten_khoa']) . '</td>
                    <td>
                        <button type="button" class="btn btn-sm btn-primary view-nganh-btn" 
                                data-khoa_id="' . $row['id'] . '" data-ten_khoa="' . htmlspecialchars($row['ten_khoa']) . '">
                            Xem Ngành
                        </button>
                        <button type="button" class="btn btn-sm btn-info edit-btn" 
                                data-khoa_id="' . $row['id'] . '" data-ten_khoa="' . htmlspecialchars($row['ten_khoa']) . '">
                            Sửa
                        </button>
                        <button type="button" class="btn btn-sm btn-danger delete-btn" 
                                data-khoa_id="' . $row['id'] . '">
                            Xoá
                        </button>
                    </td>
                  </tr>';
        }

        echo '</tbody></table>';

        // Phân trang
        $total_pages = ceil($count / $records_per_page);
        if ($total_pages > 1) {
            echo '<nav aria-label="Page navigation">
                    <ul class="pagination justify-content-center">';
            
            // Previous page button
            if ($current_page > 1) {
                echo '<li class="page-item">
                        <a class="page-link" href="#" data-page="' . ($current_page - 1) . '">Trang trước</a>
                      </li>';
            }

            // Numbered pages
            for ($i = 1; $i <= $total_pages; $i++) {
                echo '<li class="page-item ' . ($i == $current_page ? 'active' : '') . '">
                        <a class="page-link" href="#" data-page="' . $i . '">' . $i . '</a>
                      </li>';
            }

            // Next page button
            if ($current_page < $total_pages) {
                echo '<li class="page-item">
                        <a class="page-link" href="#" data-page="' . ($current_page + 1) . '">Trang tiếp</a>
                      </li>';
            }

            echo '</ul></nav>';
        }
    } else {
        echo '<p class="text-center">Không tìm thấy Khoa nào.</p>';
    }
} catch (PDOException $e) {
    echo 'Lỗi khi tải danh sách Khoa: ' . $e->getMessage();
}
?>
