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
    <link rel="shortcut icon" type="image/x-icon" href="/resources/images/fav.png">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <style>
        body {
            padding-top: 56px;
        }
    </style>
</head>

<body>
    <!-- Bootstrap JS và jQuery -->
    <script src="/resources/js/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- IntroJS -->
    <script src="/resources/js/intro.min.js"></script>
    <link href="/resources/css/introjs.min.css" rel="stylesheet">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="/admin"><img src="/resources/images/fav.png" width="30" height="30"
                    class="d-inline-block align-top"> Admin Panel</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive"
                aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/">Trang chủ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="javascript:history.back()">Trở lại</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" onclick="introJs().start();">Hướng dẫn</a>
                    </li>
                    <li class="nav-item dropdown">
                        <?php if (isset($_SESSION['admin_id'])): ?>
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <!-- <img src="/resources/images/instructor/10.jpg" alt="Avatar" class="rounded-circle" width="30" height="30"> -->
                                <?php if (isset($_SESSION['admin_id']) && ($userLevel == 1)) {
                                    echo "<strong>" . $username . "</strong>";
                                } else {
                                    echo $username;
                                } ?>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="/admin/logout.php">Đăng xuất</a>
                            </div>
                        <?php else: ?>
                            <a class="nav-link" href="/admin/login.php">Đăng nhập</a>
                        <?php endif; ?>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mb-5 mt-5">