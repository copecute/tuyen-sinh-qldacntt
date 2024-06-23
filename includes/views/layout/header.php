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
    <meta property="og:url" content="localhost">
    <meta property="og:type" content="website">
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
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="/">Tuyển Sinh</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive"
                aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ml-auto">

                    <?php if (isset($_SESSION['account_id']) && ($userLevel == 1)): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="/admin">Quản trị</a>
                        </li>
                    <?php endif; ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/">Trang chủ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/tuyensinh.php">Đăng ký hồ sơ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/tracuu.php">Tra cứu</a>
                    </li>
                    <li class="nav-item">
                        <?php if (isset($_SESSION['account_id'])): ?>
                            <a class="nav-link" href="/logout.php">Đăng xuất</a>
                        <?php else: ?>
                            <a class="nav-link" href="/login.php">Đăng nhập</a>
                        <?php endif; ?>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container">
