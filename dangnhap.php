<?php
        include('inc/database.php');
        ob_start();
        _header('Đăng nhập');
        _navbar();
        login();
        _footer();
    ?>
