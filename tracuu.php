<?php
require_once ($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');
renderHeader("Tra cứu kết quả xét tuyển");
?>

        <h2>Tra cứu kết quả xét tuyển</h2>
        <form id="searchForm">
            <div class="form-group">
                <label for="phone_number">Số điện thoại:</label>
                <input type="text" class="copecute-form-control" id="phone_number" name="phone_number" required>
            </div>
            <button type="submit" class="btn btn-primary">Tra cứu</button>
        </form>

        <div id="resultContainer" class="mt-5"></div>

    <script>
        $(document).ready(function() {
            $('#searchForm').submit(function(e) {
                e.preventDefault();

                var formData = $(this).serialize();

                $.ajax({
                    type: 'POST',
                    url: '/includes/ajax/tracuu.php',
                    data: formData,
                    dataType: 'json',
                    success: function(response) {
                        if (response.status == 'success') {
                            showResult(response.data);
                            showToast('success', response.message);
                        } else {
                            showToast('error', response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        showToast('error', 'Có lỗi xảy ra khi tra cứu.');
                    }
                });
            });

            function showResult(data) {
                var html = `<div class="mt-5">
                                <h3>Hồ sơ tuyển sinh</h3>
                                <p><strong>Họ và Tên:</strong> ${data.fullname}</p>
                                <p><strong>Năm sinh:</strong> ${data.birthday}</p>
                                <p><strong>Số điện thoại:</strong> ${data.phone_number}</p>
                                <p><strong>Trường trung học:</strong> ${data.high_school}</p>
                                <p><strong>Ứng tuyển nghành:</strong> ${data.major}</p>
                                <p><strong>Trạng thái:</strong> ${getStatusHtml(data.status)}</p>
                            </div>`;
                $('#resultContainer').html(html);
            }

            function getStatusHtml(status) {
                if (status == 0) {
                    return '<div class="alert alert-warning">Đang xét duyệt</div>';
                } else if (status == 1) {
                    return '<div class="alert alert-success">Đủ điều kiện nhập học</div>';
                } else if (status == 2) {
                    return '<div class="alert alert-danger">Hồ sơ bị từ chối</div>';
                }
                return '';
            }

            function showToast(type, message) {
                toastr.options = {
                    "closeButton": false,
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

<?php renderFooter(); ?>
