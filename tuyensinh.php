<?php
require_once ($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');
renderHeader("Gửi hồ sơ xét tuyển");
?>
    <div class="container mt-5 mb-5">
        <h2>Gửi hồ sơ xét tuyển</h2>
        <form id="applicationForm">
            <div class="form-group">
                <label for="fullname">Họ và Tên:</label>
                <input type="text" class="form-control" id="fullname" name="fullname" required>
            </div>
            <div class="form-group">
                <label for="birthday">Ngày Sinh:</label>
                <input type="date" class="form-control" id="birthday" name="birthday" required>
            </div>
            <div class="form-group">
                <label for="permanent_residence">Hộ khẩu thường trú:</label>
                <input type="text" class="form-control" id="permanent_residence" name="permanent_residence" required>
            </div>
            <div class="form-group">
                <label for="phone_number">Số điện thoại:</label>
                <input type="text" class="form-control" id="phone_number" name="phone_number" required>
            </div>
            <div class="form-group">
                <label for="high_school">Trường THPT:</label>
                <input type="text" class="form-control" id="high_school" name="high_school" required>
            </div>
            <div class="form-group">
                <label for="you_are">Bạn là:</label>
                <input type="text" class="form-control" id="you_are" name="you_are" required>
            </div>
            <div class="form-group">
                <label for="major">Ngành học:</label>
                <input type="text" class="form-control" id="major" name="major" required>
            </div>
            <button type="submit" class="btn btn-primary">Gửi Đơn</button>
        </form>
    </div>
    
    <script>
    $(document).ready(function() {
        $('#applicationForm').submit(function(e) {
            e.preventDefault(); // Ngăn chặn form submit mặc định
            
            // Lấy dữ liệu từ form
            var formData = $(this).serialize();
            
            // Gửi AJAX request
            $.ajax({
                type: 'POST',
                url: '/includes/ajax/tuyensinh.php',
                data: formData,
                dataType: 'json', // Kiểu dữ liệu trả về
                success: function(response) {
                    if (response.status == 'success') {
                        // Hiển thị toast khi gửi đơn thành công
                        showToast('success', response.message);
                        // Reset form sau khi gửi thành công
                        $('#applicationForm')[0].reset();
                    } else {
                        // Hiển thị toast khi gửi đơn không thành công
                        showToast('error', response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    showToast('error', 'Có lỗi xảy ra khi gửi đơn.');
                }
            });
        });
    });
</script>

<?php renderFooter(); ?>