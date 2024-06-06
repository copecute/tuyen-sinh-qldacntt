<?php
require_once ($_SERVER['DOCUMENT_ROOT'] . '/includes/config.php');
function renderHeader($title = "Your Website Title", $description = "Your website description here", $keywords = "keyword1, keyword2, keyword3") {
    // Tạo các biến để truyền vào header.php
    $metaTitle = htmlspecialchars($title);
    $metaDescription = htmlspecialchars($description);
    $metaKeywords = htmlspecialchars($keywords);
    
    include ($_SERVER['DOCUMENT_ROOT'] . '/includes/views/layout/header.php');
}

function renderFooter() {
    include ($_SERVER['DOCUMENT_ROOT'] . '/includes/views/layout/footer.php');
}
?>