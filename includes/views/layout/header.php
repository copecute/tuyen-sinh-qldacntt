<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo $metaDescription; ?>">
    <meta name="keywords" content="<?php echo $metaKeywords; ?>">
    <meta name="author" content="CLUB THỊT CHÓ BÁCH KHOA">
    <title><?php echo $metaTitle; ?></title>
    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="<?php echo $metaTitle; ?>">
    <meta property="og:description" content="<?php echo $metaDescription; ?>">
    <script src="/resources/js/jquery-3.5.1.min.js"></script>
    <link rel="shortcut icon" type="image/x-icon" href="/resources/images/fav.png">
    <!-- fontawesome 6.4.2 -->
    <link rel="stylesheet" href="/resources/css/plugins/fontawesome-6.css">
    <!-- swiper Css 10.2.0 -->
    <link rel="stylesheet" href="/resources/css/plugins/swiper.min.css">
    <!-- magnific popup css -->
    <link rel="stylesheet" href="/resources/css/vendor/magnific-popup.css">
    <!-- Bootstrap 5.0.2 -->
    <link rel="stylesheet" href="/resources/css/vendor/bootstrap.min.css">
    <!-- jquery ui css -->
    <!-- <link rel="stylesheet" href="/resources/css/vendor/jquery-ui.css"> -->
    <!-- metismenu scss -->
    <link rel="stylesheet" href="/resources/css/vendor/metismenu.css">
    <!-- custom style css -->
    <link rel="stylesheet" href="/resources/css/style.css">
</head>

