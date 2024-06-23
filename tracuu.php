<?php
require_once ($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');
renderHeader("Tra cứu");
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tra cứu kết quả hồ sơ</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .container {
            max-width: 800px;
        }
        .mt-5 {
            margin-top: 50px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2>Tra cứu kết quả hồ sơ</h2>
        <form id="searchForm">
            <div class="form-group">
                <label for="phone_number">Số điện thoại:</label>
                <input type="text" class="form-control" id="phone_number" name="phone_number" required>
            </div>
            <button type="submit" class="btn btn-primary">Tra cứu</button>
        </form>

        <div id="resultContainer" class="mt-5"></div>
    </div>

    <!-- Bootstrap JS và jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">

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

<?php renderFooter(); ?>
