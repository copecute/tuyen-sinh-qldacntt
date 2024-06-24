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

renderHeader("Admin Control Panel");
?>
    <div class="container mt-5">
        <h2>Quản lý Sinh viên</h2>
        <div class="row mb-3">
            <div class="col-md-6">
                <input type="text" class="form-control" id="searchInput" placeholder="Tìm kiếm...">
            </div>
            <div class="col-md-6 text-right">
                <a href="add.php" class="btn btn-primary">Thêm mới</a>
            </div>
        </div>
        <div id="studentsTable">
            <!-- Bảng danh sách sinh viên sẽ được load bằng AJAX -->
        </div>
    </div>

    <script>
        $(document).ready(function () {
            loadStudents();

            $('#searchInput').on('keyup', function () {
                loadStudents();
            });

            $(document).on('click', '.pagination a.page-link', function (e) {
                e.preventDefault();
                var page = $(this).data('page');
                loadStudents(page);
            });

            function loadStudents(page) {
                $.ajax({
                    url: "/admin/sinhvien/fetch_students.php",
                    type: "POST",
                    data: {
                        page: page || 1,
                        search: $('#searchInput').val()
                    },
                    success: function (data) {
                        $('#studentsTable').html(data);
                    }
                });
            }
        });
    </script>
<?php renderFooter(); ?>