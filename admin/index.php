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
        <h2 class="mb-4">Dashboard Quản Lý Hồ Sơ Nhập Học</h2>
        <div class="row">
            <div class="col-lg-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Quản Lý Khoa</h5>
                        <p class="card-text">Thêm, sửa, xoá, danh sách khoa.</p>
                        <a href="/admin/khoa" class="btn btn-primary">Quản Lý</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Quản Lý Ngành</h5>
                        <p class="card-text">Thêm, sửa, xoá, danh sách ngành.</p>
                        <a href="/admin/nghanh" class="btn btn-primary">Quản Lý</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Quản Lý Lớp</h5>
                        <p class="card-text">Thêm, sửa, xoá, danh sách lớp.</p>
                        <a href="/admin/lop" class="btn btn-primary">Quản Lý</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Quản Lý Hồ sơ tuyển sinh</h5>
                        <p class="card-text">Thêm, sửa, xoá, phê duyệt hồ sơ</p>
                        <a href="/admin/hoso" class="btn btn-primary">Quản Lý</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Quản Lý Sinh viên</h5>
                        <p class="card-text">Tài khoản, Hồ sơ sinh viên</p>
                        <a href="/admin/sinhvien" class="btn btn-primary">Quản Lý</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Thống kê</h5>
                        <p class="card-text">Thống kê báo cáo</p>
                        <a href="/admin/thongke.php" class="btn btn-primary">Xem</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Quản Lý năm tuyển sinh</h5>
                        <p class="card-text">Thêm, sửa, xoá...</p>
                        <a href="/admin/admissions-settings" class="btn btn-primary">Quản Lý</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php renderFooter(); ?>