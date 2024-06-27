<?php
require_once ($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');
renderHeader("Tra cứu kết quả xét tuyển");
?>

<div class="container mt-5 mb-5 exrolled-course-wrapper-dashed">
    <h2 class="text-center mb-4">Tra cứu kết quả xét tuyển</h2>
    <form id="searchForm">
      <div class="form-group" data-step="1" data-intro="Điền số điện thoại trong hồ sơ xét tuyển bạn đã gửi">
        <label for="phone_number">Số điện thoại:</label>
        <input type="text" class="form-control" id="phone_number" name="phone_number" required>
      </div>
      <button type="submit" class="btn btn-primary btn-block" data-step="2" data-intro="Ấn nút này để tra cứu kết quả">
        Tra cứu
        <span class="spinner-border spinner-border-sm sr-only" role="status" aria-hidden="true"></span>
      </button>
    </form>
</div>

<!-- Modal for displaying results -->
<div class="modal fade" id="resultModal" tabindex="-1" aria-labelledby="resultModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="resultModalLabel">Kết quả tra cứu</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="resultContainer">
        <!-- Placeholder for search results -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
      </div>
    </div>
  </div>
</div>

<script>
$(document).ready(function() {
    // Check for sdt parameter in the URL
    const urlParams = new URLSearchParams(window.location.search);
    const sdt = urlParams.get('sdt');
    if (sdt) {
        $('#phone_number').val(sdt);
        fetchResults({ phone_number: sdt });
    }

    $('#searchForm').submit(function(e) {
        e.preventDefault();
        var formData = $(this).serialize();
        showLoading();
        setTimeout(function() {
            fetchResults(formData);
        }, 1000); // 1 second delay
    });

    function fetchResults(formData) {
        $.ajax({
            type: 'POST',
            url: '/includes/ajax/tracuu.php',
            data: formData,
            dataType: 'json',
            success: function(response) {
                hideLoading();
                if (response.status == 'success') {
                    showResult(response.data);
                    $('#resultModal').modal('show');
                } else {
                    showToast('error', response.message);
                }
            },
            error: function(xhr, status, error) {
                hideLoading();
                console.error(xhr.responseText);
                showToast('error', 'Có lỗi xảy ra khi tra cứu.');
            }
        });
    }

    function showResult(data) {
        var html = `<div>
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

    function showLoading() {
        $('#searchForm button').prop('disabled', true);
        $('#searchForm .spinner-border').removeClass('sr-only');
    }

    function hideLoading() {
        $('#searchForm button').prop('disabled', false);
        $('#searchForm .spinner-border').addClass('sr-only');
    }
});
</script>

<?php renderFooter(); ?>
