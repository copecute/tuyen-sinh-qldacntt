<?php
require_once ($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');
renderHeader("Gửi hồ sơ xét tuyển");
?>

<div class="container mt-5 mb-5 exrolled-course-wrapper-dashed">
    <h2>Gửi hồ sơ xét tuyển</h2>
    <form id="applicationForm" data-step="1" data-intro="Điền thông tin hồ sơ xét tuyển của bạn">
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
            <label for="city">Tỉnh/Thành phố:</label>
            <select class="form-control" id="city" name="city" aria-label=".form-select">
                <option value="" selected>Chọn tỉnh thành</option>
            </select>
        </div>
        <div class="form-group">
            <label for="district">Quận/Huyện:</label>
            <select class="form-control" id="district" name="district" aria-label=".form-select">
                <option value="" selected>Chọn quận huyện</option>
            </select>
        </div>
        <div class="form-group">
            <label for="ward">Phường/Xã:</label>
            <select class="form-control" id="ward" name="ward" aria-label=".form-select">
                <option value="" selected>Chọn phường xã</option>
            </select>
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
            <label for="you_are">Bạn đang là:</label>
            <select class="form-control" id="you_are" name="you_are" required>
                <option value="">Lựa chọn</option>
                <option value="1">Học sinh lớp 12</option>
                <option value="2">Người đi làm</option>
                <option value="3">Sinh viên</option>
            </select>
        </div>
        <div class="form-group">
            <label for="major">Ngành học:</label>
            <input type="text" class="form-control" id="major" name="major" required>
        </div>
        <button type="submit" class="btn btn-primary" data-step="2" data-intro="Sau khi đã hoàn tất thông tin, ấn vào nút này để gửi hồ sơ">Gửi hồ sơ xét tuyển</button>
    </form>
</div>

<script>
    $(document).ready(function () {
        $('#applicationForm').submit(function (e) {
            e.preventDefault(); // Ngăn chặn form submit mặc định

            // Lấy dữ liệu từ form
            var formData = $(this).serialize();

            // Gửi AJAX request
            $.ajax({
                type: 'POST',
                url: '/includes/ajax/tuyensinh.php',
                data: formData,
                dataType: 'json', // Kiểu dữ liệu trả về
                success: function (response) {
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
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                    showToast('error', 'Có lỗi xảy ra khi gửi đơn.');
                }
            });
        });
    });
</script>
<script>
    $(document).ready(function () {
        // Sử dụng AJAX để lấy dữ liệu từ file JSON
        $.ajax({
            url: '/includes/ajax/DiaGioiHanhChinhVN.json',
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                renderCity(data);
            },
            error: function (xhr, status, error) {
                console.error('Lỗi khi tải dữ liệu: ' + status + ', ' + error);
            }
        });

        // Hàm render dữ liệu cho dropdown tỉnh/thành phố
        function renderCity(data) {
            var citis = $('#city');
            var districts = $('#district');
            var wards = $('#ward');

            citis.empty().append('<option value="" selected>Chọn tỉnh thành</option>');
            districts.empty().append('<option value="" selected>Chọn quận huyện</option>');
            wards.empty().append('<option value="" selected>Chọn phường xã</option>');

            $.each(data, function (index, city) {
                citis.append('<option value="' + city.Id + '">' + city.Name + '</option>');
            });

            citis.on('change', function () {
                var selectedCityId = $(this).val();
                districts.empty().append('<option value="" selected>Chọn quận huyện</option>');
                wards.empty().append('<option value="" selected>Chọn phường xã</option>');

                if (selectedCityId !== '') {
                    var selectedCity = data.find(function (city) {
                        return city.Id == selectedCityId;
                    });

                    $.each(selectedCity.Districts, function (index, district) {
                        districts.append('<option value="' + district.Id + '">' + district.Name + '</option>');
                    });
                }
            });

            districts.on('change', function () {
                var selectedDistrictId = $(this).val();
                wards.empty().append('<option value="" selected>Chọn phường xã</option>');

                if (selectedDistrictId !== '') {
                    var selectedCityId = citis.val();
                    var selectedCity = data.find(function (city) {
                        return city.Id == selectedCityId;
                    });

                    var selectedDistrict = selectedCity.Districts.find(function (district) {
                        return district.Id == selectedDistrictId;
                    });

                    $.each(selectedDistrict.Wards, function (index, ward) {
                        wards.append('<option value="' + ward.Id + '">' + ward.Name + '</option>');
                    });
                }
            });
        }
    });
</script>

<?php renderFooter(); ?>