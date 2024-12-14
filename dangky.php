<?php
        include('inc/database.php');

        _header('Đăng Ký');
        ob_start();
        _navbar();
        register();
        _footer();
    ?>