<body>
    <!-- IntroJS -->
    <script src="/resources/js/intro.min.js"></script>
    <link href="/resources/css/introjs.min.css" rel="stylesheet">

    <header class="header-one header--sticky">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="header-one-wrapper">
                        <div class="left-side-header">
                            <a href="/" class="logo-area">
                                <img src="/resources/images/logo/logo.png" alt="logo">
                            </a>
                        </div>


                        <div class="main-nav-one">
                            <nav>
                                <ul>
                                    <li style="position: static;">
                                        <a class="nav-link" href="/">Trang chủ</a>
                                    </li>

                                    <li class="has-dropdown" style="position: static;">
                                        <a class="nav-link" href="#">Thông tin</a>
                                        <ul class="megamenu-hub min-mega shape-move">
                                            <li>
                                                <ul>
                                                    <li class="parent"><a href="#">Chuyện của HPC</a></li>
                                                    <li><a class="mobile-menu-link" href="#">Chuyện giảng viên</a>
                                                    </li>
                                                    <li><a class="mobile-menu-link" href="#">Chuyện sinh viên</a></li>
                                                    <li><a class="mobile-menu-link" href="#">Chuyện cựu sinh viên</a>
                                                    </li>
                                                    <li><a class="mobile-menu-link" href="#">Media</a></li>
                                                </ul>
                                                <ul>
                                                    <li class="parent"><a href="#">Tiện ích</a></li>
                                                    <li><a class="mobile-menu-link" href="#">VĂN PHÒNG 1 CỬA DÀNH CHO
                                                            CB-GV</a></li>
                                                    <li><a class="mobile-menu-link" href="#">VĂN
                                                            PHÒNG 1 CỬA HPC DÀNH CHO SV2</a></li>
                                                    <li><a class="mobile-menu-link" href="#">CỔNG
                                                            THÔNG TIN SINH VIÊN</a></li>
                                                    <li><a class="mobile-menu-link" href="#">HỆ THỐNG HỌC TRỰC TUYẾN</a>
                                                    </li>
                                                </ul>
                                                <ul>
                                                    <li class="parent"><a href="#">Du học</a></li>
                                                    <li><a href="#">Du học Hàn Quốc</a></li>
                                                    <li><a href="#">Du học Nhật bản</a></li>
                                                    <li><a href="#">Du học CHLB Đức</a></li>
                                                    <li><a href="#">Du học Đài Loan</a></li>
                                                    <li><a href="#">Hợp tác quốc tế</a></li>
                                                </ul>
                                                <div class="thumbnav-area">
                                                    <!-- single thumbnav -->
                                                    <a href="/tuyensinh.php" class="single-thumbnav">
                                                        <div class="icon">
                                                            <img src="/resources/images/nav/04.png" alt="nav">
                                                        </div>
                                                        <span>Đăng ký xét tuyển</span>
                                                    </a>
                                                    <!-- single thumbnav end -->
                                                    <!-- single thumbnav -->
                                                    <a href="/tracuu.php" class="single-thumbnav mash">
                                                        <div class="icon">
                                                            <img src="/resources/images/nav/05.png" alt="nav">
                                                        </div>
                                                        <span>Tra cứu hồ sơ</span>
                                                    </a>
                                                    <!-- single thumbnav end -->
                                                    <!-- single thumbnav -->
                                                    <a href="/login.php" class="single-thumbnav">
                                                        <div class="icon">
                                                            <img src="/resources/images/nav/06.png" alt="nav">
                                                        </div>
                                                        <span>Đăng nhập sinh viên</span>
                                                    </a>
                                                    <!-- single thumbnav end -->
                                                </div>
                                            </li>
                                        </ul>
                                    </li>
                                    <li>
                                        <a class="nav-link" href="/tracuu.php" id="intro-step2"
                                            class="rts-btn btn-primary">Tra cứu</a>
                                    </li>

                                    <li>
                                        <a class="nav-link" href="#" class="rts-btn btn-primary">Tuyển dụng</a>
                                    </li>

                                    <li>
                                        <a class="nav-link" <?php $currentUrl = $_SERVER['REQUEST_URI'];
                                        if ($currentUrl !== '/' && $currentUrl !== '/index.php') {
                                            echo 'onclick="introJs().start()"';
                                        } else {
                                            echo 'onclick="startIntro()"';
                                        } ?>
                                            class="rts-btn btn-primary">Hướng dẫn</a>
                                    </li>

                                    <li>
                                        <a class="nav-link" href="#" class="rts-btn btn-primary">Giới thiệu</a>
                                    </li>
                                </ul>
                            </nav>
                        </div>


                        <div class="main-nav-one">
                        </div>
                        <div class="header-right-area-one">
                            <div class="actions-area">
                                <div class="search-btn" id="search">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 22 22"
                                        fill="none">
                                        <path
                                            d="M19.9375 18.9652L14.7454 13.7732C15.993 12.2753 16.6152 10.3542 16.4824 8.40936C16.3497 6.46453 15.4722 4.64575 14.0326 3.33139C12.593 2.01702 10.7021 1.30826 8.75326 1.35254C6.8044 1.39683 4.94764 2.19075 3.56924 3.56916C2.19083 4.94756 1.39691 6.80432 1.35263 8.75317C1.30834 10.702 2.0171 12.5929 3.33147 14.0325C4.64584 15.4721 6.46461 16.3496 8.40944 16.4823C10.3543 16.6151 12.2754 15.993 13.7732 14.7453L18.9653 19.9374L19.9375 18.9652ZM2.75 8.93742C2.75 7.71365 3.11289 6.51736 3.79278 5.49983C4.47267 4.4823 5.43903 3.68923 6.56965 3.22091C7.70026 2.7526 8.94436 2.63006 10.1446 2.86881C11.3449 3.10756 12.4474 3.69686 13.3127 4.56219C14.1781 5.42753 14.7674 6.53004 15.0061 7.7303C15.2449 8.93055 15.1223 10.1747 14.654 11.3053C14.1857 12.4359 13.3926 13.4022 12.3751 14.0821C11.3576 14.762 10.1613 15.1249 8.9375 15.1249C7.29703 15.1231 5.72427 14.4706 4.56429 13.3106C3.4043 12.1506 2.75182 10.5779 2.75 8.93742Z"
                                            fill="#553CDF" />
                                    </svg>
                                </div>
                            </div>

                            <div class="buttons-area">
                                <a href="login.php" id="intro-step3" class="rts-btn btn-border">Đăng nhập</a>
                                <a href="/tuyensinh.php" id="intro-step1" class="rts-btn btn-primary"
                                    style="animation-name: pulse;animation-delay: 0s;animation-duration: 1s;animation-iteration-count: infinite;">ĐĂNG
                                    KÝ XÉT TUYỂN</a>
                            </div>
                            <div class="menu-btn" id="menu-btn">
                                <svg width="20" height="16" viewBox="0 0 20 16" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <rect y="14" width="20" height="2" fill="#1F1F25"></rect>
                                    <rect y="7" width="20" height="2" fill="#1F1F25"></rect>
                                    <rect width="20" height="2" fill="#1F1F25"></rect>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <div class="container" style="padding:0px 0px 150px 0px;">